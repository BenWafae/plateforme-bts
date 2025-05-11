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
    Schema::table('matieres', function (Blueprint $table) {
        $table->unsignedBigInteger('id_user'); // ajouter la colonne

        $table->foreign('id_user') // créer la contrainte de clé étrangère
              ->references('id_user') // colonne référencée dans la table users
              ->on('users') // table référencée
              ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
  public function down()
{
    Schema::table('matieres', function (Blueprint $table) {
        $table->dropForeign(['id_user']);
        $table->dropColumn('id_user');
    });
}
};
