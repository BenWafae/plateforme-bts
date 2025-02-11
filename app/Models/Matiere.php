<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use HasFactory;
    // ici on a specifier un autre table ccar laravel prend par defaut la table user pour l'empecher de le prendre on fais ca
    protected $table = 'matieres';
    protected $primaryKey = 'id_Matiere';
    // les attribut qui vont etre rempis:
    
    protected $fillable = [
        'Nom',
        'description',
        'id_filiere',
        
      ];








    // on va determner la relation avec matiere et filiere:chaque matiere appartient a une seul filiere.
    public function filiere()
    // ici j'ai remarquer qu'on a utiliser filiere on singulier la raison de ca : car la regle de belongsTo est d'utiliser le model en singulier
    {
        return $this->belongsTo(Filiere::class, 'id_filiere');
    }
}
