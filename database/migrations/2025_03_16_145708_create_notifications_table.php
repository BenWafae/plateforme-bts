<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('id_notification'); // ID de la notification
            $table->string('type'); // Type de la notification (ex. 'question_answered')
            $table->text('contenu'); // Contenu de la notification
            $table->boolean('lue')->default(false); // Si la notification a été lue (false par défaut)
            $table->timestamp('date_notification')->useCurrent(); // Date de la notification
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade'); // ID de l'utilisateur (récepteur)
            $table->foreignId('id_question')->nullable()->constrained('questions')->onDelete('cascade'); // ID de la question
           $table->foreignId('id_reponse')->nullable()->constrained('reponses')->onDelete('cascade');
            $table->timestamps(); // created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}