<?php

namespace App\Listeners;

use App\Events\QuestionCreee;
use App\Events\QuestionPosee;
use App\Models\Notification;

class NotifierQuestionPosee
{
    public function handle(QuestionCreee $event)
{
    Notification::create([
        'type' => 'Nouvelle Question',
        'contenu' => "Votre question '{$event->question->titre}' a été enregistrée.",
        'lue' => false,
        'id_user' => $event->question->id_user,
        'id_question' => $event->question->id_question,
        'id_reponse' => null,  // L'ID de réponse peut être null si aucune réponse n'a été donnée
    ]);
}
}
