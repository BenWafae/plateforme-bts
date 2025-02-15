<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Matiere;
use Illuminate\Http\Request;

class MatiereController extends Controller
{

    // public function search(Request $request)
    // {
    //     $query = $request->input('query');
    //     $filterFiliere = $request->input('filiere');
    
    //     // Construire la requête
    //     $matieres = Matiere::with('filiere')
    //         ->where('Nom', 'LIKE', "%$query%")
    //         ->when($filterFiliere, function ($queryBuilder) use ($filterFiliere) {
    //             $queryBuilder->whereHas('filiere', function ($q) use ($filterFiliere) {
    //                 $q->where('nom_filiere', 'LIKE', "%$filterFiliere%");
    //             });
    //         })
    //         ->get();
    
    //     return response()->json($matieres);
    // }
    










    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Récupérer toutes les matières associées aux filières
        $matieres = Matiere::with('filiere')->paginate(8);
    
        // Récupérer toutes les filières
        $filieres = Filiere::all();
    
        // Passer les variables à la vue
        return view('matiere_index', compact('matieres', 'filieres'));
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
        
        // Passer les filières à la vue
        return view('form_matiere', compact('filieres'));
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
        // on va verifier si lid existe dejaaa dans table fileire;
    ]);
// la creation de la matiere dans la base de donneee;
    Matiere::create([
        'Nom' => $validated['Nom'],
        'description' => $validated['description'],
        'id_filiere' => $validated['id_filiere'],
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
        
        
        return view('matiere_edit', compact('matiere', 'filieres'));
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
        ]);
    
        // Mettre à jour les données de la matière
        $matiere->update([
            'Nom' => $validated['Nom'],
            'description' => $validated['description'],
            'id_filiere' => $validated['id_filiere'],
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
