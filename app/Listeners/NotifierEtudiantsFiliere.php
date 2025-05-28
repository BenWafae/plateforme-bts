<?php

namespace App\Listeners;

use App\Events\CoursCree;
use App\Models\User;
 use App\Models\Notification;
use App\Notifications\NouveauCoursNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifierEtudiantsFiliere implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  CoursCree  $event
     * @return void
     */

public function handle(CoursCree $event)
{
    $cours = $event->cours;
    
    // Charger la matière liée
    $matiere = $cours->matiere; // Assure-toi que la relation existe dans le modèle SupportEducatif

    $idFiliere = $matiere->id_filiere ?? null;

    if (!$idFiliere) {
        return;
    }
    $types = [
            1 => 'cours',
            2 => 'exercice',
            3 => 'examen',
        ];

        $typeNom = $types[$cours->id_type] ?? 'support';

    $etudiants = User::where('role', 'etudiant')
                     ->where('id_filiere', $idFiliere)
                     ->get();
    
foreach ($etudiants as $etudiant) {
    Notification::create([
        'type' => 'nouveau_support',
        'contenu' => "Un nouveau $typeNom '{$cours->titre}' a été ajouté dans la matière '{$matiere->Nom}' de votre filière.",
        'lue' => 0,
        'date_notification' => now(),
        'id_user' => $etudiant->id_user,
        'id_question' => null,
        'id_reponse' => null,
        'id_support' => $cours->id_support,
    ]);
}

}
}
