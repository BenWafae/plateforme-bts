<?php 

namespace App\Http\Controllers;



use App\Models\Matiere;
use App\Models\Question;
use App\Models\User;

use App\Models\SupportEducatif;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;




class TableauDeBordController extends Controller

{

    public function index()

    {







    // Statistiques existantes…

    $studentsCount = User::where('role', 'etudiant')->count();

    $professorsCount = User::where('role', 'professeur')->count();

    $adminsCount = User::where('role', 'administrateur')->count();

    $supportsCount = SupportEducatif::count();
    // Derniers supports éducatifs
    $derniersSupports = SupportEducatif::with('matiere')
        ->latest() // Trie les supports par date de publication (du plus récent au plus ancien)
        ->take(5) // Limite à 5 derniers supports
        ->get();
          // Dernières questions posées
          $dernièresQuestions = Question::with('user')
          ->orderBy('date_pub', 'desc')
          ->take(5)
          ->get();


    $userRoles = [

        'Étudiants' => $studentsCount,

        'Professeurs' => $professorsCount,

        'Administrateurs' => $adminsCount,

    ];



    // Nouveauté : Répartition des supports par matière

    $supportsParMatiere = Matiere::withCount('supportsEducatifs')->get()->mapWithKeys(function ($matiere) {

        // ici laraveel recuperer tous les matieres et compt combieen de support existe par matiere 

        // mapwithkey ici::: on transmet les les resultats en cle(nom de la matiere ) et par valeur ::: c la valeur de support

        return [$matiere->Nom => $matiere->supports_educatifs_count];

    });
    $repartitionMatieresParFiliere = \App\Models\Filiere::withCount('matieres')->get()->mapWithKeys(function ($filiere) {
        return [$filiere->nom_filiere => $filiere->matieres_count];
    });
    
     


    return view('TableauDeBord', compact(

        'studentsCount',

        'professorsCount',

        'adminsCount',

        'supportsCount',

        'userRoles',

        'supportsParMatiere',

        'repartitionMatieresParFiliere',

        'derniersSupports',

        'dernièresQuestions',

     

    ));

}

}

