<?php

namespace App\Events;

use App\Models\Question;
use App\Models\User;
use Illuminate\Queue\SerializesModels;

class ContentReported
{
    use SerializesModels;

    public $question;
    public $user;
    public $reason;

    public function __construct(Question $question, User $user, $reason)
    {
        $this->question = $question;
        $this->user = $user;
        $this->reason = $reason;
    }
}

