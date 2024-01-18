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

    public function createUser()
    {

      User::create([
        'nom_user' => request()->nom_user,
        'prenom_user' => request()->prenom_user,
        'mail_user' => request()->mail_user,
        'password' => bcrypt(request()->mdp_user), // Assurez-vous de hasher le mot de passe
      ]);
    
        return redirect()->route('liste_users');
    }
}
