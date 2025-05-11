<?php
// app/Http/Controllers/SearchController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // ou autre modèle à rechercher

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        // Exemple simple : recherche par nom
        $results = User::where('nom', 'like', '%' . $query . '%')->get();

        return view('searchresults', compact('results', 'query'));
    }
}
