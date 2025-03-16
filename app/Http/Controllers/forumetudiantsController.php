<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Question;
use App\Models\Reponse;
use App\Models\Matiere;

class ForumEtudiantsController extends Controller
{
    /**
     * Afficher les messages (questions et réponses)
     */
    public function showForum(Request $request)
    {
        // Récupérer toutes les matières
        $matieres = Matiere::all();

        // Construire la requête pour récupérer les questions avec leurs réponses
        $query = Question::with('reponses', 'user', 'matiere');

        // Filtrage par matière si spécifié
        if ($request->has('id_Matiere') && $request->id_Matiere) {
            $query->where('id_Matiere', $request->id_Matiere);
        }

        // Filtrage par recherche de titre si spécifié
        if ($request->has('search') && $request->search) {
            $query->where('titre', 'like', '%' . $request->search . '%');
        }

        // Filtrage par date si spécifié
        if ($request->has('date') && $request->date) {
            $query->whereDate('created_at', '=', $request->date);
        }

        // Récupérer les questions filtrées avec pagination (3 par page)
        $questions = $query->latest()->paginate(3);

        return view('forumetudiants', compact('questions', 'matieres'));
    }

    /**
     * Afficher le formulaire pour poser une nouvelle question
     */
    public function create()
    {
        // Récupérer toutes les matières pour afficher dans le formulaire
        $matieres = Matiere::all();

        // Retourner la vue du formulaire de création de question
        return view('createquestion', compact('matieres'));
    }

    /**
     * Enregistrer une nouvelle question posée par l'étudiant
     */
    public function storeQuestion(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenue' => 'required|string',
            'id_Matiere' => 'required|exists:matieres,id_Matiere',
        ]);

        // Création de la question
        Question::create([
            'titre' => $request->titre,
            'contenue' => $request->contenue,
            'id_user' => Auth::id(),
            'id_Matiere' => $request->id_Matiere,
        ]);

        return redirect()->route('forumetudiants.index')->with('success', 'Votre question a été envoyée.');
    }

    /**
     * Modifier une question
     */
    public function edit($id_question)
    {
        // Trouver la question
        $question = Question::where('id', $id_question)->first();

        // Vérifier si la question existe
        if (!$question) {
            return redirect()->route('forumetudiants.index')->with('error', 'Question non trouvée.');
        }

        // Vérifier si l'utilisateur connecté est l'auteur de la question
        if ($question->id_user != Auth::id()) {
            return redirect()->route('forumetudiants.index')->with('error', 'Vous ne pouvez pas modifier cette question.');
        }

        // Récupérer toutes les matières pour afficher dans le formulaire de modification
        $matieres = Matiere::all();

        return view('editquestion', compact('question', 'matieres'));
    }

    /**
     * Mettre à jour une question
     */
    public function update(Request $request, $id_question)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenue' => 'required|string',
        ]);

        // Trouver la question
        $question = Question::where('id', $id_question)->first();

        // Vérifier si la question existe
        if (!$question) {
            return redirect()->route('forumetudiants.index')->with('error', 'Question non trouvée.');
        }

        // Vérifier si l'utilisateur connecté est l'auteur de la question
        if ($question->id_user != Auth::id()) {
            return redirect()->route('forumetudiants.index')->with('error', 'Vous ne pouvez pas modifier cette question.');
        }

        // Mise à jour de la question
        $question->update([
            'titre' => $request->titre,
            'contenue' => $request->contenue,
        ]);

        return redirect()->route('forumetudiants.index')->with('success', 'Votre question a été mise à jour.');
    }

    /**
     * Supprimer une question
     */
    public function destroyQuestion($id_question)
    {
        // Trouver la question
        $question = Question::where('id', $id_question)->first();

        // Vérifier si la question existe
        if (!$question) {
            return redirect()->route('forumetudiants.index')->with('error', 'Question non trouvée.');
        }

        // Vérifier si l'utilisateur connecté est l'auteur de la question
        if ($question->id_user != Auth::id()) {
            return redirect()->route('forumetudiants.index')->with('error', 'Vous ne pouvez pas supprimer cette question.');
        }

        // Suppression de la question
        $question->delete();

        return redirect()->route('forumetudiants.index')->with('success', 'Votre question a été supprimée.');
    }

    /**
     * Enregistrer une réponse à une question
     */
    public function storeReponse(Request $request, $id_question)
    {
        $request->validate([
            'contenu' => 'required|string',
        ]);

        // Création de la réponse
        Reponse::create([
            'contenu' => $request->contenu,
            'id_user' => Auth::id(),
            'id_question' => $id_question,
        ]);

        return redirect()->route('forumetudiants.index')->with('success', 'Votre réponse a été ajoutée.');
    }

    /**
     * Supprimer une réponse
     */
    public function destroyReponse($id_reponse)
    {
        // Trouver la réponse
        $reponse = Reponse::find($id_reponse);

        // Vérifier si la réponse existe
        if (!$reponse) {
            return redirect()->route('forumetudiants.index')->with('error', 'Réponse non trouvée.');
        }

        // Vérifier si l'utilisateur connecté est l'auteur de la réponse
        if ($reponse->id_user != Auth::id()) {
            return redirect()->route('forumetudiants.index')->with('error', 'Vous ne pouvez pas supprimer cette réponse.');
        }

        // Suppression de la réponse
        $reponse->delete();

        return redirect()->route('forumetudiants.index')->with('success', 'Votre réponse a été supprimée.');
    }
}