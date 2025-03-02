<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use HasFactory;

    protected $table = 'matieres';
    protected $primaryKey = 'id_Matiere';

    protected $fillable = [
        'Nom',
        'description',
        'id_filiere',
    ];

    // Relation avec Filiere : Une matière appartient à une seule filière
    public function filiere()
    {
        return $this->belongsTo(Filiere::class, 'id_filiere');
    }

    // Relation avec SupportEducatif : Une matière peut avoir plusieurs supports éducatifs
    public function supportsEducatifs()
    {
        return $this->hasMany(SupportEducatif::class, 'id_Matiere');
    }
}