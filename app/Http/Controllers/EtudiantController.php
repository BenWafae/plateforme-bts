<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    // Méthode pour afficher le tableau de bord de l'étudiant
    public function dashboard()
{
    $message = "Bienvenue sur votre espace étudiant !"; // Définir la variable

    return view('etudiant_dashboard', compact('message'));
}
}