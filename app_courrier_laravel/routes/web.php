<?php

use App\Http\Controllers\AffecterController;
use App\Http\Controllers\CourrierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CentreController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

// Routes pour la CONNEXION (accessible uniquement aux invités)
Route::middleware('guest')->group(function()
    {
        Route::get('/login', [UserController::class, 'showLoginForm'])->name('login'); // Affiche le formulaire de connexion
        Route::post('/login', [UserController::class, 'login']); // Traite la connexion
    });

// Route pour la page d'accueil, accessible uniquement après connexion
Route::get('/accueil', function () 
    {
    return view('welcome');
    // Renvoie vers la page d'accueil après connexion
})->middleware('auth')->name('accueil');



// Routes pour les utilisateurs
Route::prefix('users')->middleware('auth')->group(function() {
    
    // Route de déconnexion
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');

    // Routes nécessitant un privilège de niveau 3
    Route::middleware('privilege:3')->group(function() {
        Route::get('/liste',[UserController::class,'showUser'])->name('liste_users'); // Liste des utilisateurs
        Route::get('/create',[UserController::class,'showCreateUser']); // Formulaire de création d'utilisateur
        Route::post('/create',[UserController::class,'createUser'])->name('creation_user'); // Crée un utilisateur
        Route::get('/edit/{id_user}', [UserController::class, 'showEditUser'])->name('edit_user'); // Formulaire d'édition d'utilisateur
        Route::put('/update/{id_user}', [UserController::class, 'updateUser'])->name('update_user'); // Met à jour un utilisateur
        Route::get('/delete/{id_user}', [UserController::class, 'deleteUser'])->name('delete_user'); // Supprime un utilisateur
        Route::post('/search', [UserController::class, 'showSearchUser'])->name('liste_user_recherche'); // Recherche d'utilisateur
    });
});

// Routes pour les courriers
Route::prefix('courriers')->middleware('auth')->group(function()
    {
        Route::get('/liste',[CourrierController::class, 'showCourrier'])
            ->name('liste_courriers')
            ->middleware('privilege:1'); // Liste des courriers, accessible avec privilège de niveau 1

        // Routes nécessitant un privilège de niveau 2
        Route::middleware('privilege:2')->group(function() {
            Route::get('/create',[CourrierController::class,'showCreateCourrier']); // Formulaire de création
            Route::post('/create',[CourrierController::class, 'createCourrier'])->name('creation_courrier'); // Crée
            Route::get('/edit/{id_courrier}', [CourrierController::class, 'showEditCourrier'])->name('edit_courrier'); // Formulaire d'édition
            Route::put('/update/{id_courrier}', [CourrierController::class, 'updateCourrier'])->name('update_courrier'); // Met à jour un courrier
            Route::get('/delete/{id_courrier}', [CourrierController::class, 'deleteCourrier'])->name('delete_courrier'); // Supprime un courrier
            Route::post('/search', [CourrierController::class, 'showSearchCourrier'])->name('liste_courrier_recherche'); // Recherche de courrier
            Route::post('/depot/{id_courrier}', [CourrierController::class, 'depotScanCourrier'])->name('depot_scan_courrier'); // Dépose un scan
            Route::get('/download/{chemin}', [CourrierController::class, 'download'])->name('download_scan_courrier'); // Télécharge un scan
            Route::get('/delete/scan/{id_courrier}', [CourrierController::class, 'deleteScan'])->name('delete_scan_courrier'); // Supprime un scan
        });
    });

// Routes pour les services
Route::prefix('services')->middleware('auth')->group(function()
    {
        Route::get('/liste',[ServiceController::class, 'showService'])
            ->name('liste_services')
            ->middleware('privilege:1'); // Liste des services, accessible avec privilège de niveau 1

        // Routes nécessitant un privilège de niveau 3
        Route::middleware('privilege:3')->group(function() {
            Route::get('/create',[ServiceController::class, 'showCreateService']); // Formulaire de création
            Route::post('/create',[ServiceController::class, 'createService'])->name('creation_service'); // Crée
            Route::get('/edit/{id_service}',[ServiceController::class, 'showEditService'])->name('edit_service'); // Formulaire d'édition
            Route::put('/update/{id_service}', [ServiceController::class, 'updateService'])->name('update_service'); // Met à jour un service
            Route::get('/delete/{id_service}', [ServiceController::class, 'deleteService'])->name('delete_service'); // Supprime un service
            Route::post('/search', [ServiceController::class, 'searchService'])->name('liste_service_recherche'); // Recherche de service

        });
    });

// Routes pour les centres
Route::prefix('centres')->middleware('auth')->group(function () 
    {
        Route::get('/liste', [CentreController::class, 'showCentre'])
            ->name('liste_centres')
            ->middleware('privilege:2'); // Liste des centres, accessible avec privilège de niveau 2

        // Routes nécessitant un privilège de niveau 3
        Route::middleware('privilege:3')->group(function () {
            Route::get('/create', [CentreController::class, 'showCreateCentre']); // Formulaire de création
            Route::post('/create', [CentreController::class, 'createCentre'])->name('creation_centre'); // Crée
            Route::get('/edit/{id_centre}', [CentreController::class, 'showEditCentre'])->name('edit_centre'); // Formulaire d'édition
            Route::put('/update/{id_centre}', [CentreController::class, 'updateCentre'])->name('update_centre'); // Met à jour
            Route::get('/delete/{id_centre}', [CentreController::class, 'deleteCentre'])->name('delete_centre'); // Supprime
        });
    });

// Routes pour affecter des utilisateurs, accessibles uniquement après connexion et avec privilège de niveau 3
Route::prefix('AffecterUser')->middleware('auth', 'privilege:3')->group(function () 
    {
        Route::get('/liste', [AffecterController::class, 'showAffecterUser'])->name('liste_affecter'); // Liste des utilisateurs affectés
    });

// Route pour afficher une page d'erreur
Route::get('/erreur', function () 
    {
        return view('gestion.erreur'); // Renvoie vers une page d'erreur
    })->middleware('auth')->name('acces_refuse');

// Route pour une page de test
Route::get('/test', function ()
    {
        return view('gestion.test'); // Renvoie vers une page de test
    })->name('test');
