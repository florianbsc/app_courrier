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
            $newCentre = new Centre();
            $newCentre->nom_centre = request()->nom_centre;
            $newCentre->adresse_centre = request()->adresse_centre;
            $newCentre->CP_centre = request()->CP_centre;
            $newCentre->telephone_centre = request()->telephone_centre;
            $newCentre->save();
        
            return redirect()->route('liste_centres');
        
    }
}
