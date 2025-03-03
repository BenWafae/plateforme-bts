<?php
namespace App\Listeners;

use App\Events\SupportDownloaded;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class SupportDownloadedListener
{
    public function handle(SupportDownloaded $event)
    {
        Log::info('Événement SupportDownloaded reçu.', [
            'etudiant' => $event->user->nom,
            'support' => $event->support->titre
        ]);

        $support = $event->support;
        $etudiant = $event->user;

        if ($etudiant->role !== 'etudiant') {
            Log::warning('Utilisateur non étudiant, notification ignorée.');
            return;
        }

        $professeur = $support->user;

        if (!$professeur || $professeur->role !== 'professeur') {
            Log::error('Aucun professeur trouvé pour ce support.');
            return;
        }

        $contenu = "L'étudiant {$etudiant->nom} a téléchargé le support '{$support->titre}'.";

        Notification::create([
            'type' => 'telechargement_support',
            'contenu' => $contenu,
            'lue' => false,
            'id_user' => $professeur->id_user,
            'id_support' => $support->id_support,
        ]);

        Log::info('Notification créée pour le professeur.', [
            'professeur_id' => $professeur->id_user,
            'support' => $support->titre
        ]);
    }
}
