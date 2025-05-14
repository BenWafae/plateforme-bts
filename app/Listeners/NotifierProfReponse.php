<?php

namespace App\Listeners;

use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifierProfReponse
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
         $reponse = $event->reponse;
        $question = $reponse->question;

        if ($question && $question->matiere && $question->matiere->professeur) {
            $prof = $question->matiere->professeur;

            $etudiant = $reponse->user;
            $nomComplet = $etudiant ? $etudiant->prenom . ' ' . $etudiant->nom : 'Un étudiant';

           Notification::create([
                'type' => 'reponse_postee',
                'contenu' => $nomComplet . ' a répondu à la question "' . $question->titre . '" (Matière: ' . $question->matiere->Nom . ')',
                'lue' => false,
                'date_notification' => now(),
                'id_user' => $prof->id_user,
                'id_question' => $question->id_question,
                'id_reponse' => $reponse->id_reponse,
            ]);
    }
}
}