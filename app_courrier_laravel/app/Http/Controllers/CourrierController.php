<?php

namespace App\Http\Controllers;

use App\Models\Courrier;
use Illuminate\Http\Request;
// back end de l'app
class CourrierController extends Controller
{
    public function index()
    {
        $books = Courrier::all();


        return view('courrier', [
            'courriers' => $courriers,
        ]);
    }
}
