<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdFiliereToUsersTable extends Migration
{
    /**
     * Ajouter la colonne id_filiere à la table users.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('id_filiere')->nullable()->after('role');

            // Si tu as une table "filieres", tu peux décommenter ceci pour ajouter une contrainte :
            // $table->foreign('id_filiere')->references('id')->on('filieres')->onDelete('set null');
        });
    }

    /**
     * Supprimer la colonne id_filiere en cas de rollback.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // $table->dropForeign(['id_filiere']); // seulement si tu avais ajouté une clé étrangère
            $table->dropColumn('id_filiere');
        });
    }
}
