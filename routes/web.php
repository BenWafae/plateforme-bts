<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminSupportController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\MessageController; // Ajoutez le contrôleur MessageController
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will be
| assigned to the "web" middleware group. Make something great!
|
*/

// Route d'accueil
Route::get('/', [App\Http\Controllers\AccueilController::class, 'index']);

// Route vers le tableau de bord
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes pour l'édition du profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

// Routes pour l'étudiant
Route::middleware(['auth', 'etudiant.auth'])->get('/etudiant/dashboard', [EtudiantController::class, 'dashboard'])->name('etudiant.dashboard');
   Route::prefix('etudiant')->group(function(){
    // route etudiant supprot:
    Route::get('/supports/{id}/ouvrir', [SupportController::class, 'showPdf'])->name('etudiant.supports.showPdf');
    Route::get('/supports/{id}/download', [SupportController::class, 'download'])->name('etudiant.supports.download');
 // Routes pour les MESSAGES
Route::middleware(['auth'])->get('/messages', [MessageController::class, 'showMessages'])->name('messages.index');
Route::middleware(['auth'])->post('/questions', [MessageController::class, 'storeQuestion'])->name('questions.store');
Route::put('/messages/{id}', [MessageController::class, 'update'])->name('questions.update');
Route::delete('/messages/{id}', [MessageController::class, 'destroy'])->name('questions.destroy');
Route::post('/messages/{id}/reponse', [MessageController::class, 'storeReponse'])->name('reponse.store');
Route::delete('/messages/reponse/{id}', [MessageController::class, 'destroyReponse'])->name('reponse.destroy');
   });
// Routes pour l'administrateur
Route::middleware(['auth', 'admin.auth'])->get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// Routes pour l'ajout des filières par l'admin
Route::prefix('admin')->group(function () {
    Route::get('/filieres', [FiliereController::class, 'index'])->name('filiere.index');
    Route::get('/filiere/create', [FiliereController::class, 'create'])->name('filiere.form');
    Route::post('/filiere', [FiliereController::class, 'store'])->name('filiere.store');
    Route::get('/filiere/{filiere}/edit', [FiliereController::class, 'edit'])->name('filiere.edit');
    Route::put('/filiere/{filiere}', [FiliereController::class, 'update'])->name('filiere.update');
    Route::delete('/filiere/{filiere}', [FiliereController::class, 'destroy'])->name('filiere.destroy');
    
    // Gestion des matières
    Route::get('/matieres', [MatiereController::class, 'index'])->name('matiere.index');
    Route::get('/matiere/create', [MatiereController::class, 'create'])->name('matiere.form');
    Route::post('/matiere', [MatiereController::class, 'store'])->name('matiere.store');
    Route::get('/matiere/{matiere}/edit', [MatiereController::class, 'edit'])->name('matiere.edit');
    Route::put('/matiere/{matiere}', [MatiereController::class, 'update'])->name('matiere.update');
    Route::delete('/matiere/{matiere}', [MatiereController::class, 'destroy'])->name('matiere.destroy');
    
    // Gestion des utilisateurs
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.form');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
});

// Routes pour les supports éducatifs par l'administrateur
Route::get('/supports', [AdminSupportController::class, 'index'])->name('admin.supports.index');
Route::get('/support/create', [AdminSupportController::class, 'create'])->name('admin.support.create');
Route::post('/support', [AdminSupportController::class, 'store'])->name('admin.support.store');
Route::get('/support/{id}/edit', [AdminSupportController::class, 'edit'])->name('admin.support.edit');
Route::put('/support/{id}', [AdminSupportController::class, 'update'])->name('admin.support.update');
Route::delete('/support/{id}', [AdminSupportController::class, 'destroy'])->name('admin.support.destroy');
Route::get('/support/{id}/show', [AdminSupportController::class, 'showPdf'])->name('admin.support.showPdf');


// Routes pour les professeurs
Route::middleware(['auth', 'professeur.auth'])->get('/professeur/dashboard' ,[ProfesseurController::class,'dashboard'])->name('professeur.dashboard');
Route::prefix('professeur')->group(function () {
    Route::get('/supports', [SupportController::class, 'index'])->name('supports.index');
    Route::get('/supports/create', [SupportController::class, 'create'])->name('supports.create');
    Route::get('/support/{id}/ouvrir', [SupportController::class, 'showPdf'])->name('support.showPdf');
    Route::post('/supports', [SupportController::class, 'store'])->name('supports.store');
    Route::delete('/supports/{id}', [SupportController::class, 'destroy'])->name('supports.destroy');
    Route::get('/supports/{id}/edit', [SupportController::class, 'edit'])->name('supports.edit');
    Route::put('/supports/{id}', [SupportController::class, 'update'])->name('supports.update');

    

});


require __DIR__.'/auth.php';

    
    















