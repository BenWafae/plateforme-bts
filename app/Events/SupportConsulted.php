<?php

namespace App\Events;

use App\Models\User;
use App\Models\SupportEducatif;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SupportConsulted
{
    use Dispatchable, SerializesModels;

     public $user;     
    //  $user est celui qui stock l'etudiant qui consult le support 
     public $support;   
    // $support stock less supports consultes



    
    /**
     * Créer une nouvelle instance de l'événement.
     */
    public function __construct(User $user, SupportEducatif $support)
    // ce constructeuuur recoit deeuux objeet:user et supprot il les stocks dans les attributs de la basee
    {
        $this->user = $user;
        
        $this->support = $support;
        
    }
}
// le buut de la creation de levent c juste de passer les informations des etudinats et des support et apres listener celui qui va creer la notiification dans la base de donneee
