<?php

namespace App\Events;

use App\Models\Question;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuestionPosee
{
    use Dispatchable, SerializesModels;

    public $question;

    public function __construct(Question $question)
    {
        $this->question = $question;
    }
}
