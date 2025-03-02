<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Question;
use App\Models\Reponse;

class MessageController extends Controller
{
    /**
     * Afficher les messages (questions et réponses)
     */
    public function showMessages()
    {
        // Récupérer toutes les questions posées par l'étudiant connecté
        $questions = Question::where('id_user', Auth::id())->latest()->get();

        // Récupérer toutes les réponses associées aux questions
        $reponses = Reponse::whereIn('id_question', $questions->pluck('id_question'))->get();

        // Retourner la vue avec les données
        return view('Messages', compact('questions', 'reponses'));
    }

    /**
     * Enregistrer une nouvelle question posée par l'étudiant
     */
    public function storeQuestion(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenue' => 'required|string',
        ]);

        // Enregistrer la question dans la base de données
        Question::create([
            'titre' => $request->titre,
            'contenue' => $request->contenue,
            'id_user' => Auth::id(), // Associe la question à l'étudiant connecté
        ]);

        return redirect()->route('messages.index')->with('success', 'Votre question a été envoyée.');
    }

    /**
     * Modifier une question
     */
    public function edit($id_question)
    {
        // Trouver la question en fonction de son ID
        $question = Question::where('id_question', $id_question)->first();

        if (!$question) {
            return redirect()->route('messages.index')->with('error', 'Question non trouvée.');
        }

        // Vérifier que la question appartient à l'utilisateur connecté
        if ($question->id_user != Auth::id()) {
            return redirect()->route('messages.index')->with('error', 'Vous ne pouvez pas modifier cette question.');
        }

        // Retourner la vue d'édition avec la question
        return view('messages.edit', compact('question'));
    }

    /**
     * Mettre à jour une question
     */
    public function update(Request $request, $id_question)
    {
        // Valider les données envoyées
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenue' => 'required|string',
        ]);

        // Trouver la question en fonction de son ID
        $question = Question::where('id_question', $id_question)->first();

        if (!$question) {
            return redirect()->route('messages.index')->with('error', 'Question non trouvée.');
        }

        // Vérifier que la question appartient à l'utilisateur connecté
        if ($question->id_user != Auth::id()) {
            return redirect()->route('messages.index')->with('error', 'Vous ne pouvez pas modifier cette question.');
        }

        // Mettre à jour la question
        $question->update([
            'titre' => $request->titre,
            'contenue' => $request->contenue,
        ]);

        return redirect()->route('messages.index')->with('success', 'Votre question a été mise à jour.');
    }

    /**
     * Supprimer une question
     */
    public function destroy($id_question)
    {
        // Trouver la question en fonction de son ID
        $question = Question::where('id_question', $id_question)->first();

        if (!$question) {
            return redirect()->route('messages.index')->with('error', 'Question non trouvée.');
        }

        // Vérifier que la question appartient à l'utilisateur connecté
        if ($question->id_user != Auth::id()) {
            return redirect()->route('messages.index')->with('error', 'Vous ne pouvez pas supprimer cette question.');
        }

        // Supprimer la question
        $question->delete();

        return redirect()->route('messages.index')->with('success', 'Votre question a été supprimée.');
    }
}