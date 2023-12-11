<?php

use App\Http\Controllers\CourrierController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('courrier');
});

Route::get('/courrier',[CourrierController::class, 'index']);
