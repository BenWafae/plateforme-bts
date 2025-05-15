<?php

namespace App\Http\Controllers;
use App\Events\ContentReported;
use Illuminate\Support\Facades\Auth;

use App\Models\Question;
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
              // Déclencher l'événement uniquement si c'est une question signalée
   if ($request->id_question) {
        $question = Question::find($request->id_question);
        $user = Auth::user(); // ✅ ICI tu définis bien $user
        event(new ContentReported($question, $user, $request->reason));
 }

        // Retourner une réponse (par exemple, rediriger vers la page précédente avec un message de succès)
        return redirect()->back()->with('success', 'Votre signalement a été envoyé.');
    }
}
