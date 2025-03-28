<?php


namespace App\Listeners;

use App\Events\ReponseAjoutee;
use App\Models\Notification;

class NotifierReponseAjoutee
{
    public function handle(ReponseAjoutee $event)
    {
        $reponse = $event->reponse;
        $question = $reponse->question;
        $auteur = $reponse->user; // L'utilisateur qui a répondu

        // Vérifier si l'étudiant répond à sa propre question
        if ($question->id_user == $auteur->id_user) {
            $contenu = "tu as répondu à ta question.";
        } else {
            $contenu = "{$auteur->roles} {$auteur->prenom} {$auteur->nom} a répondu à votre question.";
        }

        // Créer la notification pour le propriétaire de la question
        Notification::create([
            'type' => 'Réponse',
            'contenu' => $contenu,
            'lue' => false,
            'id_user' => $question->id_user,
            'id_question' => $question->id_question,
            'id_reponse' => $reponse->id_reponse,
        ]);
    }
}