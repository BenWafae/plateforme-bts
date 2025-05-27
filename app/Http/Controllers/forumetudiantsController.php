<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Question;
use App\Models\Reponse;
use App\Models\Matiere;
use App\Events\NewQuestionPosted;
use App\Events\ReponseAjoutee;
use App\Events\QuestionSupprimee;
use App\Events\ReponseCreee;

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

       if ($request->has('year') && $request->year) {
    $query->whereYear('created_at', $request->year);
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
        // Validation des données
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenue' => 'required|string',
            'id_Matiere' => 'required|exists:matieres,id_Matiere',
        ]);

        // Création de la question
        $question = Question::create([
            'titre' => $request->titre,
            'contenue' => $request->contenue,
            'id_user' => Auth::id(),
            'id_Matiere' => $request->id_Matiere,
        ]);
       $user = Auth::user(); // ✅ on récupère l'objet User
      event(new NewQuestionPosted($question, $user)); // 

         // Déclencher l'événement QuestionCreee
                event(new \App\Events\QuestionCreee($question));

        // Rediriger l'utilisateur vers le forum avec un message de succès
        return redirect()->route('forumetudiants.index')->with('success', 'Votre question a été envoyée.');
    }

    /**
     * Supprimer une question
     */
    public function destroyQuestion($id_question)
    {
        $question = Question::where('id_question', $id_question)->first();
        if (!$question) {
            return redirect()->route('forumetudiants.index')->with('error', 'Question non trouvée.');
        }
        if ($question->id_user != Auth::id()) {
            return redirect()->route('forumetudiants.index')->with('error', 'Vous ne pouvez pas supprimer cette question.');
        }

        // Suppression de la question
        $question->delete();

        // Déclencher l'événement QuestionSupprimee
        event(new QuestionSupprimee($question));

        return redirect()->route('forumetudiants.index')->with('success', 'Votre question a été supprimée.');
    }

    /**
     *use App\Models\Reponse;
     * Enregistrer une réponse à une question
     */
    public function storeReponse(Request $request, $id_question)
    {
        $request->validate([
            'contenu' => 'required|string',
        ]);

        // Vérifier si la question existe
        $question = Question::find($id_question);
        if (!$question) {
            return redirect()->route('forumetudiants.index')->with('error', 'Question non trouvée.');
        }

        // Création de la réponse
        $reponse = Reponse::create([
            'contenu' => $request->contenu,
            'id_user' => Auth::id(),
            'id_question' => $id_question,
        ]);

        // Déclencher l'événement ReponseAjoutee
        // Déclencher l'événement seulement si l'étudiant ne répond pas à sa propre question
        // evenement reponse creer pour les profs 
         event(new ReponseCreee($reponse)); 

        event(new ReponseAjoutee($reponse));
    
        return redirect()->route('forumetudiants.index')->with('success', 'Votre réponse a été ajoutée.');
    }

    /**
     * Supprimer une réponse
     */
    public function destroyReponse($id_reponse)
    {
        $reponse = Reponse::find($id_reponse);

        // Vérifier si la réponse existe et appartient à l'utilisateur
        abort_if(!$reponse, 404, 'Réponse non trouvée.');
        abort_if($reponse->id_user != Auth::id(), 403, 'Vous ne pouvez pas supprimer cette réponse.');

        // Suppression de la réponse
        $reponse->delete();

        return redirect()->route('forumetudiants.index')->with('success', 'Votre réponse a été supprimée.');
    }
}