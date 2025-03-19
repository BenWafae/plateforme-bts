<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminforumController;
use App\Http\Controllers\AdminSupportController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\forumetudiantsController;
use App\Http\Controllers\EtudiantHomeController;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ForumEtudiantsController as ControllersForumEtudiantsController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\TableauDeBordController;
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
 /// Routes pour le forum
Route::middleware(['auth'])->get('/etudiant/forumetudiants', [ForumEtudiantsController::class, 'showForum'])->name('forumetudiants.index');
Route::middleware(['auth'])->get('/etudiant/forumetudiants/questions/create', [ForumEtudiantsController::class, 'create'])->name('questions.create');
Route::middleware(['auth'])->post('/etudiant/forumetudiants/questions', [ForumEtudiantsController::class, 'storeQuestion'])->name('questions.store');
Route::middleware(['auth'])->delete('/etudiant/forumetudiants/{id}', [ForumEtudiantsController::class, 'destroyQuestion'])->name('questions.destroy');
Route::middleware(['auth'])->post('/etudiant/forumetudiants/{id}/reponse', [ForumEtudiantsController::class, 'storeReponse'])->name('reponse.store');
Route::middleware(['auth'])->delete('/etudiant/forumetudiants/reponse/{id}', [ForumEtudiantsController::class, 'destroyReponse'])->name('reponse.destroy');
Route::middleware(['auth'])->get('/etudiant/forumetudiants/questions/create', [ForumEtudiantsController::class, 'create'])->name('questions.create');
// Route pour afficher les notifications
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications/lire/{id}', [NotificationController::class, 'marquerCommeLue'])->name('notifications.lire');
Route::post('/notifications/lire-toutes', [NotificationController::class, 'marquerToutesCommeLues'])->name('notifications.lire.toutes');
Route::get('/etudiant/home', [EtudiantHomeController::class, 'index'])->name('etudiant.home');
Route::get('/notifications/count', [NotificationController::class, 'count'])->name('notifications.count');
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
// routes forumeAdmin;
Route::get('/admin/questions', [AdminforumController::class, 'index'])->name('admin.questions.index');
Route::get('/admin/questions/{id}', [AdminforumController::class, 'show'])->name('admin.questions.show');
// Cette route utilise la méthode destroy dans le contrôleur pour supprimer une question et ses réponses
Route::delete('/admin/questions/{id}', [AdminforumController::class, 'destroy'])->name('admin.questions.destroy');
// route tableau de bord
Route::middleware(['auth', 'admin.auth'])->get('/admin/tableau-de-bord', [TableauDeBordController::class, 'index'])->name('admin.tableau-de-bord');

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

    // routes question&reponses
    Route::get('/professeur/questions', [ForumController::class, 'index'])->name('professeur.questions.index');

    Route::post('/professeur/questions/{id}/repondre', [ForumController::class, 'repondre'])->name('professeur.questions.repondre');
    // Route pour mettre à jour une réponse
Route::put('/professeur/reponse/{id}', [ForumController::class, 'updateReponse'])->name('professeur.reponse.update');

// Route pour supprimer une réponse
Route::delete('/professeur/reponse/{id}', [ForumController::class, 'destroyReponse'])->name('professeur.reponse.destroy');
// Route pour afficher le formulaire d'édition de la réponse
Route::get('/professeur/reponse/{id}/edit', [ForumController::class, 'editReponse'])->name('professeur.reponse.edit');




});




require __DIR__ . '/auth.php';

    
    















