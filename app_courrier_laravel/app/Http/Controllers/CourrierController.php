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

use function Laravel\Prompts\select;

// back end de l'app


class CourrierController extends Controller
{
    
    public function showCourrier()
    {
        // // requete pour recuperer le courrier avec le nom du centre, le nom du service et le full_name de l'users
        // // assigne les valeurs de la table `courrier` a la variable $courriers

        // $courriers = DB::table('courriers')
        // // select de 4 tables, de 4 attributs donc troi jointures
        // ->select('courriers.*', 'centres.nom_centre', 'services.nom_service', 'users.nom_user', 'users.prenom_user')
        // // jointure entre id 
        // ->leftJoin('centres', 'courriers.id_centre', '=', 'centres.id_centre')
        // ->leftJoin('services', 'courriers.id_service', '=', 'services.id_service')
        // ->leftJoin('users', 'courriers.id_user', '=', 'users.id_user')
        // ->get();
        // $centres = DB::table('centres')->get();
        // $users = DB::table('users')->get();
        // $services= Db::table('services')->get();


        // return view('courrier', [
            
        //     'courriers' => $courriers,
        //     'centres' => $centres,
        //     'users' => $users,
        //     'services' => $services,
        // ]);

        // MODELE ELOQUENT
        // requete pour recuperer le courrier avec le nom du centre, le nom du service et le full_name de l'users
        // assigne les valeurs de la table `courrier` a la variable $courriers
        $courriers = Courrier::select('courriers.*', 'centres.nom_centre', 'services.nom_service', 'users.nom_user', 'users.prenom_user')
            ->leftJoin('centres', 'courriers.id_centre', '=', 'centres.id_centre')
            ->leftJoin('services', 'courriers.id_service', '=', 'services.id_service')
            ->leftJoin('users', 'courriers.id_user', '=', 'users.id_user')
            ->get();

        $centres = Centre::all();
        $users = User::all();
        $services = Service::all();

        return view('courrier', [
            'courriers' => $courriers,
            'centres' => $centres,
            'users' => $users,
            'services' => $services,
        ]);
        
    }

    public function createCourrier(){
        // $date_maintenant = (new DateTime())->format('Y-m-d');
        $date_maintenant = now()->toDateString();

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