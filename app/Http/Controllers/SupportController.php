<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use App\Models\SupportEducatif;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpWord\IOFactory;
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

    // Fichier introuvable -> erreur 404
    abort(404, "Le fichier n'existe pas.");
}

public function download($id)
{
    $support = SupportEducatif::findOrFail($id);

    if ($support->id_user != auth()->id() && $support->prive) {
        // Accès refusé -> erreur 403
        abort(403, "Vous n'êtes pas autorisé à télécharger ce support.");
    }

    if (Storage::disk('public')->exists($support->lien_url)) {
        return Storage::disk('public')->download($support->lien_url);
    }

    // Fichier introuvable -> erreur 404
    abort(404, "Le fichier est introuvable.");
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

public function showUploadFolderForm()
{
    return view('importprof');
}

public function importerDossierProf(Request $request)
{
    set_time_limit(300);

    $request->validate([
        'dossier_supports' => 'required|array',
        'dossier_supports.*' => 'file',
    ]);

    $professeur = auth()->user();
    if (!$professeur) {
        return back()->withErrors('Vous devez être connecté pour importer.');
    }

    $nonDetectes = [];
    $matieres = Matiere::all(['id_Matiere', 'nom']);
    $types = Type::all(['id_type', 'nom']);

    foreach ($request->file('dossier_supports') as $uploadedFile) {
    // Stockage dans storage/app/public/supports/{user_id}/
    $lienUrl = $uploadedFile->store('supports/' . auth()->id(), 'public');

    // Chemin complet physique côté serveur
    $fullPath = storage_path('app/public/' . $lienUrl);
        $texte = $this->extraireTexteDepuisFichier($fullPath);
        $infoIA = $this->detecterTypeEtMatiereAvecIA($texte);

        $idType = $this->trouverIdType($infoIA['type']);
        $idMatiere = $this->trouverIdMatiere($infoIA['matiere']);

        if (is_null($idType) || is_null($idMatiere)) {
            $nonDetectes[] = [
                'nom' => $uploadedFile->getClientOriginalName(),
                'chemin' => $lienUrl,
            ];
            continue;
        }

        $extension = strtolower($uploadedFile->getClientOriginalExtension());
        $format = match ($extension) {
            'pdf' => 'pdf',
            'ppt', 'pptx' => 'ppt',
            'doc', 'docx' => 'word',
            'mp4', 'avi', 'mov' => 'lien_video',
            default => $extension,
        };

        // Ici : titre sans extension
        $nomFichier = $uploadedFile->getClientOriginalName();
        $titreSansExtension = pathinfo($nomFichier, PATHINFO_FILENAME);

        $support = new SupportEducatif();
        $support->titre = $titreSansExtension;  // Correction ici
        $support->description = "Import par professeur";
        $support->format = $format;
        $support->lien_url = $filePath;
        $support->id_Matiere = $idMatiere;
        $support->id_type = $idType;
        $support->id_user = $professeur->id;
        $support->save();
    }

    if (count($nonDetectes) > 0) {
        return view('importprof', [
            'nonDetectes' => $nonDetectes,
            'matieres' => $matieres,
            'types' => $types,
        ])->with('warning', 'Certains fichiers nécessitent une classification manuelle.');
    }

    return back()->with('success', 'Tous les fichiers ont été importés.');
}


public function validerImportManuel(Request $request)
{
    $prof = auth()->user();

    $request->validate([
        'fichiers' => 'required|array',
        'fichiers.*.nom' => 'required|string',
        'fichiers.*.chemin' => 'required|string',
        'fichiers.*.matiere_id' => 'required|integer|exists:matieres,id_Matiere',
        'fichiers.*.type_id' => 'required|integer|exists:types,id_type',
    ]);

    foreach ($request->fichiers as $fichier) {
        $support = new SupportEducatif();

        // Correction : titre sans extension
        $titreSansExtension = pathinfo($fichier['nom'], PATHINFO_FILENAME);
        $support->titre = $titreSansExtension;

        $cheminComplet = storage_path('app/' . $fichier['chemin']);
        $titreFichier = $this->extraireTitreDepuisFichier($cheminComplet);

        $support->description = $titreFichier ?: "Titre indisponible";

        $extension = strtolower(pathinfo($fichier['nom'], PATHINFO_EXTENSION));
        $format = match ($extension) {
            'pdf' => 'pdf',
            'ppt', 'pptx' => 'ppt',
            'doc', 'docx' => 'word',
            'mp4', 'avi', 'mov' => 'lien_video',
            default => $extension,
        };

        $support->format = $format;
        $support->lien_url = $fichier['chemin'];
        $support->id_Matiere = $fichier['matiere_id'];
        $support->id_type = $fichier['type_id'];
        $support->id_user = auth()->id();
        $support->save();
    }

    return redirect()->route('professeur.support.form')->with('success', 'Fichiers manuellement classés et importés avec succès.');
}


    private function extraireTexteDepuisFichier(string $chemin): string
    {
        $extension = strtolower(pathinfo($chemin, PATHINFO_EXTENSION));

        try {
            $texte = '';

            if ($extension === 'docx') {
                $phpWord = IOFactory::load($chemin);
                foreach ($phpWord->getSections() as $section) {
                    foreach ($section->getElements() as $element) {
                        if (method_exists($element, 'getText')) {
                            $texte .= $element->getText() . "\n";
                        }
                    }
                }
            } elseif ($extension === 'pdf') {
                $parser = new Parser();
                $pdf = $parser->parseFile($chemin);
                $texte = $pdf->getText();
            } else {
                $texte = file_get_contents($chemin);
            }

            $texte = mb_convert_encoding($texte, 'UTF-8', 'UTF-8');
            $texte = preg_replace('/[^\PC\s]/u', '', $texte);
            return trim($texte) ?: ' ';
        } catch (\Exception $e) {
            Log::error("Erreur extraction texte: " . $e->getMessage());
            return ' ';
        }
    }
private function extraireTitreDepuisFichier(string $chemin): string
{
    $extension = strtolower(pathinfo($chemin, PATHINFO_EXTENSION));
    try {
        if ($extension === 'docx') {
            $phpWord = IOFactory::load($chemin);
            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {
                    if (method_exists($element, 'getText')) {
                        $texte = trim($element->getText());
                        if ($texte !== '') {
                            // On retourne la première ligne comme titre
                            $lignes = preg_split('/\r\n|\r|\n/', $texte);
                            return $lignes[0];
                        }
                    }
                }
            }
        } elseif ($extension === 'pdf') {
            $parser = new Parser();
            $pdf = $parser->parseFile($chemin);
            $texte = trim($pdf->getText());
            if ($texte !== '') {
                $lignes = preg_split('/\r\n|\r|\n/', $texte);
                return $lignes[0]; // Première ligne comme titre
            }
        } else {
            // Pour txt, ou autres, première ligne aussi
            $texte = file_get_contents($chemin);
            if ($texte !== false) {
                $texte = trim($texte);
                $lignes = preg_split('/\r\n|\r|\n/', $texte);
                return $lignes[0];
            }
        }
    } catch (\Exception $e) {
        Log::error("Erreur extraction titre: " . $e->getMessage());
    }
    return 'Titre indisponible';
}


    private function detecterTypeEtMatiereAvecIA(string $texte): array
    {
        $types = Type::pluck('nom')->map(fn($t) => strtolower(trim($t)))->toArray();
        $matieres = Matiere::pluck('nom')->map(fn($m) => strtolower(trim($m)))->toArray();

        $texte = strip_tags($texte);
        $texte = html_entity_decode($texte);
        $texte = mb_convert_encoding($texte, 'UTF-8', 'UTF-8');
        $texte = preg_replace('/[^\PC\s]/u', '', $texte);
        $texte = preg_replace('/\s+/', ' ', $texte);
        $texte = substr($texte, 0, 1000);

        $prompt = "Voici un document éducatif. Donne uniquement les informations suivantes :\n";
        $prompt .= "type: " . implode(' | ', $types) . "\n";
        $prompt .= "matière: " . implode(' | ', $matieres) . "\n\n";
        $prompt .= "Document :\n---\n$texte\n---";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('HF_API_TOKEN'),
                'Content-Type' => 'application/json',
            ])->timeout(60)->post('https://api-inference.huggingface.co/models/facebook/bart-large-mnli', [
                'inputs' => $prompt,
            ]);

            $result = $response->json();

            if (isset($result['error'])) {
                Log::error('Erreur IA HuggingFace: ' . $result['error']);
                return ['type' => 'inconnu', 'matiere' => 'inconnu'];
            }

            $content = $result['generated_text'] ?? $result[0]['generated_text'] ?? '';

            preg_match('/type\s*:\s*([^\n]+)/i', $content, $matchType);
            preg_match('/mati[eè]re\s*:\s*([^\n]+)/i', $content, $matchMatiere);

            $type = strtolower(trim($matchType[1] ?? 'inconnu'));
            $matiere = strtolower(trim($matchMatiere[1] ?? 'inconnu'));

            return [
                'type' => in_array($type, $types) ? $type : 'inconnu',
                'matiere' => in_array($matiere, $matieres) ? $matiere : 'inconnu',
            ];
        } catch (\Exception $e) {
            Log::error("Erreur IA : " . $e->getMessage());
            return ['type' => 'inconnu', 'matiere' => 'inconnu'];
        }
    }

    private function trouverIdType(string $nom): ?int
    {
        return Type::get()->first(function ($type) use ($nom) {
            return strtolower(trim($type->nom)) === strtolower(trim($nom));
        })?->id_type;
    }

    private function trouverIdMatiere(string $nom): ?int
    {
        return Matiere::get()->first(function ($matiere) use ($nom) {
            return strtolower(trim($matiere->nom)) === strtolower(trim($nom));
        })?->id_Matiere;
    }
} 