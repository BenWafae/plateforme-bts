<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use App\Models\SupportEducatif;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSupportController extends Controller

   

    {
        public function index(Request $request)
{
    $professeurId = $request->input('professeur_id');
    $format = $request->input('format');

    // Vérifier si un professeur est sélectionné
    if ($professeurId) {
        // Si un professeur est sélectionné, récupérer ses matières
        $matieres = Matiere::whereHas('supportsEducatifs', function ($query) use ($professeurId) {
            $query->where('id_user', $professeurId);
        })->paginate(3);
    } else {
        // Sinon, récupérer toutes les matières paginées
        $matieres = Matiere::paginate(2);
    }

    // Récupérer les supports éducatifs en fonction du professeur et/ou du format sélectionné
    $supportsQuery = SupportEducatif::with('matiere', 'type', 'user');

    // Filtrer par professeur si sélectionné
    if ($professeurId) {
        $supportsQuery->where('id_user', $professeurId);
    }

    // Filtrer par format si sélectionné
    if ($format) {
        $supportsQuery->where('format', $format);
    }

    // Exécuter la requête pour obtenir les supports
    $supports = $supportsQuery->get();

    // Regrouper les supports par matière et type
    $supportsParMatiereEtType = $supports->groupBy(fn($support) => $support->id_Matiere . '-' . $support->id_type);

    // Récupérer tous les types et les professeurs
    $types = Type::all();
    $professeurs = User::where('role', 'professeur')->get();

    return view('admin_support_index', compact('supportsParMatiereEtType', 'matieres', 'types', 'professeurs'));
}


    



    
    
    
    public function create()
    {
        $matieres = Matiere::all();
        $types = Type::all();
        $professeurs = User::where('role', 'professeur')->get();

        return view('create_support_admin', compact('matieres', 'types', 'professeurs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'format' => 'required|string|max:50',
            'id_Matiere' => 'required|exists:matieres,id_Matiere',
            'id_type' => 'required|exists:types,id_type',
            'id_user' => 'required|exists:users,id_user',
        ]);

        if ($request->input('format') === 'lien_video') {
            $validated['lien_url'] = $request->validate([
                'video_url' => 'required|url',
            ])['video_url'];
        } else {
            $validated['lien_url'] = $request->validate([
                'lien_url' => 'required|file|mimes:pdf,doc,docx,ppt,pptx|max:2048',
            ])['lien_url'];

            if ($request->hasFile('lien_url') && $request->file('lien_url')->isValid()) {
                $validated['lien_url'] = $request->file('lien_url')->store('supports/' . $validated['id_user'], 'public');
            } else {
                return back()->withErrors(['lien_url' => 'Le fichier n\'est pas valide ou absent.']);
            }
        }

        SupportEducatif::create($validated);
        return redirect()->route('admin.supports.index')->with('success', 'Le support éducatif a été ajouté avec succès.');
    }

    public function showPdf($id)
    {
        $support = SupportEducatif::findOrFail($id);

        if (Storage::disk('public')->exists($support->lien_url)) {
            return response()->file(storage_path('app/public/' . $support->lien_url));
        }

        return redirect()->route('admin.supports.index')->with('error', 'Le fichier n\'existe pas.');
    }

    public function edit($id)
    {
        $support = SupportEducatif::findOrFail($id);
        $matieres = Matiere::all();
        $types = Type::all();
        $professeurs = User::where('role', 'professeur')->get();

        return view('admin_support_edit', compact('support', 'matieres', 'types', 'professeurs'));
    }

    public function update(Request $request, $id)
    {
        $support = SupportEducatif::findOrFail($id);

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'format' => 'required|string|max:50',
            'id_Matiere' => 'required|exists:matieres,id_Matiere',
            'id_type' => 'required|exists:types,id_type',
            'id_user' => 'required|exists:users,id_user',
        ]);

        if ($request->input('format') === 'lien_video') {
            // Si le support est un lien vidéo, on met à jour uniquement l'URL
            $validated['lien_url'] = $request->validate([
                'video_url' => 'required|url',
            ])['video_url'];
        } else {
            if ($request->hasFile('lien_url')) {
                if ($support->lien_url && Storage::disk('public')->exists($support->lien_url)) {
                    Storage::disk('public')->delete($support->lien_url);
                }

                $validated['lien_url'] = $request->file('lien_url')->store('supports/' . $validated['id_user'], 'public');
            } else {
                unset($validated['lien_url']);
            }
        }

        $support->update($validated);
        return redirect()->route('admin.supports.index')->with('success', 'Le support a été mis à jour avec succès.');
    }

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