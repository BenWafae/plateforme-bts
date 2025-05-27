<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_consultation';
    public $incrementing = true;
    protected $keyType = 'int';

     protected $fillable = [
        'id_user',
        'id_support',
        'date_consultation',
    ];
    
    // Relation vers l'étudiant
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
// relation support;
       public function support()
    {
        return $this->belongsTo(SupportEducatif::class, 'id_support');
    }
}
