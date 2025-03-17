<?php

namespace App\Events;

use App\Models\Reponse;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReponseAjoutee
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $reponse;

    public function __construct(Reponse $reponse)
    {
        $this->reponse = $reponse;
    }
}