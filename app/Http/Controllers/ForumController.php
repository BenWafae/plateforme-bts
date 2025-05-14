<?php
namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Reponse;
use App\Events\ReponseAjoutee;
use App\Events\ReponseCreee;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function index()
    {
       $questions = Question::with('reponses', 'matiere', 'user')
                     ->orderBy('created_at', 'desc') // du plus récent au plus ancien
                     ->get();
        return view('forum_prof', compact('questions'));
    }

    public function repondre(Request $request, $id)
{
    $request->validate([
        'reponse' => 'required|string',
    ]);

    $question = Question::findOrFail($id);

    // Création de la réponse et récupération dans une variable
    $reponse = Reponse::create([
        'id_question' => $question->id_question,
        'contenu' => $request->input('reponse'),
        'id_user' => auth()->user()->id_user,
        
    ]);

    // Déclencher l'événement ReponseAjoutee avec la réponse correcte
    event(new ReponseAjoutee($reponse));
    event(new ReponseCreee($reponse));   // Notification au professeur

    return redirect()->route('professeur.questions.index')->with('success', 'Réponse envoyée avec succès.');
}
    public function updateReponse(Request $request, $id)
    {
        $reponse = Reponse::findOrFail($id);

        // Vérification que l'utilisateur authentifié est celui qui a posté la réponse
        if ($reponse->id_user != auth()->user()->id_user) {
            return redirect()->route('professeur.questions.index')->with('error', 'Vous ne pouvez pas modifier cette réponse.');
        }

        $reponse->update([
            'contenu' => $request->input('reponse'),
        ]);

        return redirect()->route('professeur.questions.index')->with('success', 'Réponse mise à jour avec succès.');
    }

    public function editReponse($id)
{
    // Trouver la réponse par ID
    $reponse = Reponse::findOrFail($id);

    // Vérifier si l'utilisateur authentifié est celui qui a posté la réponse
    if ($reponse->id_user != auth()->user()->id_user) {
        return redirect()->route('professeur.questions.index')->with('error', 'Vous ne pouvez pas modifier cette réponse.');
    }

    // Retourner la vue avec la réponse à éditer
    return view('edit_reponse', compact('reponse'));
}
    public function destroyReponse($id)
    {
        $reponse = Reponse::findOrFail($id);

        // Vérification que l'utilisateur authentifié est celui qui a posté la réponse
        if ($reponse->id_user != auth()->user()->id_user) {
            return redirect()->route('professeur.questions.index')->with('error', 'Vous ne pouvez pas supprimer cette réponse.');
        }

        $reponse->delete();

        return redirect()->route('professeur.questions.index')->with('success', 'Réponse supprimée avec succès.');
    }
    // methode showw
    public function show($id)
{
    $question = Question::with('reponses.user', 'matiere', 'user')->findOrFail($id);
    return view('prof_forum_question_detail', compact('question'));
}

}


