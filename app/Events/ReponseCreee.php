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

class ReponseCreee
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
        return new PrivateChannel('channel-name');
    }
}
