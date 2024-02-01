<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Support\Facades\Validator;
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
        $rules = [
            'nom_service' => 'required|string|max:255',
            'telephone_service' => 'required|string|min:10|max:14',
        ];

        $messages = [
            'required' => 'Le champ :attribute est requis.',
            'min' => 'Le champ :attribute doit avoir au moins :min caratères.',
            'max' => 'Le champ :attribute ne doit pas dépasser les :max caratères.'
        ];


        // Validation des données
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect()->route('creation_service')
            ->withErrors($validator)
            ->withInput();
        }


        // Création du service
        Service::create([
            'nom_service' => $request->nom_service,
            'telephone_service' => $request->telephone_service, 
        ]);

        // Redirection vers la liste des services
        return redirect()->route('liste_services');
    }



    public function showEditService ($id_service)
    {
        $service = Service::find($id_service);

        return view('services.editService',[
            'service' => $service,
        ]);
    }

    public function updateService (Request $request, $id_service)
    {
        $service = Service::find($id_service);

        $rules = [
            'nom_service' => 'required|string|max:255',
            'telephone_service' => 'required|string|min:10|max:14',
        ];

        $messages = [
            'required' => 'Le champ :attribute est requis.',
            'min' => 'Le champ :attribute doit avoir au moins :min caratères.',
            'max' => 'Le champ :attribute ne doit pas dépasser les :max caratères.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

    // Vérifier si la validation a échoué
    if ($validator->fails()) {

        return redirect()->route('edit_service', ['id_service' => $service->id_service])
            ->withErrors($validator)
            ->withInput();
    }
        $service->update($request->all());

        return redirect()->route('liste_services');
    }
  

    public function deleteService ($id_service)
    {
// il semlerait que l'id ne soit pas pris
        $service = Service::find($id_service);


        // if($service) {

            $service->delete();

            return redirect()->route('liste_services');

        // } else {

        //     return redirect()->route('liste_services');
        // }
        
    }
}
