<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showUser()
    {
      $users =  User::all();

      return view('users.listeUsers',[
          'users' => $users,
      ]);
    }

    public function showCreateUser()
    {
      $users =  User::all();

      return view('users.createUser',[
          'users' => $users,
      ]);
    }

    public function createUser(Request $request)
{
    // Validation des données
    $request->validate([
        'nom_user' => 'required|string|max:255',
        'prenom_user' => 'required|string|max:255',
        'mail_user' => 'required|email|unique:users|max:255',
        'mdp_user' => 'required|string|min:8',
    ]);

    // Création de l'utilisateur
    User::create([
        'nom_user' => $request->nom_user,
        'prenom_user' => $request->prenom_user,
        'mail_user' => $request->mail_user,
        'password' => bcrypt($request->mdp_user),
    ]);

    // Redirection vers la liste des utilisateurs
    return redirect()->route('liste_users');
}

}
