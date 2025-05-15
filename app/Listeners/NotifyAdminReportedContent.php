<?php

namespace App\Listeners;

use App\Events\ContentReported;
use App\Models\User;
use App\Models\Notification;

class NotifyAdminReportedContent
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\QuestionSignalee  $event
     * @return void
     */
    public function handle(ContentReported $event)
    {
        $question = $event->question;
        $user = $event->user;
        $reason = $event->reason;

        // Étudiant qui a signalé la question
        $nomComplet = $user ? $user->prenom . ' ' . $user->nom : 'Un étudiant';

        // Récupérer tous les administrateurs
        $admins = User::where('role', 'administrateur')->get();

        foreach ($admins as $admin) {
            Notification::create([
                'type' => 'question_signalée',
                'contenu' => $nomComplet . ' a signalé une question : "' . $question->titre . '" pour la raison suivante : ' . $reason,
                'lue' => false,
                'date_notification' => now(),
                'id_user' => $admin->id_user,  // ID de l'administrateur
                'id_question' => $question->id_question,
            ]);
        }
    }
}
