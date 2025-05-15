<?php

namespace App\Listeners;

use App\Events\NewQuestionPosted;
use App\Models\User;
use App\Models\Notification;

class NotifyAdminNewQuestion
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\NewQuestionPosted  $event
     * @return void
     */
    public function handle(NewQuestionPosted $event)
    {
        $question = $event->question;
        $user = $event->user;

        // Étudiant qui a posé la question
        $nomComplet = $user ? $user->prenom . ' ' . $user->nom : 'Un étudiant';

        // Récupérer tous les utilisateurs ayant le rôle d'administrateur
        $admins = User::where('role', 'administrateur')->get();

        foreach ($admins as $admin) {
            Notification::create([
                'type' => 'nouvelle_question',
                'contenu' => $nomComplet . ' a posé une nouvelle question : "' . $question->titre . '"',
                'lue' => false,
                'date_notification' => now(),
                'id_user' => $admin->id_user, // Notifie l'admin
                'id_question' => $question->id_question,
            ]);
        }
    }
}
