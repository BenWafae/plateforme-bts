<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Matiere;
use App\Models\Type;
use App\Models\Question;
use App\Models\Reponse;
use Illuminate\Http\Request;
use App\Models\SupportEducatif;

class EtudiantController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = auth()->user();

        // ✅ On récupère la filière de l'étudiant
        $filiere = $user->filiere;

        // ✅ On récupère les matières associées à sa filière
        $matières = $filiere ? $filiere->matieres : collect();

        // ✅ Tous les types de support
        $types = Type::all();

        // 🔍 Requête des supports
        $supportsQuery = SupportEducatif::query();

        // Si une recherche par mot-clé
        if ($request->filled('search')) {
            $search = $request->input('search');
            $supportsQuery->where(function ($query) use ($search) {
                $query->where('titre', 'like', "%$search%")
                      ->orWhere('description', 'like', "%$search%");
            });
        } else {
            // Filtrer uniquement par matière de la filière de l'étudiant
            $matiereIds = $matières->pluck('id_Matiere');

            $supportsQuery->whereIn('id_Matiere', $matiereIds);

            if ($request->filled('matiere_id')) {
                $supportsQuery->where('id_Matiere', $request->input('matiere_id'));
            }

            if ($request->filled('type_id')) {
                $supportsQuery->where('id_type', $request->input('type_id'));
            }
        }

        // Pagination des résultats
        $supports = $supportsQuery->orderBy('created_at', 'desc')->paginate(16);

        // Pour les questions/réponses de l'étudiant
        $questions = Question::where('id_user', $user->id)->get();
        $reponses = Reponse::whereIn('id_question', $questions->pluck('id_question'))->get();

        return view('etudiant_dashboard', compact('matières', 'types', 'supports', 'user', 'questions', 'reponses'));
    }
}