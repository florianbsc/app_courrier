<?php

namespace App\Http\Controllers;

use App\Models\Centre;
use Illuminate\Http\Request;

class CentreController extends Controller
{
    public function showCentre ()
    {
        $AllCentres = Centres::all();
        dd($AllCentres);

        return view('centre.listeCentre',[
            'centres' => $AllCentres,
        ]);
    }
}
