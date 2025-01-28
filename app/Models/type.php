<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_type';  // Spécifier la clé primaire

    // Relation : Un type a plusieurs supports éducatifs
    public function supports()
    {
        return $this->hasMany(SupportEducatif::class, 'id_type');
    }
}