<?php 

namespace App\Http\Controllers;



use App\Models\Matiere;

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
    
     


    return view('TableauDeBord', compact(

        'studentsCount',

        'professorsCount',

        'adminsCount',

        'supportsCount',

        'userRoles',

        'supportsParMatiere',

     

    ));

}

}


