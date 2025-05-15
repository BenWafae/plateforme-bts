<?php

namespace App\Events;

use App\Models\Question;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewQuestionPosted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $question;
    public $user;

    public function __construct(Question $question, User $user)
    {
        $this->question = $question;
        $this->user = $user;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('admin.notifications');
    }

    public function broadcastAs()
    {
        return 'new-question-posted';
    }

    public function broadcastWith()
    {
        return [
            'question_id' => $this->question->id_question,
            'titre' => $this->question->titre,
            'id_user' => $this->user->nom,
        ];
    }
}
