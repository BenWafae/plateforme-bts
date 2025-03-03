<?php

namespace App\Events;

use App\Models\User;
use App\Models\SupportEducatif;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SupportDownloaded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;             
    // l'etudiant qui a telecharger le support
    public $support;           
    // le support telechargeerr soit cours,exa,exercice;

    /**
     * Crée une nouvelle instance de l'événement.
     */
    public function __construct(User $user, SupportEducatif $support)
    // ici on pass deux objeeet a levent qu'on elle est declenchee ces deux objet sont: user & support;
    {
        $this->user = $user;
        $this->support = $support;
    }

    /**
     * Définir sur quel canal cet événement sera broadcasté (si besoin de websockets plus tard).
     */
//     public function broadcastOn()
//     {
//         return new PrivateChannel('support-downloaded');
//     }
}

