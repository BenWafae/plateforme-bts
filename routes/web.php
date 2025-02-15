<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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
    // routes pour l'ajout des filieres par l'admins:
    Route::prefix('admin')->group(function () {
        Route::get('/filieres', [FiliereController::class, 'index'])->name('filiere.index');
        Route::get('/filiere/create', [FiliereController::class, 'create'])->name('filiere.form');
        Route::post('/filiere', [FiliereController::class, 'store'])->name('filiere.store');
        Route::get('/filiere/{filiere}/edit', [FiliereController::class, 'edit'])->name('filiere.edit');
        Route::put('/filiere/{filiere}', [FiliereController::class, 'update'])->name('filiere.update');
        Route::delete('/filiere/{filiere}', [FiliereController::class, 'destroy'])->name('filiere.destroy');

       // Le {filiere} est un paramètre dynamique de l'URL, qui sert à capturer une valeur spécifique dans l'URL pour l'utiliser dans le contrôleur
        // dans notre cas fait reference au id de filiee qu'on veut la supprimer
        // maintennat gestion ds matieres:route matieres:
        Route::get('/matieres', [MatiereController::class, 'index'])->name('matiere.index');
        Route::get('/matiere/create', [MatiereController::class, 'create'])->name('matiere.form');
        Route::post('/matiere', [MatiereController::class, 'store'])->name('matiere.store');
        Route::get('/matiere/{matiere}/edit', [MatiereController::class, 'edit'])->name('matiere.edit');
        Route::put('/matiere/{matiere}', [MatiereController::class, 'update'])->name('matiere.update');
        Route::delete('/matiere/{matiere}', [MatiereController::class, 'destroy'])->name('matiere.destroy');
        Route::get('/matiere/search', [MatiereController::class, 'search'])->name('matiere.search');

       

        // route pour Users;
         
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.form');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    // 1..index:affichee la liste des users
    // 2.create:afficher le formulaire d'ajout;
    // 3.store:enregistrerrr un nouveau userss;
    // 4.edit..
});

    
    
    // creation de route pour administrateur:/admin/dashboard
    Route::middleware(['auth', 'professeur.auth'])->get('/professeur/dashboard' ,[ProfesseurController::class,'dashboard'])->name('professeur.dashboard');











require __DIR__.'/auth.php';
