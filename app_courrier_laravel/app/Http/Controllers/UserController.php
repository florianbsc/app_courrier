<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showUser()
    {
      $users =  User::all();
    //   dd($users);

    return view('users.listeUsers',[
        'users' => $users,
    ]);
    }

    public function createUser()
    {
        dd('vontrollerusre');
        $newUser = User::create([
            'nom_user' => request()->nom_user,
            'prenom_user' => request()->prenom_user,
            'mail_user' => request()->mail_user,
            'mdp_user' => bcrypt(request()->mdp_user), // Assurez-vous de hasher le mot de passe
        ]);
        return redirect()->route('liste_users'); 
    
    }
}
