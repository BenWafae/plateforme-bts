<?php

namespace App\Listeners;

use App\Events\QuestionSupprimee;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotifierQuestionSupprimee
{
    public function handle(QuestionSupprimee $event)
    {
        $question = $event->question;
        $user = Auth::user(); // Récupérer l'utilisateur qui supprime la question

        // Vérifier si c'est l'étudiant qui supprime sa propre question
        if ($question->id_user == $user->id_user) {
            $contenu = "tu as supprimé ta question.";
        } else {
            $contenu = "{$user->roles} {$user->prenom} {$user->nom} a supprimé votre question.";
        }

        // Créer la notification
        Notification::create([
            'type' => 'Suppression',
            'contenu' => $contenu,
            'lue' => false,
            'id_user' => $question->id_user, // Envoyer la notification au propriétaire de la question
            'id_question' => $question->id_question,
        ]);
    }
}