<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;

// back end de l'app


class CourrierController extends Controller
{
    public function index()
    {
        $courriers = DB::table('courrier')->get();
// dd($courriers);

        return view('courrier', [
            'courriers' => $courriers,
        ]);
    }



    public function read()
    {
        // requete pour recuperer le courrier avec le nom du centre, le nom du service et le full_name de l'utilisateur
        // assigne les valeurs de la table `courrier` a la variable $courriers

        $courriers = DB::table('courrier')
        // select de 4 tables, de 4 attributs donc troi jointures
        ->select('courrier.*', 'centre.nom_centre', 'service.nom_service', 'utilisateur.nom_user', 'utilisateur.prenom_user')
        // jointure entre id 
        ->join('centre', 'courrier.id_centre', '=', 'centre.id_centre')
        ->join('service', 'courrier.id_service', '=', 'service.id_service')
        ->join('utilisateur', 'courrier.id_user', '=', 'utilisateur.id_user')
        ->get();

        $centres = DB::table('centre')->get();
        dd($centres);

        $users = DB::table('utilisateur')->get();
        $services= Db::table('service')->get();

        return view('visites.create', [
            'courriers' => $courriers,
            'centres' => $centres,
            'users' => $users,
            'services' => $services,
        ]);
    }

    public function createCourrier(){
        $date_maintenant = (new DateTime())->format('Y-m-d');

        DB::table('courrier')->insert([
            'courrier.id_courrier' => 1,
            'courrier.id_centre' => 1,
            'courrier.id_user' => 1,
            'courrier.date_courrier' => $date_maintenant
        ]);
        //dd('courrier');

//         DB::table('visiter')->insert([
// //            request()-> ou $_POST pour recup les valeur du form
// //
//             'identifiant_employe' => request()->id_employe,
//             'identifiant_professionnel_de_sante' => request()->id_prof_sante,
//             'identifiant_medicament' => request()->id_medicament ,
//             'derniere_visite' => $date_maintenant
//         ]);
    }

}