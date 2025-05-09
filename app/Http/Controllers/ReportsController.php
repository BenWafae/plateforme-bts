<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    // Méthode pour enregistrer un signalement
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $validated = $request->validate([
            'content_type' => 'required|string',
            'reason' => 'required|string',
            'description' => 'nullable|string',
            'id_question' => 'nullable|exists:questions,id_question',  // Validation si une question est présente
            'id_support' => 'nullable|exists:support_educatifs,id_support',  // Validation si un support est présent
            'id_Matiere' => 'nullable|exists:matieres,id',  // Validation si une matière est présente
        ]);

        // Créer un nouveau signalement
        Report::create([
            'id_user' => auth()->id(),  // ID de l'utilisateur connecté (étudiant)
            'content_type' => $request->content_type,  // Type de contenu signalé
            'reason' => $request->reason,  // Motif du signalement
            'description' => $request->description,  // Description supplémentaire
            'id_question' => $request->id_question,  // ID de la question (si applicable)
            'id_support' => $request->id_support,  // ID du support éducatif (si applicable)
            'id_Matiere' => $request->id_Matiere,  // ID de la matière (si applicable)
            'status' => 'nouveau',  // Statut du signalement par défaut
        ]);

        // Retourner une réponse (par exemple, rediriger vers la page précédente avec un message de succès)
        return redirect()->back()->with('success', 'Votre signalement a été envoyé.');
    }
}
