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
        'id_user'      // Clé étrangère vers la table 'users'
    ];

   

    // Relation avec la table 'users'
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function question()
    {
    return $this->belongsTo(Question::class, 'id_question');

   }
}

  