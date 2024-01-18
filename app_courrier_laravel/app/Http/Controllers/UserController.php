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
        $newUser = new User();
        $newUser->nom_user = request()->nom_user;
        $newUser->prenom_user = request()->prenom_user;
        $newUser->mail_user = request()->mail_user;
        $newUser->mdp_user = bcrypt(request()->mdp_user); // Assurez-vous de hasher le mot de passe
        $newUser->save();
    
        return redirect()->route('liste_users');
    }
}
