<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// importe les models
use App\Models\Courrier;
use App\Models\Centre;
use App\Models\Service;
use App\Models\User;
use App\Models\AffecterUser;

class AffecterUserController extends Controller
{
    //

    public function showAffecterUser()
        {
            $affecterUsers = AffecterUser::select('affecters.*', 'users.nom_user', 'users.prenom_user', 'services.nom_service')
            ->join('users', 'affecters.id_user', '=','users.id_user')
            ->join('services', 'affecter.id_service', '=', 'service.id_service')
            ->orderBy('users.nom_user', 'asc')->get();

             // Retourner la vue avec les données
            return view('users.affecterUser.listeAffecter', [
                'affecterUsers' => $affecterUsers,
            ]);
        }
}
