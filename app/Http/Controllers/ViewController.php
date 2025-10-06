<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\FileUploaded;
use App\Models\ChatMessage;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Nette\Utils\Random;

class ViewController extends Controller
{
    public function index()
    {

        $cards = [
            [
                "icon" => "",
                "titre" => "Expertise juridique",
                "test" => "Réponses basées sur le droit français et la jurisprudence actuelle",
                "color" => "#FDE68A"
            ],
            [
                "icon" => "",
                "titre" => "Réponses instantanées",
                "test" => "Obtenez des réponses précises en quelques secondes",
                "color" => "#FDE68A"
            ],
            [
                "icon" => "",
                "titre" => "Confidentialité totale",
                "test" => "Vos conversations sont privées et sécurisées",
                "color" => "#FDE68A"
            ],
            [
                "icon" => "",
                "titre" => "Support 24/7",
                "test" => "Assistance juridique disponible à tout moment",
                "color" => "#FDE68A"
            ],
        ];

        $stats = [
            ['number' => '10k+', 'text' => 'Questions traitées'],
            ['number' => '98%', 'text' => 'Satisfaction client'],
            ['number' => '24/7', 'text' => 'Disponibilité'],
        ];

        return view('welcome', compact('cards', 'stats'));
    }

    public function login()
    {
        return view('login'); // ou la bonne vue
    }


    function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'username' => 'required|string|max:255',
        ]);

        // Génération d’un code aléatoire à 6 chiffres
        $code = \Nette\Utils\Random::generate(6, '0-9');

        // Envoi de l'email
        Mail::to($request->email)
            ->send(new FileUploaded($code, $request->username));

        // Création ou mise à jour de l'utilisateur
        $user = User::updateOrCreate(
            ['email' => $request->email],
            [
                'id' => (string) \Illuminate\Support\Str::uuid(),
                'username' => $request->username,
                'otp' => $code
            ]
        );

        $email = $request->email; // Assurez-vous que cette variable est définie
        $email = $request->email;

        return redirect()
            ->route('verify', ['email' => $email])
            ->with('success', 'Connexion réussie ! Veuillez vérifier votre email.');

    }


    public function verify(Request $request)
    {
        $id = session('user_id');

        $messages = ChatMessage::where('user_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        $conversationId = $messages->first()->conversation_id ?? null;

        $activeConversationId = $conversationId;

        $conversations = Conversation::where('user_id', session('user_id'))->get();

        $user = null;

        $email = $request->query('email'); // Récupère depuis l’URL
        return view('verify', compact('email', 'messages', 'conversations', 'conversationId', 'activeConversationId', 'user'));
    }


    public function otpVerify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|max:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && $user->otp === $request->otp) {

            $user->otp = null; // Invalider le code OTP après vérification
            $user->otp_expiry = null;
            $user->is_active = true; // Marquer l'utilisateur comme actif
            $user->theme = 'light'; // Définir le thème par défaut
            $user->font_size = 14; // Définir la taille de police par défaut
            $user->animation = 1; // Définir l'animation par défaut
            $user->last_connection_date = now(); // Enregistrer la date de la dernière connexion
            $user->language = 'fr'; // Définir la langue par défaut
            $user->save();
            // Code OTP correct, connecter l'utilisateur ou effectuer une autre action
            // Par exemple, vous pouvez créer une session pour l'utilisateur
            session(['user_id' => $user->id]);



            return redirect()->route('home', ['user' => $user])->with('success', 'Connexion réussie !');
        } else {
            return back()->withErrors(['otp' => 'Le code de vérification est incorrect.'])->withInput();
        }
    }


    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'conversation_id' => 'nullable|exists:conversations,id'
        ]);

        $message = ChatMessage::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'user_id' => session('user_id'),
            'role' => 'user',
            'message' => $request->message,
            'conversation_id' => $request->conversation_id
        ]);

        return redirect()->back();
    }

    public function home()
    {
        $id = session('user_id');

        $messages = ChatMessage::where('user_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        $conversationId = $messages->first()->conversation_id ?? null;

        $activeConversationId = $conversationId;


        $suggestions = [
            [
                "text" => "Comment puis-je protéger mes droits d'auteur ?",
                'short' => "Comment protéger mes droits d'auteur ?"
            ],
            [
                "text" => "Quels sont les éléments essentiels d'un contrat de travail ?",
                'short' => "Les éléments d'un contrat de travail ?"
            ],
            [
                "text" => "Quelles sont les étapes pour créer une entreprise en France ?",
                'short' => "étapes pour créer une entreprise ?"
            ],
        ];

        $conversations = Conversation::where('user_id', $id)
            ->orderBy('updated_at', 'desc')
            ->get();


        return view('home', compact('messages', 'suggestions', 'conversationId', 'conversations', 'activeConversationId'));
    }


    public function profil()
    {
        $id = session('user_id');

        $messages = ChatMessage::where('user_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        $conversationId = $messages->first()->conversation_id ?? null;

        $activeConversationId = $conversationId;

        $conversations = Conversation::where('user_id', session('user_id'))->get();

        $user = User::find('286c9c52-d70a-4f5e-9c43-38ef8275bbc7');
        return view('profil', compact('user', 'conversations', 'activeConversationId', 'conversationId', 'messages'));
    }


    public function abonnement()
    {
        $id = session('user_id');

        $messages = ChatMessage::where('user_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        $conversationId = $messages->first()->conversation_id ?? null;

        $activeConversationId = $conversationId;

        $conversations = Conversation::where('user_id', session('user_id'))->get();

        $user = User::find('286c9c52-d70a-4f5e-9c43-38ef8275bbc7');
        return view('abonnement', compact('user', 'conversations', 'activeConversationId', 'conversationId', 'messages'));
    }


    public function show($id)
    {
        $conversations = Conversation::where('user_id', session('user_id'))->get();

        $conversation = Conversation::findOrFail($id);

        $activeConversationId = $conversation->id;

        $messages = ChatMessage::where('conversation_id', $conversation->id)
            ->orderBy('created_at', 'asc')
            ->get();

        $suggestions = [
            [
                "text" => "Comment puis-je protéger mes droits d'auteur ?",
                'short' => "Comment protéger mes droits d'auteur ?"
            ],
            [
                "text" => "Quels sont les éléments essentiels d'un contrat de travail ?",
                'short' => "Les éléments d'un contrat de travail ?"
            ],
            [
                "text" => "Quelles sont les étapes pour créer une entreprise en France ?",
                'short' => "étapes pour créer une entreprise ?"
            ],
        ];

        return view('home', compact('conversations', 'activeConversationId', 'messages', 'suggestions', 'id'));
    }


    public function toggle(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            // Bascule entre clair et sombre
            $user->theme = $user->theme === 'dark' ? 'light' : 'dark';
            $user->save();
        } else {
            // Si aucun utilisateur connecté, on stocke le thème en session
            $current = session('theme', 'light');
            session(['theme' => $current === 'dark' ? 'light' : 'dark']);
        }

        // Recharge la page pour appliquer le changement
        return back();
    }

}
