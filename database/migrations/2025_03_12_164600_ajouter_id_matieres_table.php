<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            // Ajout de la colonne 'id_Matiere' après 'id_user'
            $table->unsignedBigInteger('id_Matiere')->after('id_user');
            // Ajout de la contrainte de clé étrangère
            $table->foreign('id_Matiere')->references('id_Matiere')->on('matieres')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            // Suppression de la contrainte de clé étrangère
            $table->dropForeign(['id_Matiere']);
            // Suppression de la colonne 'id_Matiere'
            $table->dropColumn('id_Matiere');
        });
    }
};
