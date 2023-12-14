<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;

use function Laravel\Prompts\select;

// back end de l'app


class CourrierController extends Controller
{
    
    public function showCourrier()
    {
        // requete pour recuperer le courrier avec le nom du centre, le nom du service et le full_name de l'users
        // assigne les valeurs de la table `courrier` a la variable $courriers

        $courriers = DB::table('courrier')
        // select de 4 tables, de 4 attributs donc troi jointures
        ->select('courrier.*', 'centre.nom_centre', 'service.nom_service', 'users.nom_user', 'users.prenom_user')
        // jointure entre id 
        ->leftJoin('centre', 'courrier.id_centre', '=', 'centre.id_centre')
        ->leftJoin('service', 'courrier.id_service', '=', 'service.id_service')
        ->leftJoin('users', 'courrier.id_user', '=', 'users.id_user')
        ->get();
        $centres = DB::table('centre')->get();
        $users = DB::table('users')->get();
        $services= Db::table('service')->get();


        return view('courrier', [
            
            'courriers' => $courriers,
            'centres' => $centres,
            'users' => $users,
            'services' => $services,
        ]);
    }

    public function createCourrier(){
        $date_maintenant = (new DateTime())->format('Y-m-d');

        DB::table('courrier')->insert([
//            request()-> ou $_POST pour recup les valeur du form
//
            // 'courrier.id_courrier' => request()->id_courrier,
            'courrier.date_courrier' => $date_maintenant,
            'courrier.objet_courrier' => request()->objet_courrier,
            'courrier.destinataire_courrier' => request()->destinataire_courrier,
            'courrier.description_courrier' => request()->description_courrier,
            'courrier.id_centre' => request()->id_centre,
            'courrier.id_user' => request()->id_user,
        ]);
        dd('courrier');
    }

}