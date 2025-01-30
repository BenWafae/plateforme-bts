<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfesseurController extends Controller
{
    public function dashboard()
    {
        return view('professeur_dashboard', ['message' => 'Bienvenue, Professeur !']);
    }
}
