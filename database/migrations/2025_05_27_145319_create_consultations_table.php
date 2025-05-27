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
     public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id('id_consultation'); // clé primaire personnalisée
            $table->unsignedBigInteger('id_user'); // étudiant
            $table->unsignedBigInteger('id_support');
            $table->timestamp('date_consultation')->useCurrent(); // par défaut maintenant
            $table->timestamps();

            // Clés étrangères
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_support')->references('id_support')->on('support_educatifs')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
