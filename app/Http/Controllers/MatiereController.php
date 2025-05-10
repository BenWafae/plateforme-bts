<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Matiere;
use App\Models\User;
use Illuminate\Http\Request;

class MatiereController extends Controller
{

   
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // ici on recupere less filteers selectionnee dans la requete geet 
        $filiereFilter = $request->input('filiere', 'all');
        // recupere le text saisie par lutilisateur dans la barre de recherche
        $searchQuery = $request->input('search');
    
        // Requête de base
        // unnee requeet eloquentt pour recuperer les matiere de la base de donnee
        $matieresQuery = Matiere::query();
    
        // Filtrer par filière

        if ($filiereFilter !== 'all') {
            // wherehaass signifiee que je veuxx seulement les matieres qui ont une filiere avec un nomm de filieree deja exist
            $matieresQuery->whereHas('filiere', function($query) use ($filiereFilter) {
                // wherraw sert a convertir le nom de la filiere en miniscule pour comparer 
                $query->whereRaw('LOWER(nom_filiere) = ?', [strtolower($filiereFilter)]);
            });
        }
    
        // Appliquer la recherche sur le nom de la matière
        if (!empty($searchQuery)) {
            $matieresQuery->where('Nom', 'LIKE', "%{$searchQuery}%");
        }
    
        // Paginer les résultats après avoir appliqué les filtres et la recherche
        $matieres = $matieresQuery->paginate(5)->appends([
            'filiere' => $filiereFilter,
            'search' => $searchQuery,
        ]);
    
        $filieres = Filiere::all();
    
        return view('matiere_index', compact('matieres', 'filieres', 'filiereFilter', 'searchQuery'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Récupérer les filières existantes
        $filieres = Filiere::all();
        // Associer un professeur (id_user) à cette matière, pour dire que c’est lui qui va l’enseigner.
         $professeurs = User::where('role', 'professeur')->get(); 
        
        // Passer les filières à la vue
        return view('form_matiere', compact('filieres','professeurs'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    // commencant la validation;
    $validated = $request->validate([
        'Nom' => 'required|string|max:255|min:5',
        'description' => 'nullable|string',
        'id_filiere' => 'required|exists:filieres,id_filiere', 
        'id_user' => 'required|exists:users,id',
        
        // on va verifier si lid existe dejaaa dans table fileire;
    ]);
// la creation de la matiere dans la base de donneee;
    Matiere::create([
        'Nom' => $validated['Nom'],
        'description' => $validated['description'],
        'id_filiere' => $validated['id_filiere'],
        'id_user' => $validated['id_user'], 
    ]);

    // Rediriger vers la page des filières avec un message de succès
    return redirect()->route('matiere.index')->with('success', 'Matière ajoutée avec succès.');
}


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Matiere  $matiere
     * @return \Illuminate\Http\Response
     */
    public function show(Matiere $matiere)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Matiere  $matiere
     * @return \Illuminate\Http\Response
     */
    public function edit(Matiere $matiere)
    {
       
        $filieres = Filiere::all();
          $professeurs = User::where('role', 'professeur')->get();
        
        return view('matiere_edit', compact('matiere', 'filieres' , 'professeurs'));
        // passeee la matiere aa modiifier et ls fiilieres a la vue
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Matiere  $matiere
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Matiere $matiere)
    {
        // Validation des données
        $validated = $request->validate([
            'Nom' => 'required|string|max:255|min:5',
            'description' => 'nullable|string',
            'id_filiere' => 'required|exists:filieres,id_filiere',
            'id_user' => 'required|exists:users,id',
        ]);
    
        // Mettre à jour les données de la matière
        $matiere->update([
            'Nom' => $validated['Nom'],
            'description' => $validated['description'],
            'id_filiere' => $validated['id_filiere'],
            'id_user' => $validated['id_user'],
        ]);
    
        // Rediriger vers la liste des matières avec un message de succès
        return redirect()->route('matiere.index')->with('success', 'Matière mise à jour avec succès.');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Matiere  $matiere
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_Matiere)
    {
        $matiere = Matiere::find($id_Matiere);
    
        if ($matiere) {
            $matiere->delete();
            return redirect()->route('matiere.index')->with('success', 'Matière supprimée avec succès.');
        } else {
            return redirect()->route('matiere.index')->with('error', 'Matière introuvable.');
        }
    }

}