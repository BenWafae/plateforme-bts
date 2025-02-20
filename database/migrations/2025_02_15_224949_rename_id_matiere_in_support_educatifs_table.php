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
        Schema::table('support_educatifs', function (Blueprint $table) {
            $table->renameColumn('id_matiere', 'id_Matiere');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('support_educatifs', function (Blueprint $table) {
            // Revenir au nom d'origine 'id_matiere' si on annule la migration
            $table->renameColumn('id_Matiere', 'id_matiere');
        });
    }
};