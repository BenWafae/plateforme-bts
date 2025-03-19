<?php 
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SupportEducatif;
use Illuminate\Http\Request;

class TableauDeBordController extends Controller
{
    public function index()
    {
        $studentsCount = User::where('role', 'etudiant')->count();
        $professorsCount = User::where('role', 'professeur')->count();
        $supportsCount = SupportEducatif::count();

        return view('TableauDeBord', compact('studentsCount', 'professorsCount', 'supportsCount'));
    }
}
