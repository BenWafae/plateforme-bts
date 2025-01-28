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
        $table->text('contenu');          // Contenu de la réponse
        $table->timestamp('date_pub');    // Date de publication
        $table->foreignId('id_question')->constrained()->onDelete('cascade');  // Clé étrangère vers la table 'questions'
        $table->foreignId('id_user')->constrained()->onDelete('cascade');      // Clé étrangère vers la table 'users'
        $table->timestamps();             // Les timestamps 'created_at' et 'updated_at'
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
