<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use App\Models\SupportEducatif;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Créer la requête de base pour récupérer les supports de l'utilisateur connecté
        $query = SupportEducatif::with('matiere', 'type', 'user')
            ->where('id_user', auth()->id()); // Filtrer par l'ID de l'utilisateur connecté

        // Vérification si un filtre par format est appliqué
        $format = $request->input('format', 'all'); // Par défaut 'all' si aucun format n'est sélectionné
        if ($format !== 'all') {
            $query->where('format', $format); // Filtrer selon le format sélectionné
        }

        // Récupérer tous les supports après application des filtres
        $supports = $query->get();

        // Organiser les supports par matière et type
        $supportsParMatiereEtType = $supports->groupBy(function ($support) {
            return $support->id_Matiere . '-' . $support->id_type;
        });

        // Vérification si un format est sélectionné, cela affectera la pagination des matières
        if ($format !== 'all') {
            // Si un format est sélectionné, récupérer les matières qui ont des supports dans ce format
            $matieresQuery = Matiere::whereHas('supportsEducatifs', function($query) use ($format) {
                $query->where('id_user', auth()->id());
                $query->where('format', $format);
            });

            // Pagination de 3 matières par page si un format est sélectionné
            $matieres = $matieresQuery->paginate(3);
        } else {
            // Sinon, récupérer les matières sans filtre par format et pagination de 1 matière par page
            $matieresQuery = Matiere::whereHas('supportsEducatifs', function($query) {
                $query->where('id_user', auth()->id());
            });

            $matieres = $matieresQuery->paginate(1);
        }

        // Récupérer les types pour affichage correct
        $types = Type::all();

        // Passer les données à la vue et conserver le paramètre 'format' dans l'URL de la pagination
        return view('support_index', compact('supportsParMatiereEtType', 'matieres', 'types', 'format'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Récupérer toutes les matières depuis la base de données
        $matieres = Matiere::all();
        // Récupérer les types des supports
        $types = Type::all();

        // Envoyer les variables à la vue
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
            'prive' => 'nullable|boolean',
        ]);

        // Définir la valeur de privé (0 ou 1)
        $validated['prive'] = $request->has('prive') ? 1 : 0;

        // Vérification du format
        if ($request->input('format') === 'lien_video') {
            $validated['lien_url'] = $request->validate([
                'video_url' => 'required|url',
            ])['video_url'];

            $lienUrl = $validated['lien_url'];
        } else {
            $validated['lien_url'] = $request->validate([
                'lien_url' => 'required|file|mimes:pdf,doc,docx,ppt,pptx',
            ])['lien_url'];

            if ($request->hasFile('lien_url') && $request->file('lien_url')->isValid()) {
                $lienUrl = $request->file('lien_url')->store('supports/' . auth()->id(), 'public');
            } else {
                return back()->withErrors(['lien_url' => 'Le fichier n\'est pas valide ou absent.']);
            }
        }

        SupportEducatif::create([
            'titre' => $validated['titre'],
            'description' => $validated['description'],
            'lien_url' => $lienUrl,
            'format' => $validated['format'],
            'id_Matiere' => $validated['id_Matiere'],
            'id_type' => $validated['id_type'],
            'id_user' => auth()->id(),
            'prive' => $validated['prive'],
        ]);

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
        $support = SupportEducatif::findOrFail($id);

        if (Storage::disk('public')->exists($support->lien_url)) {
            return response()->file(storage_path('app/public/' . $support->lien_url));
        }

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
        $support = SupportEducatif::findOrFail($id);

        if ($support->id_user != auth()->id()) {
            return redirect()->route('supports.index')->with('error', 'Vous ne pouvez pas modifier ce support.');
        }

        $matieres = Matiere::all();
        $types = Type::all();

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

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'format' => 'required|string|max:50',
            'id_Matiere' => 'required|exists:matieres,id_Matiere',
            'id_type' => 'required|exists:types,id_type',
            'prive' => 'nullable|boolean',
        ]);

        $validated['prive'] = $request->has('prive') ? 1 : 0;

        if ($request->input('format') === 'lien_video') {
            $validated['lien_url'] = $request->validate([
                'video_url' => 'required|url',
            ])['video_url'];
        } else {
            if ($request->hasFile('lien_url')) {
                if ($support->lien_url && Storage::disk('public')->exists($support->lien_url)) {
                    Storage::disk('public')->delete($support->lien_url);
                }

                $validated['lien_url'] = $request->file('lien_url')->store('supports/' . auth()->id(), 'public');
            }
        }

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
        $support = SupportEducatif::findOrFail($id);

        if ($support->id_user != auth()->id()) {
            return redirect()->route('supports.index')->with('error', 'Vous ne pouvez pas supprimer ce support.');
        }

        if (Storage::disk('public')->exists($support->lien_url)) {
            Storage::disk('public')->delete($support->lien_url);
        }

        $support->delete();

        return redirect()->route('supports.index')->with('success', 'Le support éducatif a été supprimé avec succès.');
    }
}