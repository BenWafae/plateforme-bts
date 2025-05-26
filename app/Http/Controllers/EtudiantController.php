<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Matiere;
use App\Models\Type; // Ajouter ce modèle pour récupérer les types de supports
use App\Models\Question; // Importer le modèle Question
use App\Models\Reponse; // Importer le modèle Reponse
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    /**
     * Affiche le tableau de bord de l'étudiant avec les matières, les types de supports et les supports éducatifs.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function dashboard(Request $request)
    {
        // Récupérer toutes les filières
        $filieres = Filiere::all();

        // Si l'année est sélectionnée, filtrer les filières
        if ($request->has('annee')) {
            $filieres = $filieres->filter(function ($filiere) use ($request) {
                return strpos($filiere->nom_filiere, $request->input('annee')) !== false;
            });
        }

        // Récupérer les matières si une filière est sélectionnée
        $matières = [];
        if ($request->has('filiere_id')) {
            $filiere = Filiere::find($request->input('filiere_id'));
            if ($filiere) {
                $matières = $filiere->matieres;
            }
        }

        // Récupérer les types de supports (par exemple, Cours, Exercices, Examens)
        $types = Type::all();

        // Récupérer les supports si une matière est sélectionnée
        $supports = [];
        if ($request->has('matiere_id')) {
            $matiere = Matiere::with('supportsEducatifs')->find($request->input('matiere_id'));
            if ($matiere && $matiere->supportsEducatifs->isNotEmpty()) {
               $supports = $matiere->supportsEducatifs()
    ->orderBy('created_at', 'desc')
    ->paginate(16); // ✅ Ceci renvoie un LengthAwarePaginator

            }
        }

        // Récupérer l'utilisateur connecté pour le nom de l'étudiant
        $user = auth()->user(); // Utiliser l'authentification pour obtenir l'utilisateur connecté

        // Récupérer les questions de l'étudiant
        $questions = Question::where('id_user', $user->id)->get(); // Questions posées par l'étudiant

        // Récupérer les réponses associées à ces questions
        $reponses = Reponse::whereIn('id_question', $questions->pluck('id_question'))->get(); // Réponses des professeurs

        // Retourner la vue avec les données
        return view('etudiant_dashboard', compact('filieres', 'matières', 'types', 'supports', 'user', 'questions', 'reponses'));
    }

    /**
     * Permet à l'étudiant de poser une nouvelle question.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function poserQuestion(Request $request)
    {
        // Valider la question
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
        ]);

        // Créer la question
        Question::create([
            'titre' => $validated['titre'],
            'contenu' => $validated['contenu'],
            'id_user' => auth()->id(), // L'étudiant qui pose la question
        ]);

        return redirect()->back()->with('success', 'Votre question a été posée.');
    }
}