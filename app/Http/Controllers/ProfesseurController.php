<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\SupportEducatif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfesseurController extends Controller
{
    
     public function dashboard()
{
    if (Auth::check()) {
        $prof = Auth::user();

        // Compter le nombre de supports créés par ce professeur
        $nombreSupports = SupportEducatif::where('id_user', $prof->id_user)->count();

         // Récupérer les matières du prof
        $matieresProf = $prof->matieres;

        // Nombre total de questions posées dans ces matières
        $nombreQuestionsDansMatieres = Question::whereIn('id_Matiere', $matieresProf->pluck('id_Matiere'))->count();



           //  Récupérer les 5 derniers supports du professeur
       $derniersSupports = SupportEducatif::where('id_user', $prof->id_user)
         
         ->orderBy('created_at', 'desc')
         ->take(5)
         ->get();



         $derniersSupports->load('matiere');


         // Récupérer les 5 dernières questions posées dans les matières du prof
       $dernieresQuestions = Question::with(['user', 'matiere'])
       ->whereIn('id_Matiere', $matieresProf->pluck('id_Matiere'))
       ->orderBy('date_pub', 'desc')
        ->take(5)
        ->get();

         
        return view('professeur_dashboard', compact('nombreSupports', 'nombreQuestionsDansMatieres' ,'derniersSupports' ,  'dernieresQuestions'));
    } else {
        return redirect()->route('login');
    }
}
}

