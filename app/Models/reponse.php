<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reponse extends Model
{
    use HasFactory;

    // Spécifier les champs qui peuvent être assignés en masse
    protected $fillable = [
        'contenu',     // Contenu de la réponse
        'date_pub',    // Date de publication
        'id_question', // Clé étrangère vers la table 'questions'
        'id_user' ,     // Clé étrangère vers la table 'users'
        'id_reponse_parent',
    ];

    // Relation avec la table 'users'
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relation avec la table 'questions'
    public function question()
    {
        return $this->belongsTo(Question::class, 'id_question');
    }

    // Ajout de la relation polymorphe pour les notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'notifiable');
    }
    
}
