<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\CourrierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CentreController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('courriers.createCourrier');
    // return view('welcome');
});



Route::prefix('users')->group(function()
{
    Route::get('/liste',[UserController::class,'showUser'])->name('liste_users');
    Route::get('/create',[UserController::class,'createUser'])->name('creation_user');

});

Route::prefix('courriers')->group(function()
{
    Route::get('/',[CourrierController::class, 'showCourrier']);
    Route::post('/create',[CourrierController::class, 'createCourrier'])->name('creation_de_courrier');
});

Route::prefix('centres')->group(function()
{

});
Route::prefix('services')->group(function()
{

});