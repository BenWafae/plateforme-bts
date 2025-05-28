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
        $filieres = Filiere::all();

        if ($request->has('annee')) {
            $filieres = $filieres->filter(function ($filiere) use ($request) {
                return strpos($filiere->nom_filiere, $request->input('annee')) !== false;
            });
        }

        $matières = [];
        if ($request->has('filiere_id')) {
            $filiere = Filiere::find($request->input('filiere_id'));
            if ($filiere) {
                $matières = $filiere->matieres;
            }
        }

        $types = Type::all();

        // Construire la requête
        $supportsQuery = SupportEducatif::query();

        // 🔍 Requête de recherche (titre ou description)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $supportsQuery->where(function ($query) use ($search) {
                $query->where('titre', 'like', "%$search%")
                      ->orWhere('description', 'like', "%$search%");
            });
        }

        // Si pas de recherche mais des filtres
        if (!$request->filled('search')) {
            if ($request->filled('matiere_id')) {
                $supportsQuery->where('id_Matiere', $request->input('matiere_id'));
            }

            if ($request->filled('type_id')) {
                $supportsQuery->where('id_type', $request->input('type_id'));
            }
        }

        // Résultats paginés
        $supports = $supportsQuery->orderBy('created_at', 'desc')->paginate(16);

        $user = auth()->user();
        $questions = Question::where('id_user', $user->id)->get();
        $reponses = Reponse::whereIn('id_question', $questions->pluck('id_question'))->get();

        return view('etudiant_dashboard', compact('filieres', 'matières', 'types', 'supports', 'user', 'questions', 'reponses'));
    }
}