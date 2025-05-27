<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportEducatif extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_support';  // Spécifier la clé primaire

    // Ajouter 'prive' dans $fillable pour l'assignation en masse
    protected $fillable = [
        'titre',
        'description',
        'lien_url',
        'format',
        'id_Matiere',
        'id_type',
        'id_user',
        'prive', // champ ajouté
    ];

    // Relation : Un support éducatif appartient à une matière
    public function matiere()
    {
        return $this->belongsTo(Matiere::class, 'id_Matiere');
    }

    // Relation : Un support éducatif appartient à un type
    public function type()
    {
        return $this->belongsTo(Type::class, 'id_type');
    }

    // Relation : Un support éducatif appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
// consultation

    public function consultations()
{
    return $this->hasMany(Consultation::class, 'id_support', 'id_support');
}
}
