<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Définition de la clé primaire
    protected $primaryKey = 'id_user';
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

   
    // Relation entre User et Question (Un utilisateur peut poser plusieurs questions)
    public function questions()
    {
        return $this->hasMany(Question::class, 'id_user');
    }

    // Relation entre User et Reponse (Un utilisateur peut donner plusieurs réponses)
    public function reponses()
    {
        return $this->hasMany(Reponse::class, 'id_user');
    }

    // Relation entre User et SupportEducatif (Un utilisateur peut avoir plusieurs supports éducatifs)
    public function supportsEducatifs()
    {
        return $this->hasMany(SupportEducatif::class, 'id_user');
    }

    // Ajout de la relation polymorphe pour les notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'notifiable');
    }
    public function notificationsNonLues()
{
    return $this->hasMany(Notification::class, 'id_user', 'id_user')->where('lue', false);
}
}
