<?php

namespace App\Http\Controllers;

use App\Events\SupportConsulted;
use App\Events\SupportDownloaded;
use App\Models\Matiere;
use App\Models\SupportEducatif;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SupportController extends Controller
{
    public function index()
    {
        $supports = SupportEducatif::with('matiere', 'type', 'user')
            ->where('id_user', auth()->id())
            ->get();

        $supportsParMatiereEtType = $supports->groupBy(function ($support) {
            return $support->id_Matiere . '-' . $support->id_type;
        });

        $matieres = Matiere::all();
        $types = Type::all();

        return view('support_index', compact('supportsParMatiereEtType', 'matieres', 'types'));
    }

    public function create()
    {
        $matieres = Matiere::all();
        $types = Type::all();

        return view('create_support_prof', compact('matieres', 'types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'lien_url' => 'required|file|mimes:pdf,doc,docx,ppt,pptx',
            'format' => 'required|string|max:50',
            'id_Matiere' => 'required|exists:matieres,id_Matiere',
            'id_type' => 'required|exists:types,id_type'
        ]);

        if ($request->hasFile('lien_url') && $request->file('lien_url')->isValid()) {
            $filePath = $request->file('lien_url')->store('supports/' . auth()->id(), 'public');
        } else {
            return back()->withErrors(['lien_url' => 'Le fichier n\'est pas valide ou absent.']);
        }

        SupportEducatif::create([
            'titre' => $validated['titre'],
            'description' => $validated['description'],
            'lien_url' => $filePath,
            'format' => $validated['format'],
            'id_Matiere' => $validated['id_Matiere'],
            'id_type' => $validated['id_type'],
            'id_user' => auth()->id(),
        ]);

        return redirect()->route('supports.index')->with('success', 'Le support éducatif a été ajouté avec succès.');
    }

    public function showPdf($id)
    {
        $support = SupportEducatif::findOrFail($id);

        if (Storage::disk('public')->exists($support->lien_url)) {
            if (Auth::check() && Auth::user()->role === 'etudiant') {
                Log::info('Début consultation support', [
                    'etudiant_id' => Auth::id(),
                    'support_id' => $support->id_support
                ]);

                event(new SupportConsulted(Auth::user(), $support));

                Log::info('Event SupportConsulted dispatché', [
                    'etudiant_id' => Auth::id(),
                    'support_id' => $support->id_support
                ]);
            }

            return response()->file(storage_path('app/public/' . $support->lien_url));
        }

        return redirect()->route('supports.index')->with('error', 'Le fichier n\'existe pas.');
    }

    public function download($id)
    {
        $support = SupportEducatif::findOrFail($id);

        if (Storage::disk('public')->exists($support->lien_url)) {
            if (Auth::check() && Auth::user()->role === 'etudiant') {
                Log::info('Début téléchargement support', [
                    'etudiant_id' => Auth::id(),
                    'support_id' => $support->id_support
                ]);

                event(new SupportDownloaded(Auth::user(), $support));

                Log::info('Event SupportDownloaded dispatché', [
                    'etudiant_id' => Auth::id(),
                    'support_id' => $support->id_support
                ]);
            }

            return response()->download(storage_path('app/public/' . $support->lien_url));
        }

        return redirect()->route('supports.index')->with('error', 'Le fichier n\'existe pas.');
    }

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

    public function update(Request $request, $id)
    {
        $support = SupportEducatif::findOrFail($id);

        if ($support->id_user != auth()->id()) {
            return redirect()->route('supports.index')->with('error', 'Vous ne pouvez pas modifier ce support.');
        }

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'lien_url' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx',
            'format' => 'required|string|max:50',
            'id_Matiere' => 'required|exists:matieres,id_Matiere',
            'id_type' => 'required|exists:types,id_type'
        ]);

        if ($request->hasFile('lien_url') && $request->file('lien_url')->isValid()) {
            if (Storage::disk('public')->exists($support->lien_url)) {
                Storage::disk('public')->delete($support->lien_url);
            }

            $filePath = $request->file('lien_url')->store('supports/' . auth()->id(), 'public');
            $support->lien_url = $filePath;
        }

        $support->titre = $validated['titre'];
        $support->description = $validated['description'];
        $support->format = $validated['format'];
        $support->id_Matiere = $validated['id_Matiere'];
        $support->id_type = $validated['id_type'];

        $support->save();

        return redirect()->route('supports.index')->with('success', 'Le support éducatif a été mis à jour avec succès.');
    }

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
