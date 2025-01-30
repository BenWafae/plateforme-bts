<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminAuthenticated;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [App\Http\Controllers\AccueilController::class, 'index']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
   Route::middleware(['auth', 'etudiant.auth'])->get('/etudiant/dashboard', [EtudiantController::class, 'dashboard'])->name('etudiant.dashboard');
    // l'etudiant sera rediriger ver la page etudiant-dashboard:/admin/dashboard ,

    Route::middleware(['auth', 'admin.auth'])->get('/admin/dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');
    // creation de route pour administrateur:/admin/dashboard
    Route::middleware(['auth', 'professeur.auth'])->get('/professeur/dashboard' ,[ProfesseurController::class,'dashboard'])->name('professeur.dashboard');











require __DIR__.'/auth.php';
