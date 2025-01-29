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
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user'); // Définir la clé primaire
            $table->string('nom'); // Nom de l'utilisateur
            $table->string('prenom'); // Prénom de l'utilisateur
            $table->string('email')->unique(); // Email de l'utilisateur, unique
            $table->string('password'); // Mot de passe de l'utilisateur
            $table->enum('role', ['administrateur', 'professeur', 'etudiant']); // Rôle de l'utilisateur
            $table->timestamp('email_verified_at')->nullable(); // Date de vérification de l'email
            $table->rememberToken(); // Pour se souvenir de l'utilisateur
            $table->timestamps(); // Dates de création et de mise à jour
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
