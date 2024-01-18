<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;
// importe les models
use App\Models\Courrier;
use App\Models\Centre;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;

use function Laravel\Prompts\select;
use Illuminate\Support\Facades\Validator; 

// back end de l'app


class CourrierController extends Controller
{
    
    public function showCourrier()
    {

        // requete pour recuperer le courrier avec le nom du centre, le nom du service et le full_name de l'users
        // assigne les valeurs de la table `courrier` a la variable $courriers
        // MODELE ELOQUENT
    
        $courriers = Courrier::select('courriers.*', 'centres.nom_centre', 'services.nom_service', 'users.nom_user', 'users.prenom_user')
            ->leftJoin('centres', 'courriers.id_centre', '=', 'centres.id_centre')
            ->leftJoin('services', 'courriers.id_service', '=', 'services.id_service')
            ->leftJoin('users', 'courriers.id_user', '=', 'users.id_user')
            ->get();

        $centres = Centre::all();
        $users = User::all();
        $services = Service::all();

        return view('courriers.courrier', [
            'courriers' => $courriers,
            'centres' => $centres,
            'users' => $users,
            'services' => $services,
        ]);
        
    }
    public function showCreateCourrier ()
    {
        $courriers = Courrier::select('courriers.*', 'centres.nom_centre', 'services.nom_service', 'users.nom_user', 'users.prenom_user')
            ->leftJoin('centres', 'courriers.id_centre', '=', 'centres.id_centre')
            ->leftJoin('services', 'courriers.id_service', '=', 'services.id_service')
            ->leftJoin('users', 'courriers.id_user', '=', 'users.id_user')
            ->get();

        $centres = Centre::all();
        $users = User::all();
        $services = Service::all();

        return view('courriers.createCourrier', [
            'courriers' => $courriers,
            'centres' => $centres,
            'users' => $users,
            'services' => $services,
        ]);
    }


public function createCourrier(Request $request)
{
    // // Validez les données du formulaire
    // $validator = Validator::make($request->all(), [
    //     'objet_courrier' => 'required',
    //     'destinataire_courrier' => 'required',
    //     'description_courrier' => 'required',
    //     'id_centre' => 'required',
    //     'id_user' => 'required',
    //     'id_service' => 'required',
    // ]);

    // // Si la validation échoue, redirigez avec les erreurs
    // if ($validator->fails()) {
    //     return redirect()->route('creation_courrier')
    //         ->withErrors($validator)
    //         ->withInput();
    // }

    // Si la validation réussit, insérez le nouveau courrier dans la base de données
    $date_maintenant = now()->toDateString();

    Courrier::create([
        'date_courrier' => $date_maintenant,
        'objet_courrier' => $request->objet_courrier,
        'destinataire_courrier' => $request->destinataire_courrier,
        'description_courrier' => $request->description_courrier,
        'id_centre' => $request->id_centre,
        // 'id_user' => $request->id_user,
        'id_user' => 2,
        'id_service' => $request->id_service,
    ]);
  

    // Redirigez vers la vue de création de courrier avec un message de succès
    return view('courriers.createCourrier')->with('success', 'Le courrier a été créé avec succès.');
}


}