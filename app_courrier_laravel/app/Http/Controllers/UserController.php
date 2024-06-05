<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Affecter;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function showUser()
        {
            $users = User::select('users.*', 'services.nom_service')
            ->leftJoin('affecters','users.id_user' , '=', 'affecters.id_user')
            ->leftJoin('services', 'services.id_service', '=','affecters.id_service', )
            ->orderBy('users.nom_user', 'asc')
            ->get();


            return view('users.listeUsers', [
                'users' => $users
            ]);
        }

    public function showCreateUser()
        {
            $users =  User::all();
            // $users = User::select('users.*', 'services.nom_service')
            // ->leftJoin('affecters','users.id_user' , '=', 'affecters.id_user')
            // ->leftJoin('services', 'services.id_service', '=','affecters.id_service', )
            // ->orderBy('users.nom_user', 'asc')
            // ->get();

            $services = Service::all();


            return view('users.createUser',[
                'users' => $users,
                'services' => $services,
            ]);

           
        }

    public function createUser(Request $request)
        {
            // Définir les règles de validation
            $rules = [
                'nom_user' => 'required|string',
                'prenom_user' => 'required|string',
                'mail_user' => 'required|email|unique:users',
                'password' => 'required|string|min:8',
                'privilege_user' => 'nullable|int',
                'service' => 'required|int',
                ];

            // Personnaliser les messages d'erreur
            $messages = [
                'required' => 'Le champ :attribute est requis.',
                'email' => 'Le champ :attribute doit être une adresse email valide.',
                'unique' => 'Le champ :attribute est déjà utilisée.',
                'min' => 'Le champ :attribute doit avoir au moins :min caractères.',
                'max' => 'Le champ :attribute ne doit pas avoir plus de :max caratères.',
                'int' => 'Le champ :attribue doit etre un chiffre.',
                ];

            // Valider les données
            $validator = Validator::make($request->all(), $rules, $messages);

            // Vérifier si la validation a échoué
            if ($validator->fails()) {

                return redirect()->route('creation_user')
                    ->withErrors($validator)
                    ->withInput();
            }

            // Création de l'utilisateur
            User::create([
                'nom_user' => $request->nom_user,
                'prenom_user' => $request->prenom_user,
                'mail_user' => $request->mail_user,
                'password' => bcrypt($request->password), // Assurez-vous de hasher le mot de passe
                'privilege_user' => $request->privilege_user,
            ]);

            // Redirection vers la liste des utilisateurs
            return redirect()->route('liste_users');
        }

    public function showEditUser ($id_user, $id_service)
        {
            $user = User::find($id_user);
            $sercices = Service::find($id_service);

               return view('users.editUser',[
                'user' => $user,
            ]);
        }

    public function updateUser (Request $request, $id_user)
        {
            $user = User::find($id_user);
            // $users = User::select('users.*', 'services.nom_service')
            // ->leftJoin('affecters','users.id_user' , '=', 'affecters.id_user')
            // ->leftJoin('services', 'services.id_service', '=','affecters.id_service', )
            // ->orderBy('users.nom_user', 'asc')
            // ->get();


            $rules = [
                'nom_user' => 'required|string',
                'prenom_user' => 'required|string',
                'mail_user' => 'required|email',
                
                ];

            $messages = [
                'required' => 'Le champ :attribute est requis.',
                'email' => 'Le champ :attribute doit être une adresse email valide.',
                'unique' => 'Le champ :attribute est déjà utilisée.',
                'min' => 'Le champ :attribute doit avoir au moins :min caractères.',
                'max' => 'Le champ :attribute ne doit pas avoir plus de :max caratères.',
                'int' => 'Le champ :attribue doit etre un chiffre.',
                ];

            $validator = Validator::make($request->all(), $rules ,$messages);

            if ($validator->fails()) {

                return redirect()->route('edit_user', ['id_user' => $user->id_user])
                    ->withErrors($validator)
                    ->withInput();
                }

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

    public function showSearchUser()
        {
            // Récupération de la valeur de recherche
            $recherche = request()->recherche;

            // Recherche des utilisateurs en fonction du terme de recherche
            $users = User::where(function ($query) use ($recherche) {
                    $query->where('nom_user', 'LIKE', "%$recherche%")
                        ->orWhere('prenom_user', 'LIKE', "%$recherche%")
                        ->orWhere('mail_user', 'LIKE', "%$recherche%");
                })
                ->get();

            // Passer les données à la vue
            return view('users.listeUsers', [
                'users' => $users,
                'valeur_recherche' => $recherche
            ]);
        }

     public static function hasAccess($requiredPrivilege)
        {
            // Récupérer l'utilisateur actuellement connecté
            $currentUser = auth()->user();

            // Vérifier si l'utilisateur existe et si son niveau de privilège est supérieur ou égal au niveau requis
            return $currentUser && $currentUser->privilege_user >= $requiredPrivilege;
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

    public function login(Request $request)
        {
            $credentials = request()->only('mail_user', 'password');

            $auth = Auth::attempt($credentials, false);
            if ($auth) 
            { 
                Session::regenerate();
                $auth = Auth::user();

                $privilege_user = null;
                $is_admin = User::where('id_user',auth()->user()->privilege_user)
                ->exists();

                if($is_admin){
                    $privilege_user = '3';
                }else{
                    $is_user = User::where('id_user',auth()->user()->privilege_user)
                    ->exists();
                    if($is_user){
                        $privilege_user = '2';
                    }else{
                        $privilege_user = '1';
                    }
                }
                Session::put('privilege_user', $privilege_user);
                return redirect()->route('accueil');

            }

            return back()->withErrors(['login' => 'Identifiants ou mot de passe incorrects'])->withInput();
        }

    public function logout(Request $request)
        {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login');
        }
}

// {
//     public function index()
//     {
//         $users = User::orderBy('nom_user')->get();
//         return view('users.listeUsers', [
//             'users' => $users,
//         ]);
//     }

//     public function create()
//     {
//         return view('users.createUser');
//     }

//     public function store(Request $request)
//     {
//         $rules = [
//             'nom_user' => 'required|string',
//             'prenom_user' => 'required|string',
//             'mail_user' => 'required|email|unique:users',
//             'password' => 'required|string|min:8',
//             'privilege_user' => 'nullable|integer',
//         ];

//         $messages = [
//             'required' => 'Le champ :attribute est requis.',
//             'email' => 'Le champ :attribute doit être une adresse email valide.',
//             'unique' => 'Le champ :attribute est déjà utilisée.',
//             'min' => 'Le champ :attribute doit avoir au moins :min caractères.',
//         ];

//         $validator = Validator::make($request->all(), $rules, $messages);

//         if ($validator->fails()) {
//             return redirect()->route('users.create')
//                 ->withErrors($validator)
//                 ->withInput();
//         }

//         User::create([
//             'nom_user' => $request->nom_user,
//             'prenom_user' => $request->prenom_user,
//             'mail_user' => $request->mail_user,
//             'password' => bcrypt($request->password),
//             'privilege_user' => $request->privilege_user,
//         ]);

//         return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
//     }

//     public function edit($id)
//     {
//         $user = User::findOrFail($id);
//         return view('users.editUser', [
//             'user' => $user,
//         ]);
//     }

//     public function update(Request $request, $id)
//     {
//         $user = User::findOrFail($id);

//         $rules = [
//             'nom_user' => 'required|string',
//             'prenom_user' => 'required|string',
//             'mail_user' => 'required|email|unique:users,mail_user,' . $user->id,
//         ];

//         $messages = [
//             'required' => 'Le champ :attribute est requis.',
//             'email' => 'Le champ :attribute doit être une adresse email valide.',
//             'unique' => 'Le champ :attribute est déjà utilisée.',
//         ];

//         $validator = Validator::make($request->all(), $rules, $messages);

//         if ($validator->fails()) {
//             return redirect()->route('users.edit', $user->id)
//                 ->withErrors($validator)
//                 ->withInput();
//         }

//         $user->update($request->only(['nom_user', 'prenom_user', 'mail_user', 'privilege_user']));

//         return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
//     }

//     public function destroy($id)
//     {
//         $user = User::findOrFail($id);
//         $user->delete();
//         return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
//     }

//     public function search(Request $request)
//     {
//         $recherche = $request->input('recherche');

//         $users = User::where('nom_user', 'LIKE', "%$recherche%")
//             ->orWhere('prenom_user', 'LIKE', "%$recherche%")
//             ->orWhere('mail_user', 'LIKE', "%$recherche%")
//             ->get();

//         return view('users.listeUsers', [
//             'users' => $users,
//             'valeur_recherche' => $recherche,
//         ]);
//     }

//     public static function hasAccess($requiredPrivilege)
//     {
//         $currentUser = auth()->user();
//         return $currentUser && $currentUser->privilege_user >= $requiredPrivilege;
//     }

//     /*
//      * PARTIE DE/CONNEXION
//      */

//     public function showLoginForm()
//     {
//         try {
//             $users = User::all();
//             return view('log.login', [
//                 'users' => $users,
//             ]);
//         } catch (\Exception $e) {
//             return view('errors.custom_error', [
//                 'error_message' => "Une erreur s'est produite lors du chargement des utilisateurs.",
//             ]);
//         }
//     }

//     public function login(Request $request)
//     {
//         $credentials = $request->only('mail_user', 'password');

//         if (Auth::attempt($credentials)) {
//             Session::regenerate();
//             $user = Auth::user();

//             $privilege_user = $user->privilege_user;

//             Session::put('privilege_user', $privilege_user);

//             return redirect()->route('accueil');
//         }

//         return back()->withErrors(['login' => 'Identifiants ou mot de passe incorrects'])->withInput();
//     }

//     public function logout(Request $request)
//     {
//         Auth::guard('web')->logout();
//         $request->session()->invalidate();
//         $request->session()->regenerateToken();

//         return redirect()->route('login');
//     }
// }