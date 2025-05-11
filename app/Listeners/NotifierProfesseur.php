<?php

namespace App\Listeners;

use App\Events\QuestionCreee;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifierProfesseur
{
    /**
     * Create the event listener.
     *
     * @return void
     */
 public function handle(QuestionCreee $event)
{
    $question = $event->question;
    $matiere = $question->matiere; // Récupérer la matière de la question

    if ($matiere && $matiere->professeur) {
        $prof = $matiere->professeur;
        
        // Utiliser la relation user() pour obtenir l'étudiant
        $etudiant = $question->user;  // La relation renverra l'utilisateur qui a posé la question
        
        // Vérifie que l'étudiant existe et a bien un nom/prénom
        $nomComplet = $etudiant ? $etudiant->prenom . ' ' . $etudiant->nom : 'Un étudiant';

        // Créer la notification avec le nom et prénom de l'étudiant et la matière
        Notification::create([
            'type' => 'question_postee',
            'contenu' => $nomComplet . ' a posé une nouvelle question dans votre matière : "' . $question->titre . '" (Matière: ' . $matiere->Nom . ')',
            'lue' => false,
            'date_notification' => now(),
            'id_user' => $prof->id_user,
            'id_question' => $question->id_question,
        ]);
    }
}



    /**
     * Handle the event.
     *
     * @param  \App\Events\QuestionCreee  $event
     * @return void
     */
  
}
