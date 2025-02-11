<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_filiere';
    protected $table = 'filieres';
    protected $fillable = [
        'nom_filiere',
       
        
      ];



    // on va determiner la relation entre matiere et filiere:une filiere contient plusieur matieres.
    public function matieres()
    {
        return $this->hasMany(Matiere::class, 'id_filiere');
    }
}
