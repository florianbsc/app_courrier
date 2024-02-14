<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\CourrierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CentreController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;



Route::get('/home', function () {
    return view('welcome');

//    renvoi vers la page app apres la connxion
})->middleware('auth')->name('accueil');


//// ---------------------------- CONNEXION

Route::middleware('guest')->group(function(){
    Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [UserController::class, 'login']);
});

Route::prefix('users')->middleware('auth')->group(function()
{
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/liste',[UserController::class,'showUser'])->name('liste_users');
    Route::get('/create',[UserController::class,'showCreateUser']);
    Route::post('/create',[UserController::class,'createUser'])->name('creation_user');
    Route::get('/edit/{id_user}', [UserController::class, 'showEditUser'])->name('edit_user');
    Route::put('/update/{id_user}', [UserController::class, 'updateUser'])->name('update_user');
    Route::get('/delete/{id_user}', [UserController::class, 'deleteUser'])->name('delete_user');
    Route::post('/search', [UserController::class, 'showSearchUser'])->name('liste_user_recherche');
});

Route::prefix('courriers')->middleware('auth')->group(function()
{
    Route::get('/liste',[CourrierController::class, 'showCourrier'])->name('liste_courriers');
    Route::get('/create',[CourrierController::class,'showCreateCourrier']);
    Route::post('/create',[CourrierController::class, 'createCourrier'])->name('creation_courrier');  
    Route::get('/edit/{id_courrier}', [CourrierController::class, 'showEditCourrier'])->name('edit_courrier');
    Route::put('/update/{id_courrier}', [CourrierController::class, 'updateCourrier'])->name('update_courrier');
    Route::get('/delete/{id_courrier}', [CourrierController::class, 'deleteCourrier'])->name('delete_courrier');
    Route::post('/search', [CourrierController::class, 'showSearchCourrier'])->name('liste_courrier_recherche');

});

Route::prefix('services')->middleware('auth')->group(function()
{
    Route::get('/liste',[ServiceController::class, 'showService'])->name('liste_services');
    Route::get('/create',[ServiceController::class, 'showCreateService']);
    Route::post('/create',[ServiceController::class, 'createService'])->name('creation_service');
    Route::get('/edit/{id_service}',[ServiceController::class, 'showEditService'])->name('edit_service');
    Route::put('/update/{id_service}', [ServiceController::class, 'updateService'])->name('update_service');
    Route::get('/delete/{id_service}', [ServiceController::class, 'deleteService'])->name('delete_service');
    
});

Route::prefix('centres')->middleware('auth')->group(function()
{
    Route::get('/liste',[CentreController::class, 'showCentre'])->name('liste_centres');
    Route::get('/create',[CentreController::class, 'showCreateCentre']);
    Route::post('/create',[CentreController::class, 'createCentre'])->name('creation_centre');
    Route::get('/edit/{id_centre}', [CentreController::class, 'showEditCentre'])->name('edit_centre');
    Route::put('/update/{id_centre}', [CentreController::class, 'updateCentre'])->name('update_centre');
    Route::get('/delete/{id_centre}', [CentreController::class, 'deleteCentre'])->name('delete_centre');

    
});
