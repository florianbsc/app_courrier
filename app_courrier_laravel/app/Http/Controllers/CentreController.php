<?php

namespace App\Http\Controllers;

use App\Models\Centre;
use Illuminate\Http\Request;

class CentreController extends Controller
{
    public function showCentre ()
    {
        $centres = Centre::all();
        // dd($AllCentres);

        return view('centres.listeCentres',[
            'centres' => $centres,
        ]);
    }
    public function showCreateCentre ()
    {
        $centres = Centre::all();
        // dd($AllCentres);

        return view('centres.createCentre',[
            'centres' => $centres,
        ]);
    }
}
