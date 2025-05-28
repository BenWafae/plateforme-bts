<?php


namespace App\Http\Controllers;

use App\Models\SupportEducatif;
use Illuminate\Http\Request;

class RechercheSupportController extends Controller
{
    /**
     * Recherche les supports éducatifs selon un terme de recherche.
     */
    public function rechercher(Request $request)
    {
        $search = $request->input('search');

        // Si la recherche est vide, rediriger ou afficher tous les supports (au choix)
        if (!$search) {
            // Ici on retourne tous les supports paginés, ou tu peux rediriger
            $supports = SupportEducatif::orderBy('created_at', 'desc')->paginate(16);
        } else {
            // Recherche par titre ou description
            $supports = SupportEducatif::where('titre', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%")
                ->orderBy('created_at', 'desc')
                ->paginate(16);
        }

        // Retourner une vue dédiée ou la même vue avec résultats
        return view('supports_recherche', compact('supports', 'search'));
    }
}
