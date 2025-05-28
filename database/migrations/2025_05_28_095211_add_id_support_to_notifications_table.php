<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->unsignedBigInteger('id_support')->nullable()->after('id_reponse');

            // Optionnel mais recommandé : ajouter la contrainte de clé étrangère
            $table->foreign('id_support')
                  ->references('id_support')
                  ->on('support_educatifs')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['id_support']);
            $table->dropColumn('id_support');
        });
    }
};
