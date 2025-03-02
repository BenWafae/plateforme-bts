<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $primaryKey = 'id_notification';

    protected $fillable = [
        'type' ,
        'contenu',
        'lue',
        'id_user',
        'id_support',
        'id_question',
        'id_reponse'
    ];

    // la notification seraaa afficher a une destinataire specifique:users;
       public function user()
       {
        return $this->belongsTo(User::class, 'id_user');
       }
    //    si laa notification concerne un support;
    public function supportsEducatif()
    {
        return $this->belongsTo(SupportEducatif::class, 'id_support');
    }
    //  si la notification est unee question;
      public function question()
      {
        return $this->belongsTo(Question::class, 'id_question');
      }
      
    //   sii la notification concerne une reponse
    public function reponse()
    {
        return $this->belongsTo(Reponse::class, 'id_reponse');
    }
}
