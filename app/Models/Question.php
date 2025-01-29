<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table = 'questions';
    protected $fillable = [
        'titre',
        'contenue',
        'date_pub',
        'id_user',
        
      ];





    //   determiner la relation entre user et question :chauque question poster par un seul utilisateur
    // et chaque user peut poster pas mal ds questions

      public function user()
    //   ici on a met user et pas users car la relation est blongsto donc user singulier
      {
          return $this->belongsTo(User::class, 'id_user');
      }

    //   relation entre question et reponse:chaque questions peut avoir pas mal ds reponses

    public function reponses()
       {
        return $this->hasMany(Reponse::class,  'id_question');
       }








}


