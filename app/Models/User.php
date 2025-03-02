<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;




class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // ajout de cle primaire
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
// ici on va determiner la relation entre user et question
  public function questions()
  {
    return $this->hasMany(Question::class, 'id_user');
  }

//   relation entre reponse et user
public function reponses()
{
    return $this->hasMany(Reponse::class, 'user_id', 'id');
}
// relation user supprt educative:
public function supportsEducatifs()
{
    return $this->hasMany(SupportEducatif::class, 'id_user'); 
}
// notification recus par ceee userrr:
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'id_user');
    }












}

