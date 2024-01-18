<?php

namespace App\Http\Controllers;

use App\Models\Centre;
use Illuminate\Http\Request;


class CentreController extends Controller
{
    public function showCentre ()
    {
        $centres = Centre::all();

        return view('centres.listeCentres',[
            'centres' => $centres,
        ]);
    }

    public function showCreateCentre ()
    {
        $centres = Centre::all();
        // dd($centres);

        return view('centres.createCentre',[
            'centres' => $centres,
        ]);
    }

    public function createCentre()
    {
            Centre::create([
                'nom_centre' => request()->nom_centre,
                'adresse_centre' => request()->adresse_centre,
                'CP_centre' => request()->CP_centre,
                'telephone_centre' => request()->telephone_centre,
            ]);
            
        
            return redirect()->route('liste_centres');
        
    }
}
