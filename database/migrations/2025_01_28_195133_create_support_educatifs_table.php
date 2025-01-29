
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportEducatifsTable extends Migration
{
    public function up()
    {
        Schema::create('support_educatifs', function (Blueprint $table) {
            $table->id('id_support');  
            $table->string('titre');    
            $table->text('description'); 
            $table->string('lien_url');  
              // je dois definie les format:
           $table->enum('format', ['pdf', 'ppt', 'word', 'lien_video']);
            
            // Définir les clés étrangères
            $table->foreignId('id_matiere')->constrained('matieres')->onDelete('cascade');  
            $table->foreignId('id_type')->constrained('types')->onDelete('cascade');  
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            
            $table->timestamps();    
        });
    }

    public function down()
    {
        Schema::dropIfExists('support_educatifs');
    }
}