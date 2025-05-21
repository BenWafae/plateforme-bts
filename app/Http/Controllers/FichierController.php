<?php

namespace App\Http\Controllers;

use App\Models\SupportEducatif;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FichierController extends Controller
{
    /**
     * Affiche un fichier PDF dans le navigateur
     */
    public function view($id)
    {
        $support = SupportEducatif::findOrFail($id);

        // Vérification des autorisations (si privé)
        if ($support->prive && $support->id_user !== auth()->id()) {
            abort(403, 'Accès non autorisé à ce fichier');
        }

        // Autoriser uniquement les PDF pour la visualisation
        if ($support->format !== 'pdf') {
            abort(400, 'Seuls les fichiers PDF peuvent être visualisés');
        }

        $filePath = storage_path('app/public/' . $support->lien_url);

        if (!file_exists($filePath)) {
            abort(404, 'Fichier non trouvé');
        }

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . Str::slug($support->titre) . '.pdf"'
        ]);
    }

    /**
     * Télécharge un fichier (sauf les vidéos)
     */
    public function download($id)
    {
        $support = SupportEducatif::findOrFail($id);

        // Vérification des autorisations (si privé)
        if ($support->prive && $support->id_user !== auth()->id()) {
            abort(403, 'Accès non autorisé à ce fichier');
        }

        // Refuser le téléchargement pour les vidéos
        if ($support->format === 'video') {
            abort(403, 'Les vidéos ne sont pas disponibles en téléchargement. Veuillez les regarder via le lien fourni.');
        }

        $filePath = storage_path('app/public/' . $support->lien_url);

        if (!file_exists($filePath)) {
            abort(404, 'Fichier non trouvé');
        }

        $extension = pathinfo($support->lien_url, PATHINFO_EXTENSION);

        return response()->download(
            $filePath,
            Str::slug($support->titre) . '.' . $extension,
            ['Content-Type' => $this->getMimeType($extension)]
        );
    }

    /**
     * Retourne le type MIME selon l'extension
     */
    protected function getMimeType($extension)
    {
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'zip' => 'application/zip',
            'mp4' => 'video/mp4'
        ];

        return $mimeTypes[strtolower($extension)] ?? 'application/octet-stream';
    }
}
