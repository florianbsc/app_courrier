<?php

namespace App\Http\Controllers;
use App\Models\Affecter;


use Illuminate\Http\Request;

class AffecterController extends Controller
{

    public function showAffecterUser()
        {
            $affecterUsers = Affecter::select('affecters.*', 'users.nom_user', 'users.prenom_user', 'services.nom_service')
            ->join('users', 'affecters.id_user', '=','users.id_user')
            ->join('services', 'affecters.id_service', '=', 'services.id_service')
            ->orderBy('users.nom_user', 'asc')->get();

             // Retourner la vue avec les données
            return view('users.listeAffecter', [
                'affecterUsers' => $affecterUsers,
            ]);
        }
}
