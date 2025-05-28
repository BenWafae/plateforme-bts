<?php
namespace App\Events;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\SupportEducatif;

class CoursCree
{
    public $cours;

    public function __construct(SupportEducatif $cours)
    {
        $this->cours = $cours;
    }
}

