<?php
/*
Gère les opérations relatives aux utilisateurs, notamment l'affichage de la liste des utilisateurs avec
leurs services associés, la création et la modification d'utilisateurs en validant les données saisies, la gestion de la
suppression d'utilisateurs, en prenant en compte les éventuels courriers associés.
Il permet également la recherche d'utilisateurs selon divers critères, vérifie les privilèges d'accès et prend en charge
le processus de connexion et de déconnexion, tout en assurant la gestion des sessions et des niveaux de privilège.
 */
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use App\Models\Affecter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Affiche la liste des utilisateurs avec leurs services associés
    public function showUser()
        {
            // Récupère les utilisateurs avec leurs services associés
            $users = User::select('users.*', 'services.nom_service')
            ->where('nom_user', '!=', 'aucun')
            ->leftJoin('affecters','users.id_user' , '=', 'affecters.id_user')
            ->leftJoin('services', 'services.id_service', '=','affecters.id_service')
            ->orderBy('users.nom_user', 'asc')
            ->get();

            // Retourne la vue avec la liste des utilisateurs
            return view('users.listeUsers', [
                'users' => $users
            ]);
        }

    // Affiche le formulaire de création d'utilisateur
    public function showCreateUser()
    {
        // Récupère tous les services
        $services = Service::orderBy('nom_service')->get();

        // Retourne la vue de création d'utilisateur avec les utilisateurs et les services
        return view('users.createUser', [
            'services' => $services,
        ]);
    }

    // Crée un nouvel utilisateur avec les services associés
    public function createUser(Request $request)
    {
        // Définition des règles de validation
        $rules = [
            'nom_user' => 'required|string',
            'prenom_user' => 'required|string',
            'mail_user' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'privilege_user' => 'nullable|int',
            // 'id_services' => 'required|int|exists:services,id_service',
        ];

        // Définition des messages d'erreur personnalisés
        $messages = [
            'required' => 'Le champ :attribute est requis.',
            'email' => 'Le champ :attribute doit être une adresse email valide.',
            'unique' => 'Le champ :attribute est déjà utilisée.',
            'min' => 'Le champ :attribute doit avoir au moins :min caractères.',
            'max' => 'Le champ :attribute ne doit pas avoir plus de :max caractères.',
            'int' => 'Le champ :attribute doit être un chiffre.',
        ];

        // Validation des données de la requête
        $validator = Validator::make($request->all(), $rules, $messages);

        // Si la validation échoue, redirige avec les erreurs et les données saisies
        if ($validator->fails()) {
            return redirect()->route('creation_user')
                ->withErrors($validator)
                ->withInput();
        }

        // Utilisation d'une transaction pour garantir l'intégrité des opérations de base de données
        DB::transaction(function () use ($request) {
            
            // dd($request);
            // if($request->privilege_user === null ) si pas de previlege le mettre en lvl 0 doit user desactiver
            // {
            //     $request->privilege_user == 0;
            // }
            // Création de l'utilisateur
            $user = User::create([
                'nom_user' => $request->nom_user,
                'prenom_user' => $request->prenom_user,
                'mail_user' => $request->mail_user,
                'password' => bcrypt($request->password),
                'privilege_user' => $request->privilege_user,
            ]);

            // Vérification de l'existence de l'ID de l'utilisateur nouvellement créé
            if (!is_int($user->id_user)) {
                throw new \Exception('L\'ID de l\'utilisateur n\'a pas été récupéré');
            }

            // Insère chaque service sélectionné pour l'utilisateur créé
            foreach ($request->id_services as $id_service) {
                DB::table('affecters')->insert([
                    'id_service' => $id_service,
                    'id_user' => $user->id_user,
                ]);
            }
        });

        // Redirection vers la liste des utilisateurs avec un message de succès
        return redirect()->route('liste_users')
            ->with('success', 'Utilisateur et affectation créés avec succès');
    }

    // Affiche le formulaire d'édition d'un utilisateur
    public function showEditUser($id_user)
    {
        // Récupère l'utilisateur avec les services associés
        $user = User::with('services')->find($id_user);

        // Vérifie si l'utilisateur existe
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'Utilisateur non trouvé.');
        }

        // Récupère tous les services disponibles
        $services = Service::all();

        // Retourne la vue d'édition d'utilisateur avec les données de l'utilisateur et les services
        return view('users.editUser', [
            'user' => $user,
            'services' => $services,
        ]);
    }

    // Met à jour un utilisateur existant
    public function updateUser(Request $request, $id_user)
    {
        // Récupère l'utilisateur à mettre à jour
        $user = User::find($id_user);

        // Définition des règles de validation
        $rules = [
            'nom_user' => 'required|string',
            'prenom_user' => 'required|string',
            'mail_user' => 'required|email',
            'privilege_user' => 'nullable|int',
            'id_services' => 'array',
            'id_services.*' => 'int|exists:services,id_service',
        ];

        // Définition des messages d'erreur personnalisés
        $messages = [
            'required' => 'Le champ :attribute est requis.',
            'email' => 'Le champ :attribute doit être une adresse email valide.',
            'unique' => 'Le champ :attribute est déjà utilisée.',
            'min' => 'Le champ :attribute doit avoir au moins :min caractères.',
            'max' => 'Le champ :attribute ne doit pas avoir plus de :max caractères.',
            'int' => 'Le champ :attribute doit être un chiffre.',
        ];

        // Validation des données de la requête
        $validator = Validator::make($request->all(), $rules, $messages);

        // Si la validation échoue, redirige avec les erreurs et les données saisies
        if ($validator->fails()) {
            return redirect()->route('edit_user', ['id_user' => $user->id_user])
                ->withErrors($validator)
                ->withInput();
        }

        // Utilisation d'une transaction pour garantir l'intégrité des opérations de base de données
        DB::transaction(function () use ($request, $id_user) {
            // Mise à jour de l'utilisateur
            $user = User::find($id_user);
            $user->update([
                'nom_user' => $request->nom_user,
                'prenom_user' => $request->prenom_user,
                'mail_user' => $request->mail_user,
                'privilege_user' => $request->privilege_user,
            ]);

            // Mise à jour des services associés
            $user->services()->sync($request->id_services);
        });

        // Redirection vers la liste des utilisateurs avec un message de succès
        return redirect()->route('liste_users')
            ->with('success', 'Utilisateur et affectation mis à jour avec succès');
    }

    // Supprime un utilisateur par son ID
    public function deleteUser($id_user)
    {
        // Trouve l'utilisateur par son ID
        $user = User::find($id_user);

        // Si l'utilisateur existe
        if ($user) {
            // Vérifie s'il existe des courriers liés à l'utilisateur
            $courriers = $user->courriers; // Assurez-vous que la relation 'courriers' est définie dans le modèle User

            // Si l'utilisateur a des courriers liés, retournez une réponse ou lancez une exception
            if ($courriers->count() > 0) {
                $user->update(['privilege_user' => 0]);
                return redirect()->route('liste_users')->with('error', 'Utilisateur est lié à des courriers. Suppression impossible, il à été desactivé'); 
            }

            // Si aucun courrier n'est trouvé, supprime l'utilisateur
            $user->delete();
            return redirect()->route('liste_users')->with('success', 'Utilisateur supprimé avec succès.'); // Code de statut HTTP 200 pour une réussite
        }

        // Si l'utilisateur n'existe pas, retournez une réponse indiquant l'absence de l'utilisateur
        return redirect()->route('liste_users')->with('error', 'Utilisateur non trouvé.'); 
    }


    // Affiche les résultats de recherche des utilisateurs
    public function showSearchUser()
    {
        // Récupère le terme de recherche depuis la requête
        $recherche = request()->recherche;

        // Recherche les utilisateurs en fonction du terme de recherche
        $users = User::select('users.*', 'services.nom_service')
        ->where('nom_user', "!=", 'aucun')
            ->leftJoin('affecters', 'users.id_user', '=', 'affecters.id_user')
            ->leftJoin('services', 'services.id_service', '=', 'affecters.id_service')
            ->where(function ($query) use ($recherche) {
                // Filtre les utilisateurs par nom, prénom, email, nom de service ou privilège
                $query->where('nom_user', 'LIKE', "%$recherche%")
                    ->orWhere('prenom_user', 'LIKE', "%$recherche%")
                    ->orWhere('mail_user', 'LIKE', "%$recherche%")
                    ->orWhere('nom_service', 'LIKE', "%$recherche%")
                    ->orWhere('privilege_user', 'LIKE', "%$recherche%");
            })->orderBy('nom_user')->get();

        // Passe les résultats de la recherche et le terme de recherche à la vue
        return view('users.listeUsers', [
            'users' => $users,
            'valeur_recherche' => $recherche
        ]);
    }

    // Vérifie si l'utilisateur a le niveau de privilège requis
    public static function hasAccess($requiredPrivilege)
    {
        // Récupère l'utilisateur actuellement connecté
        $currentUser = auth()->user();

        // Vérifie si l'utilisateur existe et si son privilège est suffisant
        return $currentUser && $currentUser->privilege_user >= $requiredPrivilege;
    }


     /*
      * PARTIE DE/CONNEXION
      */

     // Affiche le formulaire de connexion
    public function showLoginForm()
    {
        try {
            // Récupère tous les utilisateurs de la base de données
            $users = User::all();

            // Retourne la vue de connexion avec la liste des utilisateurs
            return view('log.login', [
                'user' => $users,
            ]);
        } catch (\Exception $e) {
            // En cas d'erreur, retourne une vue d'erreur personnalisée avec un message d'erreur
            return view('errors.custom_error', [
                'error_message' => "Une erreur s'est produite lors du chargement des employés.",
            ]);
        }
    }

    // Gère le processus de connexion
    public function login(Request $request)
    {
        // Récupère les informations d'identification (email et mot de passe) de la requête
        $credentials = request()->only('mail_user', 'password');

        // Tente de connecter l'utilisateur avec les informations fournies
        if (Auth::attempt($credentials, false)) 
        { 
            // Regénère la session pour des raisons de sécurité
            Session::regenerate();
            $auth = Auth::user(); // Récupère l'utilisateur connecté

            // Initialisation de la variable de privilège
            $privilege_user = null;

            // Détermine le niveau de privilège de l'utilisateur
            $lvl = $auth->privilege_user; // Supposant que le niveau de privilège est stocké dans 'privilege_user'

            switch ($lvl):
                case 1: 
                    $privilege_user = '1';
                    break;
                case 2:
                    $privilege_user = '2';
                    break;
                case 3:
                    $privilege_user = '3';
                    break;
                case 4: 
                    $privilege_user = '4';
                    break;
                default:
                    $privilege_user = '0';
            endswitch;

            // Stocke le privilège utilisateur dans la session
            Session::put('privilege_user', $privilege_user);

            // Redirige vers la page d'accueil après connexion réussie
            return redirect()->route('accueil');
        }

        // En cas d'échec de la connexion, retourne à la page précédente avec un message d'erreur
        return back()->withErrors(['login' => 'Identifiants ou mot de passe incorrects'])->withInput();
    }

    // Gère la déconnexion de l'utilisateur
    public function logout(Request $request)
    {
        // Déconnecte l'utilisateur
        Auth::guard('web')->logout();

        // Invalide la session actuelle
        $request->session()->invalidate();

        // Regénère le token CSRF pour la sécurité
        $request->session()->regenerateToken();

        // Redirige vers la page de connexion après déconnexion
        return redirect()->route('login');
    }

}
