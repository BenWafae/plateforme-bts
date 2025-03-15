<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use App\Models\SupportEducatif;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use function PHPSTORM_META\type;

class AdminSupportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supports = SupportEducatif::with('matiere', 'type', 'user')->get();

        // Regrouper les supports par matière et type pour une meilleure organisation
        $supportsParMatiereEtType = $supports->groupBy(function ($support) {
            return $support->id_Matiere . '-' . $support->id_type;
        });

        $matieres = Matiere::all();
        $types = Type::all();

        return view('admin_support_index', compact('supportsParMatiereEtType', 'matieres', 'types'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $matieres = Matiere::all();
        $types = Type::all();
        $professeurs = User::where('role', 'professeur')->get(); // Récupérer uniquement les professeurs
    
        return view('create_support_admin', compact('matieres', 'types', 'professeurs'));
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
        'id_user' => 'required|exists:users,id_user', // ID du professeur sélectionné
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
            'lien_url' => 'required|file|mimes:pdf,doc,docx,ppt,pptx|max:2048',
        ])['lien_url'];

        // Vérification et stockage du fichier
        if ($request->hasFile('lien_url') && $request->file('lien_url')->isValid()) {
            $lienUrl = $request->file('lien_url')->store('supports/' . $validated['id_user'], 'public');
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
        'id_user' => $validated['id_user'], // ID du professeur sélectionné
    ]);

    // Rediriger avec un message de succès
    return redirect()->route('admin.supports.index')->with('success', 'Le support éducatif a été ajouté avec succès.');
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
        $support = SupportEducatif::findOrFail($id);
    
        // Vérifier si le fichier existe dans le stockage
        if (Storage::disk('public')->exists($support->lien_url)) {
            // Afficher le fichier PDF dans le navigateur
            return response()->file(storage_path('app/public/' . $support->lien_url));
        }
    
        // Si le fichier n'existe pas, rediriger avec un message d'erreur
        return redirect()->route('admin.supports.index')->with('error', 'Le fichier n\'existe pas.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $support = SupportEducatif::findOrFail($id);
        $matieres = Matiere::all();
        $types = Type::all();
        $professeurs = User::where('role', 'professeur')->get();
        // recupere les utilisaateurrs ayaant le role professeurs

        return view('admin_support_edit', compact('support', 'matieres', 'types' ,'professeurs' ));
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
    
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'lien_url' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:2048',
            'format' => 'required|string|max:50',
            'id_Matiere' => 'required|exists:matieres,id_Matiere',
            'id_type' => 'required|exists:types,id_type',
            'id_user' => 'required|exists:users,id_user',
        ]);
    
        // Vérifier si un nouveau fichier est téléchargé
        if ($request->hasFile('lien_url')) {
            // Supprimer l'ancien fichier
            if ($support->lien_url && Storage::disk('public')->exists($support->lien_url)) {
                Storage::disk('public')->delete($support->lien_url);
            }
    
            // Stocker le nouveau fichier
            $filePath = $request->file('lien_url')->store('supports/' . $validated['id_user'], 'public');
            $validated['lien_url'] = $filePath;
        } else {
            // Ne pas mettre à jour `lien_url` si aucun fichier n'est uploadé
            unset($validated['lien_url']);
        }
    
        // Mise à jour des autres champs
        $support->update($validated);
    
        return redirect()->route('admin.supports.index')->with('success', 'Le support a été mis à jour avec succès.');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $support = SupportEducatif::findOrFail($id);

        if (Storage::disk('public')->exists($support->lien_url)) {
            Storage::disk('public')->delete($support->lien_url);
        }

        $support->delete();

        return redirect()->route('admin.supports.index')->with('success', 'Le support a été supprimé avec succès.');
    }

}
