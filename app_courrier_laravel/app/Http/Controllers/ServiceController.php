<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // Affiche la liste des services
    public function showService()
    {
        // Récupère tous les services
        $services = Service::all();

        // Retourne la vue avec la liste des services
        return view('services.listeServices', [
            'services' => $services
        ]);
    }

    // Affiche le formulaire de création d'un service
    public function showCreateService()
    {
        // Récupère tous les services
        $services = Service::all();

        // Retourne la vue pour créer un nouveau service
        return view('services.createService', [
            'services' => $services,
        ]);
    }

    // Crée un nouveau service
    public function createService(Request $request)
    {
        // Définir les règles de validation
        $rules = [
            'nom_service' => 'required|string|max:255',
            'telephone_service' => 'nullable|string|max:14',
        ];

        // Définir les messages d'erreur
        $messages = [
            'required' => 'Le champ :attribute est requis.',
            'min' => 'Le champ :attribute doit avoir au moins :min caractères.',
            'max' => 'Le champ :attribute ne doit pas dépasser les :max caractères.'
        ];

        // Valider les données
        $validator = Validator::make($request->all(), $rules, $messages);

        // Si la validation échoue, rediriger avec les erreurs
        if ($validator->fails()) {
            return redirect()->route('creation_service')
                ->withErrors($validator)
                ->withInput();
        }

        // Créer un nouveau service
        Service::create([
            'nom_service' => $request->nom_service,
            'telephone_service' => $request->telephone_service,
        ]);

        // Rediriger vers la liste des services
        return redirect()->route('liste_services')->with('success','Le servie à été ajouté');
    }

    // Affiche le formulaire d'édition d'un service
    public function showEditService($id_service)
    {
        // Récupérer le service à éditer en fonction de l'id
        $service = Service::find($id_service);

        // Retourne la vue pour éditer le service
        return view('services.editService', [
            'service' => $service,
        ]);
    }

    // Met à jour un service existant
    public function updateService(Request $request, $id_service)
    {
        // Récupérer le service à mettre à jour
        $service = Service::find($id_service);

        // Définir les règles de validation
        $rules = [
            'nom_service' => 'required|string|max:255',
            'telephone_service' => 'nullable|string|max:14',
        ];

        // Définir les messages d'erreur
        $messages = [
            'required' => 'Le champ :attribute est requis.',
            'min' => 'Le champ :attribute doit avoir au moins :min caractères.',
            'max' => 'Le champ :attribute ne doit pas dépasser les :max caractères.'
        ];

        // Valider les données
        $validator = Validator::make($request->all(), $rules, $messages);

        // Si la validation échoue, rediriger avec les erreurs
        if ($validator->fails()) {
            return redirect()->route('edit_service', ['id_service' => $service->id_service])
                ->withErrors($validator)
                ->withInput();
        }

        // Mettre à jour le service avec les nouvelles données
        $service->update($request->all());

        // Rediriger vers la liste des services
        return redirect()->route('liste_services')->with('success','le service à bien été mis à jour');
    }

    // Supprime un service existant
    public function deleteService($id_service)
    {
        // Récupérer le service à supprimer en fonction de l'id
        $service = Service::find($id_service);

        // Vérifier si le service existe
        if ($service) {
            // Supprimer le service
            $service->delete();
        }

        // Rediriger vers la liste des services (on pourrait ajouter un message de succès ici)
        return redirect()->route('liste_services')->with('success','Le service à bien été suprimé');
    }

    
}
