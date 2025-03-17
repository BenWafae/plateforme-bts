<?php

namespace App\Listeners;

use App\Events\QuestionSupprimee;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotifierQuestionSupprimee
{
    public function handle(QuestionSupprimee $event)
    {
        $user = Auth::user(); // Récupérer l'utilisateur qui supprime la question

        Notification::create([
            'type' => 'Suppression',
            'contenu' => "Votre question '{$event->question->titre}' a été supprimée par {$user->nom} ({$user->role})",
            'lue' => false,
            'id_user' => $event->question->id_user, // Envoyer la notification au propriétaire de la question
            'id_question' => $event->question->id_question,
        ]);
    }
}