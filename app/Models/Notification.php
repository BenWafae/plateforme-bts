<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // Indiquer les champs qui sont massivement assignables
    protected $fillable = [
        'type',
        'contenu',
        'lue',
        'date_notification',
        'id_user',
        'id_question',
        'id',
    ];

    // Relation avec l'utilisateur (celui qui reçoit la notification)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relation avec la question (si la notification est liée à une question)
    public function question()
    {
        return $this->belongsTo(Question::class, 'id_question');
    }

    // Relation avec la réponse (si la notification est liée à une réponse)
    public function reponse()
    {
        return $this->belongsTo(Reponse::class, 'id');
    }
}