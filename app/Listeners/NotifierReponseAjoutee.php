<?php

namespace App\Listeners;

use App\Events\ReponseAjoutee;
use App\Models\Notification;

class NotifierReponseAjoutee
{
    public function handle(ReponseAjoutee $event)
    {
        Notification::create([
            'type' => 'Réponse',
            'contenu' => "Votre question a reçu une nouvelle réponse : '{$event->reponse->contenu}'.",
            'lue' => false,
            'id_user' => $event->reponse->question->id_user, // ID de l'étudiant qui a posé la question
            'id_question' => $event->reponse->question->id_question,
        ]);
    }
}