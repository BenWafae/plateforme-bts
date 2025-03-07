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
        // Récupérer toutes les questions triées par date
        $questions = Question::with('reponses', 'user')->latest()->get();

        return view('Messages', compact('questions'));
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

        // Création de la question
        Question::create([
            'titre' => $request->titre,
            'contenue' => $request->contenue,
            'id_user' => Auth::id(),
        ]);

        return redirect()->route('messages.index')->with('success', 'Votre question a été envoyée.');
    }

    /**
     * Modifier une question
     */
    public function edit($id_question)
    {
        // Trouver la question
        $question = Question::where('id_question', $id_question)->first();

        // Vérifier si la question existe
        if (!$question) {
            return redirect()->route('messages.index')->with('error', 'Question non trouvée.');
        }

        // Vérifier si l'utilisateur connecté est l'auteur de la question
        if ($question->id_user != Auth::id()) {
            return redirect()->route('messages.index')->with('error', 'Vous ne pouvez pas modifier cette question.');
        }

        return view('Messages', compact('question'));
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
        $question = Question::where('id_question', $id_question)->first();

        // Vérifier si la question existe
        if (!$question) {
            return redirect()->route('messages.index')->with('error', 'Question non trouvée.');
        }

        // Vérifier si l'utilisateur connecté est l'auteur de la question
        if ($question->id_user != Auth::id()) {
            return redirect()->route('messages.index')->with('error', 'Vous ne pouvez pas modifier cette question.');
        }

        // Mise à jour de la question
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
        // Trouver la question
        $question = Question::where('id_question', $id_question)->first();

        // Vérifier si la question existe
        if (!$question) {
            return redirect()->route('messages.index')->with('error', 'Question non trouvée.');
        }

        // Vérifier si l'utilisateur connecté est l'auteur de la question
        if ($question->id_user != Auth::id()) {
            return redirect()->route('messages.index')->with('error', 'Vous ne pouvez pas supprimer cette question.');
        }

        // Suppression de la question
        $question->delete();

        return redirect()->route('messages.index')->with('success', 'Votre question a été supprimée.');
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

        return redirect()->route('messages.index')->with('success', 'Votre réponse a été ajoutée.');
    }

    /**
     * Supprimer une réponse
     */
    public function destroyReponse($id_reponse)
    {
        // Trouver la réponse
        $reponse = Reponse::find($id_reponse); // Utilisation de find() pour récupérer la réponse

        // Vérifier si la réponse existe
        if (!$reponse) {
            return redirect()->route('messages.index')->with('error', 'Réponse non trouvée.');
        }

        // Vérifier si l'utilisateur connecté est l'auteur de la réponse
        if ($reponse->id_user != Auth::id()) {
            return redirect()->route('messages.index')->with('error', 'Vous ne pouvez pas supprimer cette réponse.');
        }

        // Suppression de la réponse
        $reponse->delete();

        return redirect()->route('messages.index')->with('success', 'Votre réponse a été supprimée.');
    }
}