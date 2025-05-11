<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use HasFactory;

    protected $table = 'matieres';
    protected $primaryKey = 'id_Matiere';  // Le nom de la clé primaire est id_Matiere

    protected $fillable = [
        'Nom',
        'description',
        'id_filiere',
        'id_user',
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

    // Relation avec Question : Une matière peut avoir plusieurs questions
    public function questions()
    {
        return $this->hasMany(Question::class, 'id_Matiere');
    }
    // relation prof matiere
    public function professeur()
{
    return $this->belongsTo(User::class, 'id_user', 'id_user');
}


}
