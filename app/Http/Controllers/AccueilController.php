<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportEducatif;
use App\Models\Type;
use App\Models\Matiere;
use App\Models\Filiere;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AccueilController extends Controller
{
    public function index(Request $request)
    {
        // Tous les types (ex: cours, exercice, examen)
        $types = Type::whereIn('nom', ['cours', 'exercice', 'examen'])->get();

        // Filieres : on récupère toutes puis on filtre par année si donnée
        $filieres = Filiere::all();
        if ($request->filled('annee')) {
            $annee = $request->input('annee');
            $filieres = $filieres->filter(function ($filiere) use ($annee) {
                return strpos($filiere->nom_filiere, $annee) !== false;
            });
        }

        // Matières selon la filière sélectionnée
        $matieres = collect();
        if ($request->filled('filiere_id')) {
            $filiere = Filiere::find($request->input('filiere_id'));
            if ($filiere) {
                $matieres = $filiere->matieres;
            }
        }

        // Supports selon la matière et le type, seulement publics
        $supports = collect();
        if ($request->filled('matiere_id') && $request->filled('type')) {
            $matiere = Matiere::with(['supportsEducatifs' => function ($query) use ($request) {
                $query->whereHas('type', function ($q) use ($request) {
                    $q->where('nom', $request->input('type'));
                })->where('prive', 0); // Filtrer supports publics uniquement
            }])->find($request->input('matiere_id'));

            if ($matiere) {
                $supports = $matiere->supportsEducatifs->each(function ($support) {
                    // Ajoute l'URL appropriée selon le format
                    $support->action_url = $this->getActionUrl($support);
                    // Ajoute le type d'action (view, download, video)
                    $support->action_type = $this->getActionType($support);
                });
            }
        }

        return view('accueil', compact('types', 'filieres', 'matieres', 'supports'));
    }

    /**
     * Détermine l'URL d'action appropriée pour un support
     */
    protected function getActionUrl(SupportEducatif $support)
{
    if ($support->format === 'pdf') {
        return route('fichiers.view', $support->id_support);
    } elseif ($support->format === 'video') {
        return $support->lien_url; // Lien externe direct
    } else {
        return route('fichiers.download', $support->id_support);
    }
}


    /**
     * Détermine le type d'action (view, download, video)
     */
    protected function getActionType(SupportEducatif $support)
    {
        if ($support->format === 'pdf') {
            return 'view';
        } elseif ($support->format === 'video') {
            return 'video';
        } else {
            return 'download';
        }
    }

    /**
     * Affiche un fichier PDF dans le navigateur
     */
    public function view($id)
    {
        $support = SupportEducatif::findOrFail($id);
        
        if ($support->format !== 'pdf') {
            abort(403, 'Seuls les fichiers PDF peuvent être visualisés');
        }

        $filePath = storage_path('app/public/'.$support->chemin);
        
        if (!file_exists($filePath)) {
            abort(404, 'Fichier non trouvé');
        }

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.Str::slug($support->titre).'.pdf"'
        ]);
    }

    /**
     * Télécharge un fichier
     */
    public function download($id)
    {
        $support = SupportEducatif::findOrFail($id);
        $filePath = storage_path('app/public/'.$support->chemin);
        
        if (!file_exists($filePath)) {
            abort(404, 'Fichier non trouvé');
        }
        
        $extension = pathinfo($support->chemin, PATHINFO_EXTENSION);
        return response()->download(
            $filePath,
            Str::slug($support->titre).'.'.$extension,
            ['Content-Type' => $this->getMimeType($extension)]
        );
    }

    /**
     * Retourne le type MIME selon l'extension
     */
    protected function getMimeType($extension)
    {
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'zip' => 'application/zip',
            'mp4' => 'video/mp4'
        ];
        
        return $mimeTypes[strtolower($extension)] ?? 'application/octet-stream';
    }
} 