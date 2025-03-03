<?php
namespace App\Listeners;

use App\Events\SupportConsulted;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class SupportConsultedListener
{
    public function handle(SupportConsulted $event)
    {
        Log::info('Événement SupportConsulted reçu.', [
            'etudiant' => $event->user->nom,
            'support' => $event->support->titre
        ]);

        $this->handleSupportEvent($event->support, $event->user, 'consultation_support');
    }

    protected function handleSupportEvent($support, $etudiant, $type)
    {
        if ($etudiant->role !== 'etudiant') {
            Log::warning('Utilisateur non étudiant, notification ignorée.');
            return;
        }

        $professeur = $support->user;  // ⚠️ Correct (c'est bien l'auteur du support, donc un professeur)

        if (!$professeur || $professeur->role !== 'professeur') {
            Log::error('Aucun professeur trouvé pour ce support.');
            return;
        }

        $contenu = "L'étudiant {$etudiant->nom} a consulté le support '{$support->titre}'.";

        Notification::create([
            'type' => $type,
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


