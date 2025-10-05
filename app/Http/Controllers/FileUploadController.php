<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\FileUploaded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        // Valider le fichier
        $request->validate([
            'file' => 'required|file'
        ]);

        // Obtenir le fichier
        $file = $request->file('file');

        // Lire le contenu du fichier en tant que buffer
        $buffer = file_get_contents($file->getRealPath());

        // Récupérer les informations sur le fichier
        $mimeType = $file->getClientMimeType(); // Type MIME
        $extension = $file->getClientOriginalExtension(); // Extension
        $size = $file->getSize(); // Taille en octets
        $fileName = $file->getClientOriginalName(); // Nom original du fichier

        // Stocker le fichier dans S3
        $path = $file->store('uploads', 's3');

        // Envoyer l'e-mail
        Mail::to('nathalietaffot@gmail.com')->send(new FileUploaded($fileName, $buffer));

        // Vous pouvez maintenant utiliser le buffer comme vous le souhaitez
        return response()->json([
            'message' => 'Fichier reçu',
            'mime_type' => $mimeType,
            'extension' => $extension,
            'size' => $size, // Taille en octets
            'path' => $path,
            'url' => Storage::disk('s3')->url($path), // URL du fichier

        ]);
    }
}
