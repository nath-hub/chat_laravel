<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ChatController extends Controller
{

    /**
     * Traite l'envoi d'un message et retourne la réponse
     */
    public function send(Request $request)
    {

        if (!Auth::check()) {
            Log::warning('Utilisateur non authentifié dans send()');
            return response()->json(['success' => false, 'message' => 'Non authentifié'], 401);
        }


        // Validation
        $request->validate([
            'message' => 'required|string|max:5000',
            'conversation_id' => 'nullable|exists:conversations,id'
        ]);

        Log::info("la requettes arrive ici");

        $userMessage = $request->input('message');
        $timestamp = Carbon::now();

        Log::info("voici les messages");

        $user = Auth::user();

        if ($request->conversation_id) {
            $conversationId = $request->conversation_id;
        } else {
            $lastConversation = Conversation::where('user_id', $user->id)->latest()->first();

            if ($lastConversation) {
                $conversationId = $lastConversation->id;
            } else {
                $conversationId = (string) Str::uuid();
                Conversation::create([
                    'id' => $conversationId,
                    'user_id' => $user->id,
                    'title' => substr($userMessage, 0, 50)
                ]);
            }
        }


        $message = ChatMessage::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'user_id' => $user->id,
            'role' => 'user',
            'message' => $request->message,
            'conversation_id' => $conversationId
        ]);

        // Récupérer l'historique des messages
        $messages = Session::get('chat_messages', []);

        // Ajouter le message de l'utilisateur
        $messages[] = [
            'role' => 'user',
            'content' => $userMessage,
            'timestamp' => $timestamp->toIso8601String()
        ];

        // Générer la réponse de l'assistant (ici vous intégrerez votre IA)
        $assistantResponse = $this->generateResponse($userMessage, $messages, $conversationId);

        // Ajouter la réponse de l'assistant
        $messages[] = [
            'role' => 'assistant',
            'content' => $assistantResponse,
            'timestamp' => Carbon::now()->toIso8601String()
        ];

        // Sauvegarder dans la session
        Session::put('chat_messages', $messages);

        // Retourner la réponse JSON
        return response()->json([
            'success' => true,
            'response' => $assistantResponse,
            'timestamp' => Carbon::now()->toIso8601String(),
            'message' => 'Message envoyé avec succès'
        ]);
    }

    /**
     * Génère une réponse de l'assistant IA
     *
     * @param string $userMessage
     * @param array $conversationHistory
     * @return string
     */
    private function generateResponse($userMessage, $conversationHistory, $conversationId = null)
    {
        try {
            // Récupérer la clé API depuis le fichier .env
            $apiKey = ENV('OPEN_ROUTER_KEY');

            if (!$apiKey) {
                Log::error('Clé API OpenRouter non configurée');
                return "Configuration manquante. Veuillez contacter l'administrateur.";
            }

            // Préparer les messages pour l'API
            $apiMessages = [
                [
                    'role' => 'system',
                    'content' => 'Tu es un assistant juridique spécialisé dans le droit. Réponds uniquement aux questions liées au droit. Si une question sort du domaine du droit, dis poliment que tu ne peux répondre qu\'aux questions juridiques. Sois clair, précis et professionnel dans tes réponses.'
                ]
            ];

            // Ajouter l'historique de conversation (optionnel, limite aux 10 derniers messages)
            $recentHistory = array_slice($conversationHistory, -10);
            foreach ($recentHistory as $msg) {
                if ($msg['role'] === 'user' || $msg['role'] === 'assistant') {
                    $apiMessages[] = [
                        'role' => $msg['role'],
                        'content' => $msg['content']
                    ];
                }
            }

            // Ajouter le message actuel de l'utilisateur
            $apiMessages[] = [
                'role' => 'user',
                'content' => $userMessage
            ];

            // Effectuer la requête HTTP vers OpenRouter
            $response = Http::timeout(300)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $apiKey,
                    'HTTP-Referer' => config('app.url'), // Optionnel
                    'X-Title' => config('app.name', 'Legal Chat IA'), // Optionnel
                ])
                ->post('https://openrouter.ai/api/v1/chat/completions', [
                    'model' => 'openai/gpt-oss-20b:free',
                    'messages' => $apiMessages,
                    'temperature' => 0.7,
                    'max_tokens' => 2000,
                ]);

            // Vérifier si la requête a réussi
            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['choices'][0]['message']['content'])) {


                    $message = ChatMessage::create([
                        'id' => (string) \Illuminate\Support\Str::uuid(),
                        'user_id' => Auth::user()->id,
                        'role' => 'assistant',
                        'message' => $data['choices'][0]['message']['content'],
                        'conversation_id' => $conversationId
                    ]);

                    return $data['choices'][0]['message']['content'];
                } else {
                    Log::error('Format de réponse OpenRouter invalide', ['data' => $data]);
                    return "Je n'ai pas pu générer une réponse. Veuillez réessayer.";
                }
            } else {
                Log::error('Erreur API OpenRouter', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return "Une erreur s'est produite lors de la communication avec le service IA. Veuillez réessayer.";
            }

        } catch (\Exception $e) {
            Log::error('Exception lors de l\'appel OpenRouter: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return "Je rencontre actuellement des difficultés techniques. Veuillez réessayer dans quelques instants.";
        }
    }



    /**
     * Efface l'historique de conversation
     */
    public function clearHistory()
    {
        Session::forget('chat_messages');

        return response()->json([
            'success' => true,
            'message' => 'Historique effacé avec succès'
        ]);
    }

    /**
     * Exporte l'historique de conversation
     */
    public function exportHistory()
    {
        $messages = Session::get('chat_messages', []);

        $content = "Historique de conversation - Legal Chat IA\n";
        $content .= "Généré le : " . Carbon::now()->format('d/m/Y H:i:s') . "\n";
        $content .= str_repeat("=", 50) . "\n\n";

        foreach ($messages as $msg) {
            $role = $msg['role'] === 'user' ? 'Vous' : 'Assistant';
            $time = Carbon::parse($msg['timestamp'])->format('H:i');
            $content .= "[$time] $role :\n";
            $content .= $msg['content'] . "\n\n";
            $content .= str_repeat("-", 50) . "\n\n";
        }

        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="conversation_' . Carbon::now()->format('Y-m-d_His') . '.txt"');
    }
}
