<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportEducatif extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_support';  // Spécifier la clé primaire

    protected $fillable = ['titre', 'description', 'lien_url', 'format', 'id_matiere', 'id_type','id_user']; // Permet d'assigner des valeurs en masse

    // Relation : Un support éducatif appartient à une matière
    public function matiere()
    {
        return $this->belongsTo(Matiere::class, 'id_matiere');
    }

    // Relation : Un support éducatif appartient à un type
    public function type()
    {
        return $this->belongsTo(Type::class, 'id_type');
    }

//relation user suppport
public function user()
{
    return $this->belongsTo(User::class, 'id_user'); 
}



 }
   