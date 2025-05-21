<?php

namespace App\Events;

use App\Models\Question;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuestionCreee implements ShouldBroadcast
{
     use Dispatchable, SerializesModels;

    public $question;

    public function __construct(Question $question)
    {
        $this->question = $question;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
                
        return new PrivateChannel('professeur.' . $this->question->matiere->professeur->id_user);
        
    }

    public function broadcastWith()
{
    return [
        'id_question' => $this->question->id_question,
        'titre' => $this->question->titre,
        'contenue' => $this->question->contenue,
        'date_pub' => $this->question->date_pub,
        'matiere' => [
            'id_matiere' => $this->question->matiere->id,
            'nom' => $this->question->matiere->nom,
        ],
        'etudiant' => [
            'nom' => $this->question->user->nom,
            'prenom' => $this->question->user->prenom,
        ]
    ];
}


    // definir un nom personnalise

    public function broadcastAs()
{
    return 'question.creee';
}
}
