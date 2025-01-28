<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypesTable extends Migration
{
    public function up()
    {
        Schema::create('types', function (Blueprint $table) {
            $table->id('id_type');  // Clé primaire 'id_type'
            $table->string('nom');   // Nom du type (par exemple : Vidéo, Exercice)
            $table->timestamps();    // Les colonnes 'created_at' et 'updated_at'
        });
    }

    public function down()
    {
        Schema::dropIfExists('types');
    }
}
