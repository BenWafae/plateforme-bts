<?php 
namespace App\Http\Controllers;

use App\Models\Filiere;
use Illuminate\Http\Request;

class FiliereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Récupérer le terme de recherche depuis la requête
        $searchTerm = $request->input('search');

        // Récupérer toutes les filières en tenant compte du terme de recherche
        $filieres = Filiere::query()
            ->when($searchTerm, function ($query, $searchTerm) {
                // Si un terme de recherche est fourni, filtrer par nom_filiere
                return $query->where('nom_filiere', 'like', '%' . $searchTerm . '%');
            })
            ->paginate(5); // Pagination de 5 éléments par page

        //  Préserver le terme de recherche dans les liens de pagination
        $filieres->appends($request->query());

        // Retourner la vue avec les filières et le terme de recherche
        return view('filiere', compact('filieres', 'searchTerm'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('form_filiere');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'nom_filiere' => 'required|string|min:5|max:255|unique:filieres',
        ], [
            'nom_filiere.required' => 'Le nom de la filière est obligatoire.',
            'nom_filiere.string' => 'Le nom de la filière doit être une chaîne de caractères.',
            'nom_filiere.min' => 'Le nom de la filière doit contenir au moins 5 caractères.',
            'nom_filiere.max' => 'Le nom de la filière ne peut pas dépasser 255 caractères.',
            'nom_filiere.unique' => 'La filière existe déjà dans la base de données.',
        ]);

        // Insertion de la filière dans la base de données
        Filiere::create([
            'nom_filiere' => $request->nom_filiere,  
        ]);

        // Redirection avec un message de succès
        return redirect()->route('filiere.form')->with('success', 'Filière ajoutée avec succès!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Filiere  $filiere
     * @return \Illuminate\Http\Response
     */
    public function show(Filiere $filiere)
    {
        // Afficher les détails de la filière (si nécessaire)
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Filiere  $filiere
     * @return \Illuminate\Http\Response
     */
    public function edit($id_filiere)
    {
        // Récupérer la filière à éditer
        $filiere = Filiere::findOrFail($id_filiere);
    
        // Passer la filière à la vue pour la modifier
        return view('filiere_edit', compact('filiere'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Filiere  $filiere
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_filiere)
    {
        // Récupérer la filière à éditer
        $filiere = Filiere::findOrFail($id_filiere);
    
        // Validation des données
        $request->validate([
            'nom_filiere' => 'required|string|min:5|max:255|unique:filieres,nom_filiere,' . $id_filiere . ',id_filiere',
        ], [
            'nom_filiere.required' => 'Le nom de la filière est obligatoire.',
            'nom_filiere.string' => 'Le nom de la filière doit être une chaîne de caractères.',
            'nom_filiere.min' => 'Le nom de la filière doit contenir au moins 5 caractères.',
            'nom_filiere.max' => 'Le nom de la filière ne peut pas dépasser 255 caractères.',
            'nom_filiere.unique' => 'La filière existe déjà dans la base de données.',
        ]);
    
        // Mise à jour de la filière
        $filiere->update([
            'nom_filiere' => $request->nom_filiere,
        ]);
    
        // Redirection avec un message de succès
        return redirect()->route('filiere.index')->with('success', 'Filière mise à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Filiere  $filiere
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_filiere)
    {
        $filiere = Filiere::findOrFail($id_filiere);  // Trouver la filière par son ID
        $filiere->delete();  // Supprimer la filière
    
        return redirect()->route('filiere.index')->with('success', 'Filière supprimée avec succès!');
    }
}