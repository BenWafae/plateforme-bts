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
        // Types principaux
        $types = Type::whereIn('nom', ['cours', 'exercice', 'examen'])->get();

        // Filtrage des filières
        $filieres = Filiere::all();
        if ($request->filled('annee')) {
            $filieres = $filieres->filter(function ($filiere) use ($request) {
                return strpos($filiere->nom_filiere, $request->annee) !== false;
            });
        }

        // Matières en fonction de la filière
        $matieres = collect();
        if ($request->filled('filiere_id')) {
            $filiere = Filiere::find($request->filiere_id);
            if ($filiere) {
                $matieres = $filiere->matieres;
            }
        }

        // Supports éducatifs avec pagination
        $supports = collect();
        if ($request->filled('matiere_id') && $request->filled('type')) {
            $matiere = Matiere::find($request->matiere_id);
            if ($matiere) {
                $supportsQuery = $matiere->supportsEducatifs()
                    ->whereHas('type', function ($q) use ($request) {
                        $q->where('nom', $request->type);
                    })
                    ->where('prive', 0)
                    ->latest();

                // Paginer les résultats
               $supports = $supportsQuery->paginate(10);


                // Ajouter les URLs d'action
                $supports->getCollection()->transform(function ($support) {
                    $support->action_url = $this->getActionUrl($support);
                    $support->action_type = $this->getActionType($support);
                    return $support;
                });
            }
        }

        return view('Accueil', compact('types', 'filieres', 'matieres', 'supports'));
    }

    /**
     * Détermine l'URL d'action appropriée pour un support
     */
    protected function getActionUrl(SupportEducatif $support)
    {
        return match ($support->format) {
            'pdf' => route('fichiers.view', $support->id_support),
            'video' => $support->lien_url,
            default => route('fichiers.download', $support->id_support),
        };
    }

    /**
     * Détermine le type d'action (view, download, video)
     */
    protected function getActionType(SupportEducatif $support)
    {
        return match ($support->format) {
            'pdf' => 'view',
            'video' => 'video',
            default => 'download',
        };
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

        $filePath = storage_path('app/public/' . $support->chemin);

        if (!file_exists($filePath)) {
            abort(404, 'Fichier non trouvé');
        }

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . Str::slug($support->titre) . '.pdf"'
        ]);
    }

    /**
     * Télécharge un fichier
     */
    public function download($id)
    {
        $support = SupportEducatif::findOrFail($id);
        $filePath = storage_path('app/public/' . $support->chemin);

        if (!file_exists($filePath)) {
            abort(404, 'Fichier non trouvé');
        }

        $extension = pathinfo($support->chemin, PATHINFO_EXTENSION);

        return response()->download(
            $filePath,
            Str::slug($support->titre) . '.' . $extension,
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
            'mp4' => 'video/mp4',
        ];

        return $mimeTypes[strtolower($extension)] ?? 'application/octet-stream';
    }
}
