<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    // Définir la table et la clé primaire
    protected $table = 'questions';
    protected $primaryKey = 'id_question';  // Spécifie que la clé primaire est id_question

    protected $fillable = [
        'titre',
        'contenue',
        'date_pub',
        'id_user',
        'id_Matiere',  // Inclure id_Matiere ici
    ];

    // Relation avec l'utilisateur (chaque question appartient à un utilisateur)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relation entre question et réponses (chaque question peut avoir plusieurs réponses)
    public function reponses()
    {
        return $this->hasMany(Reponse::class, 'id_question');
    }

    // Relation avec Matiere (chaque question appartient à une matière)
    public function matiere()
    {
        return $this->belongsTo(Matiere::class, 'id_Matiere');
    }

    // Ajout de la relation polymorphe pour les notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'notifiable');
    }
}
