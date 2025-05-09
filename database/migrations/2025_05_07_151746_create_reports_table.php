<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Exécuter la migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();  // Identifiant unique du signalement
            $table->unsignedBigInteger('id_user');  // L'ID de l'étudiant qui a fait le signalement
            $table->unsignedBigInteger('id_question')->nullable();  // L'ID de la question concernée (si applicable)
            $table->unsignedBigInteger('id_support')->nullable();  // L'ID du support éducatif concerné (si applicable)
            $table->unsignedBigInteger('id_Matiere')->nullable();  // L'ID de la matière concernée (en majuscule)
            $table->unsignedBigInteger('id_notification')->nullable();  // L'ID de la notification associée (si applicable)
            $table->string('content_type');  // Type de contenu signalé (par exemple: 'course', 'video', 'forum', etc.)
            $table->string('reason');  // Motif du signalement (ex : 'erreur', 'inapproprié', etc.)
            $table->text('description')->nullable();  // Description supplémentaire du signalement (facultatif)
            $table->string('status')->default('nouveau');  // Statut du signalement (par défaut "nouveau")
            $table->timestamps();  // Enregistre les dates de création et mise à jour

            // Définir les clés étrangères (avec la logique de suppression)
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_question')->references('id')->on('questions')->onDelete('set null');
            $table->foreign('id_support')->references('id')->on('support_educatifs')->onDelete('set null');
            $table->foreign('id_Matiere')->references('id')->on('matieres')->onDelete('set null');
            $table->foreign('id_notification')->references('id')->on('notifications')->onDelete('set null');
        });
    }

    /**
     * Revenir en arrière et supprimer la table.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
