<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    // Les champs que l'on peut remplir (mass assignable)
    protected $fillable = [
        'id_user',
        'id_question',
        'id_support',
        'id_Matiere',  // En majuscule ici
        'id_notification',
        'content_type',
        'reason',
        'description',
        'status',
    ];

    // Relation avec l'utilisateur (étudiant) qui a fait le signalement
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relation avec la question signalée (si applicable)
    public function question()
    {
        return $this->belongsTo(Question::class, 'id_question');
    }

    // Relation avec le support éducatif signalé (si applicable)
    public function supportEducatif()
    {
        return $this->belongsTo(SupportEducatif::class, 'id_support');
    }

    // Relation avec la matière signalée (si applicable)
    public function matiere()
    {
        return $this->belongsTo(Matiere::class, 'id_Matiere');  // En majuscule ici aussi
    }

    // Relation avec la notification (si applicable)
    public function notification()
    {
        return $this->belongsTo(Notification::class, 'id_notification');
    }
}
