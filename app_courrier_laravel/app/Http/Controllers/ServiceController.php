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
    public function createService()
    {
        Service::create([
            'nom_service' => request()->nom_service,
            'telephone_service' => request()->telephone_service, 
        ]);
     
        return redirect()->route('liste_services');
    }

}
