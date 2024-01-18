<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\CourrierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CentreController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
})->name('accueil');



Route::prefix('users')->group(function()
{
    Route::get('/liste',[UserController::class,'showUser'])->name('liste_users');
    Route::get('/create',[UserController::class,'showCreateUser']);
    Route::post('/create',[UserController::class,'createUser'])->name('creation_user');

});

Route::prefix('courriers')->group(function()
{
    Route::get('/liste',[CourrierController::class, 'showCourrier'])->name('liste_courriers');
    Route::get('/create',[CourrierController::class,'showCreate']);
    Route::post('/create',[CourrierController::class, 'createCourrier'])->name('creation_courrier');
});

Route::prefix('services')->group(function()
{
    Route::get('/liste',[ServiceController::class, 'showService'])->name('liste_services');
    Route::get('/create',[ServiceController::class, 'showCreateService']);
    Route::post('/create',[ServiceController::class, 'createService'])->name('creation_service');
});

Route::prefix('centres')->group(function()
{
    Route::get('/liste',[CentreController::class, 'showCentre'])->name('liste_centres');
    Route::get('/create',[CentreController::class, 'showCreateCentre']);
    Route::post('/create',[CentreController::class, 'createCentre'])->name('creation_centre');
    
});
