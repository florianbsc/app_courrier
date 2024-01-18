<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function showService()
    {
        $services = Service::all();

        return view('services.listeServices',[
            'services' => $services
        ]);
    }

    public function showCreateService ()
    {
        $services = Service::all();

        return view('services.createService',[
            'services' => $services,
        ]);
    }

    public function createService(Request $request)
    {
        // Validation des données
        $request->validate([
            'nom_service' => 'required|string|max:255',
            'telephone_service' => 'required|string|max:20',
        ]);

        // Création du service
        Service::create([
            'nom_service' => $request->nom_service,
            'telephone_service' => $request->telephone_service, 
        ]);

        // Redirection vers la liste des services
        return redirect()->route('liste_services');
}


}
