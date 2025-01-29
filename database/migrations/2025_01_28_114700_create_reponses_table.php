<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::create('reponses', function (Blueprint $table) {
        $table->id();
        $table->text('contenu');          
        $table->timestamp('date_pub')->useCurrent(); 
        // a l'aide de useCurrent la date et l'heure seront ajouter automatiquemnt dans database lors de l'insertion d'un nouveau reponse 
        // on va determiner ici une cle etrangere vers la table questions
        $table->foreignId('id_question')->constrained('questions')->onDelete('cascade');  
        // ici une cle etrangere vers la table users
        $table->foreignId('id_user')->constrained('users')->onDelete('cascade');      
        $table->timestamps();            
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reponses');
    }
};
