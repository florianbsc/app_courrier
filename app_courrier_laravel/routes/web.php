<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\CourrierController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/courrier',[CourrierController::class, 'showCourrier']);
Route::post('/create',[CourrierController::class, 'createCourrier'])->name('creation_de_courrier');