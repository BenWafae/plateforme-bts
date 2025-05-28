<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportEducatif;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        $supports = SupportEducatif::query()
            ->where('titre', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('search', compact('supports', 'query'));
    }
}
