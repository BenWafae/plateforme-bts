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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('id_notification');
            $table->string('type');
            // pour le typee icii on parle de : letudiants consulte le support,l'etudiant telecharge le support
            // le prof a poster un support ,et le notification concerne le forume question & reponsse
            $table->text('contenu');
            // c'est le msg ex: letudiante wafae a consulter ce cours...
            $table->boolean('lue')->default(false);
            // cee champs a pourr but d'indiquerr si cette notification estt vuue ou pass;
            $table->timestamp('date_notification')->useCurrent();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            // lusers: est celui qui vaa avoir la notification c'est le destinataire
            $table->foreignId('id_support')->nullable()->constrained('supports')->onDelete('cascade');
            // ici si la notification concerne un supports;
            $table->foreignId('id_question')->nullable()->constrained('questions')->onDelete('cascade');
            // si la notification concerne un question qui a ete posee
            $table->foreignId('id_reponse')->nullable()->constrained('reponses')->onDelete('cascade'); 
            // si quelqu'un repondere a la question d'un users;
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
        Schema::dropIfExists('notifications');
    }
};
