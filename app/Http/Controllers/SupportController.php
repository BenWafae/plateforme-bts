<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use App\Models\SupportEducatif;
use App\Models\Type;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    // Récupérer les supports créés par l'utilisateur (professeur) actuellement connecté
    
    
        // Récupérer les supports créés par l'utilisateur (professeur) actuellement connecté
        $supports = SupportEducatif::with('matiere', 'type', 'user')
            ->where('id_user', auth()->id()) // Filtrer par l'ID de l'utilisateur connecté
            ->get();
        
        // Organiser les supports par matière et type
        $supportsParMatiereEtType = $supports->groupBy(function ($support) {
            return $support->id_Matiere . '-' . $support->id_type;
        });

        // Récupérer uniquement les matières associées à l'utilisateur connecté
        //  récupère les matières qui sont associées à des supports éducatifs créés par
        //  l'utilisateur connecté. La méthode whereHas permet de filtrer les matières en fonction des supports éducatifs qui leur sont associés, en filtrant uniquement ceux de l'utilisateur connecté.
        $matieres = Matiere::whereHas('supportsEducatifs', function($query) {
            $query->where('id_user', auth()->id()); // Filtrer par l'utilisateur connecté
        })->paginate(1); // Pagination avec 2 matières par page

        // Récupérer les types pour affichage correct
        $types = Type::all(); 
        
        // Passer les données à la vue
        return view('support_index', compact('supportsParMatiereEtType', 'matieres', 'types'));
    }


    
    


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Récupérer touuss less matières depuis la base de données
        $matieres = Matiere::all();
        // recuperer les types des support;
        $types = Type::all();

        // envoyeeer  les variablee à la vue
        return view('create_support_prof', compact('matieres', 'types'));
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
         $validated = $request->validate([
             'titre' => 'required|string|max:255',
             'description' => 'required|string|max:1000',
             'format' => 'required|string|max:50',
             'id_Matiere' => 'required|exists:matieres,id_Matiere',
             'id_type' => 'required|exists:types,id_type',
         ]);
     
         // Vérification du format
         if ($request->input('format') === 'lien_video') {
             // Si le format est un lien vidéo, on valide le lien URL
             $validated['lien_url'] = $request->validate([
                 'video_url' => 'required|url',
             ])['video_url'];
     
             // Pas besoin de traiter un fichier pour le lien vidéo
             $lienUrl = $validated['lien_url'];
         } else {
             // Si le format est un fichier (pdf, ppt, etc.)
             $validated['lien_url'] = $request->validate([
                 'lien_url' => 'required|file|mimes:pdf,doc,docx,ppt,pptx',
             ])['lien_url'];
     
             // Vérification et stockage du fichier
             if ($request->hasFile('lien_url') && $request->file('lien_url')->isValid()) {
                 $lienUrl = $request->file('lien_url')->store('supports/' . auth()->id(), 'public');
             } else {
                 return back()->withErrors(['lien_url' => 'Le fichier n\'est pas valide ou absent.']);
             }
         }
     
         // Créer le support éducatif dans la base de données
         SupportEducatif::create([
             'titre' => $validated['titre'],
             'description' => $validated['description'],
             'lien_url' => $lienUrl,  // Enregistrer le lien ou le chemin du fichier
             'format' => $validated['format'],
             'id_Matiere' => $validated['id_Matiere'],
             'id_type' => $validated['id_type'],
             'id_user' => auth()->id(), // ID de l'utilisateur connecté
         ]);
     
         // Rediriger avec un message de succès
         return redirect()->route('supports.index')->with('success', 'Le support éducatif a été ajouté avec succès.');
     }
     

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showPdf($id)
    {
        // Récupérer le support éducatif spécifique
        // findOrfaill recherche un support educative dans la base de dnnee 
        // d'il existe il l'affiche sinon il retouren un erreur not found
        $support = SupportEducatif::findOrFail($id);  // Trouve le support ou échoue si non trouvé

        // Vérifier si le fichier existe
        if (Storage::disk('public')->exists($support->lien_url)) {
            // Rediriger vers l'URL du fichier ou ouvrir une vue avec le PDF
            return response()->file(storage_path('app/public/' . $support->lien_url));
        }

        // Si le fichier n'existe pas, rediriger avec un message d'erreur
        return redirect()->route('supports.index')->with('error', 'Le fichier n\'existe pas.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Récupérer le support éducatif
        $support = SupportEducatif::findOrFail($id);

        // Vérifier si l'utilisateur connecté est bien celui qui a créé le support
        if ($support->id_user != auth()->id()) {
            return redirect()->route('supports.index')->with('error', 'Vous ne pouvez pas modifier ce support.');
        }

        // Récupérer les matières et types
        $matieres = Matiere::all();
        $types = Type::all();

        // Retourner la vue avec les données nécessaires
        return view('support_edit', compact('support', 'matieres', 'types'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $support = SupportEducatif::findOrFail($id);
    
        // Validation des données
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'format' => 'required|string|max:50',
            'id_Matiere' => 'required|exists:matieres,id_Matiere',
            'id_type' => 'required|exists:types,id_type',
        ]);
    
        // Vérification du format et traitement du lien vidéo ou fichier
        if ($request->input('format') === 'lien_video') {
            $validated['lien_url'] = $request->validate([
                'video_url' => 'required|url',
            ])['video_url'];
        } else {
            if ($request->hasFile('lien_url')) {
                // Supprimer l'ancien fichier si un nouveau est téléchargé
                if ($support->lien_url && Storage::exists($support->lien_url)) {
                    Storage::delete($support->lien_url);
                }
    
                // Enregistrer le nouveau fichier
                $validated['lien_url'] = $request->file('lien_url')->store('supports');
            }
        }
    
        // Mettre à jour les informations du support
        $support->update($validated);
    
        return redirect()->route('supports.index')->with('success', 'Support mis à jour avec succès.');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


        // Trouver le support éducatif avec l'ID
        $support = SupportEducatif::findOrFail($id);

        // il faut dabord veriiiifier si le prof connecter est celui quii vaa suprimer le support
        if ($support->id_user != auth()->id()) {
            return redirect()->route('supports.index')->with('error', 'Vous ne pouvez pas supprimer ce support.');
        }

        // verifier si le support existe dans storage/support on va le suuprrimer apres
        if (Storage::disk('public')->exists($support->lien_url)) {
            Storage::disk('public')->delete($support->lien_url);
        }

        // Supprimer le support de la base de données
        $support->delete();

        // Rediriger avec un message de succès
        return redirect()->route('supports.index')->with('success', 'Le support éducatif a été supprimé avec succès.');
    }
}