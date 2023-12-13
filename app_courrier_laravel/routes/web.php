<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\CourrierController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('create');
});

Route::get('/all',[CourrierController::class, 'index']);
Route::get('/courrier',[CourrierController::class, 'read']);
Route::post('/create',[CourrierController::class, 'createCourrier'])->name('creation_de_courrier');