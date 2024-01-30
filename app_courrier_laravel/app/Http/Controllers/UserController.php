<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

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
            'password' => 'required|string|min:8',
        ]);
if (   $request->validate    ){
        // Création de l'utilisateur
        User::create([
            'nom_user' => $request->nom_user,
            'prenom_user' => $request->prenom_user,
            'mail_user' => $request->mail_user,
            'password' => $request->password,
        ]);

        // Redirection vers la liste des utilisateurs
        return redirect()->route('liste_users');

    } else {
        
    }
    }

    public function showEditUser ($id_user)
    {
        $user = User::find($id_user);

        return view('users.editUser',[
            'user' => $user,
        ]);
    }

    public function updateUser (Request $request, $id_user)
    {
        $user = User::find($id_user);

        $user->nom_user = $request-> nom_user;
        $user->prenom_user = $request-> prenom_user;
        $user->mail_user = $request-> mail_user;
   
        $user->update($request->all());

        return redirect()->route('liste_users');
   
    }

    public function deleteUser($id_user)
    {
        $user = User::find($id_user);

        if($user) {

            $user->delete();

            return redirect()->route('liste_users');

        } else {

            return redirect()->route('liste_users');

        }

    }






     /*
     * PARTIE DE/CONNEXION
     */
    public function showLoginForm()
    {
        try {
            $users = User::all();

            return view('log.login', [
                'user' => $users,
            ]);
        } catch (\Exception $e) {
            // Gérez l'erreur de manière appropriée, par exemple, journalisez l'erreur ou renvoyez une page d'erreur
            return view('errors.custom_error', [
                'error_message' => "Une erreur s'est produite lors du chargement des employés.",
            ]);
        }
    }


    public function username()
    {
        return 'mail_user';
    }


    public function login(Request $request)
    {
        // $credentials = [
        //     'mail_user' => $request->mail_user,
        //     'password' => $request->password,
        // ];
        $credentials = request()->only('mail_user', 'password');

        $auth = Auth::attempt($credentials, true);
        if ($auth) { 
            Session::regenerate();
        $auth = Auth::user();
        if ($auth->privilege_user == 1 || $auth->privilege_user == 2 || $auth->privilege_user == 3) {
                return redirect()->route('accueil');
            }
            else{
                return redirect()->route('accueil');
            }         
        }
        else{
            return redirect()->route('login');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}

