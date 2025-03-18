<?php

// app/Http/Controllers/EtudiantHomeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EtudiantHomeController extends Controller
{
    public function index()
    {
        // Récupérer l'utilisateur connecté (étudiant)
        $user = auth()->user();
        
        // Retourner la vue 'etudiant.home' avec les données de l'étudiant
        return view('EtudiantHome', compact('user'));
    }
}
