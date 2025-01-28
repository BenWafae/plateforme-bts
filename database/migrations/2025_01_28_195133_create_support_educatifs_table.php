
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportEducatifsTable extends Migration
{
    public function up()
    {
        Schema::create('support_educatifs', function (Blueprint $table) {
            $table->id('id_support');  // Clé primaire 'id_support'
            $table->string('titre');    // Titre du support
            $table->text('description');  // Description du support
            $table->string('lien_url');  // Lien vers le support (ex : vidéo, exercice)
            $table->string('format');   // Format du support (par exemple : vidéo, PDF, texte)
            
            // Définir les clés étrangères
            $table->foreignId('id_matiere')->constrained('matieres');  // Clé étrangère vers la table 'matieres'
            $table->foreignId('id_type')->constrained('types');  // Clé étrangère vers la table 'types'
            
            $table->timestamps();    // Les colonnes 'created_at' et 'updated_at'
        });
    }

    public function down()
    {
        Schema::dropIfExists('support_educatifs');
    }
}