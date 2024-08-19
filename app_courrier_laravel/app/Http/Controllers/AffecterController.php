<?php
// Cette fonction récupère et affiche la liste des affectations des utilisateurs à des services,
// en triant les utilisateurs par nom et en incluant les noms des utilisateurs et des services associés.
namespace App\Http\Controllers;

use App\Models\Affecter;

class AffecterController extends Controller
{
    // Affiche la liste des affectations d'utilisateurs à des services
    public function showAffecterUser()
    {
        // Récupère les affectations avec les noms des utilisateurs et des services associés
        $affecterUsers = Affecter::select('affecters.*', 'users.nom_user', 'users.prenom_user', 'services.nom_service')
            ->join('users', 'affecters.id_user', '=', 'users.id_user')
            ->join('services', 'affecters.id_service', '=', 'services.id_service')
            ->orderBy('users.nom_user', 'asc') // Trie les utilisateurs par nom
            ->get();

        // Retourne la vue avec la liste des affectations
        return view('users.listeAffecter', [
            'affecterUsers' => $affecterUsers,
        ]);
    }
}
