<?php


namespace App\Listeners;

use App\Events\ReponseAjoutee;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifierReponseAjoutee implements ShouldQueue
{
    public function handle(ReponseAjoutee $event)
    {
        $reponse = $event->reponse;
        $question = $reponse->question;
        $userId = $question->id_user;

        // Récupérer l'auteur avec sécurité
        $auteur = $reponse->user()->first();

        if (!$auteur) {
            \Log::error("L'auteur de la réponse ID {$reponse->id} n'a pas été trouvé.");
            return;
        }

        // Enregistrer la notification avec nom et rôle
        Notification::create([
            'type' => 'Réponse',
            'contenu' => "{$auteur->nom}({$auteur->role}) a répondu à votre question.",
            'lue' => false,
            'date_notification' => now(),
            'id_user' => $userId,
            'id_question' => $question->id_question,
            'id' => $reponse->id,
        ]);
    }
}