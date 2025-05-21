<?php

namespace App\Events;

use App\Models\Reponse;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReponseCreee implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    
    public $reponse;

    /**
     * Create a new event instance.
     *
     * @return void
     */


    //  reponse proffffffff
     public function __construct(Reponse $reponse)
    {
        $this->reponse = $reponse;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
       public function broadcastOn()
    {
        return new PrivateChannel('professeur.' . $this->reponse->question->matiere->id_user);
    }
    public function broadcastWith()
    {
        $question = $this->reponse->question;
        $matiere = $question->matiere ?? null;
        $etudiant = $this->reponse->user;

        return [
            'contenu' => ($etudiant ? $etudiant->prenom . ' ' . $etudiant->nom : 'Un étudiant') .
                ' a répondu à la question "' . ($question->titre ?? '') . '" (Matière: ' . ($matiere->Nom ?? 'Inconnue') . ')',
            'id_question' => $question->id_question ?? null,
            'id_reponse' => $this->reponse->id,
             'titre_question' => $question->titre ?? '',
        ];
    }

  

    public function broadcastAs()
    {
        return 'reponse.creee';
    }

}
