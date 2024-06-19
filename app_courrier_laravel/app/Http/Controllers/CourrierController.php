<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;
// importe les models
use App\Models\Courrier;
use App\Models\Centre;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

use function Laravel\Prompts\select;
use Illuminate\Support\Facades\Validator;

// back end de l'app


class CourrierController extends Controller
{

    public function showCourrier()
        {

            // requete pour recuperer le courrier avec le nom du centre, le nom du service et le full_name de l'users
            // assigne les valeurs de la table `courrier` a la variable $courriers
            // MODELE ELOQUENT

            $courriers = Courrier::select('courriers.*', 'centres.nom_centre', 'services.nom_service', 'users.nom_user', 'users.prenom_user')
            ->orderByDesc('id_courrier')
                ->leftJoin('centres', 'courriers.id_centre', '=', 'centres.id_centre')
                ->leftJoin('services', 'courriers.id_service', '=', 'services.id_service')
                ->leftJoin('users', 'courriers.id_user', '=', 'users.id_user')
                ->get();
            $user_connected = auth()->user();
            $centres = Centre::all();
            $users = User::all();
            $services = Service::all();

            return view('courriers.courrier', [
                'courriers' => $courriers,
                'centres' => $centres,
                'users' => $users,
                'services' => $services,
                'connecter' => $user_connected,
            ]);

        }

    public function showCreateCourrier ()
        {
            $centres = Centre::all();
            $users = User::all();
            $services = Service::all();

            return view('courriers.createCourrier', [
                'centres' => $centres,
                'users' => $users,
                'services' => $services,
            ]);
        }

    public function createCourrier(Request $request)
        {
            // dd($request->destinataire_courrier);
          
            $rules =[
                'objet_courrier' => 'required|string|max:50',
                'destinataire_courrier' => 'nullable|numeric',
                'description_courrier' => 'nullable|string|max:255',
                'scan_courrier' => 'nullable|file',
                'id_centre' => 'nullable|numeric',
                'id_user' => 'required|numeric',
                // 'id_service' => 'nullable|numeric',
            ];

            $messages = [
                'required' => 'Le champ :attribute est requis.',
                'string' => 'Le champ :attribute doit être une chaîne de caractères.',
                'max' => 'Le champ :attribute ne doit pas dépasser :max caractères.',
                'numeric' => 'Le champ :attribute doit être un nombre.'
            ];

            $date_maintenant = now()->toDateString();
            
            $request->validate(['scan_courrier' => 'file|mimes:pdf',]);
           
            // Vérifier si un fichier est téléchargé
            if ($request->hasFile('scan_courrier')) {
            
                // Enregistrer le fichier dans le stockage
                $chemin = $request->file('scan_courrier')->store();
                
            } else {
                // Gérer le cas où aucun fichier n'est pas téléchargé
                $chemin = null;
            }
            $validator = Validator::make($request->all(), $rules, $messages);
        

            if ($validator->fails()) {

                return redirect()->route('creation_courrier')
                    ->withErrors($validator)
                    ->withInput();
            }

            DB::transaction(function () use ($request, $chemin ,$date_maintenant) {
                // Création du courrier
                $courrier = Courrier::create([
                    'date_courrier' => $date_maintenant,
                    'objet_courrier' => $request->objet_courrier,
                    'destinataire_courrier' => $request->destinataire_courrier,
                    // 'description_courrier' =>  $request->description_courrier,
                    'scan_courrier' => $chemin,
                    'id_centre' => $request->id_centre,
                    'id_user' => auth()->user()->id_user,
                    'id_service' => $request->id_service,
                ]);

                // if (!is_int($courrier->id_courrier)) {
                //     throw new \Exception('L\'ID de du courrier n\'a pas été récupéré');
                // }

                // foreach ($request->id_users as $id_user) {
                //     DB::table('users')->insert([
                //         'id_user' => $id_user,
                //     ]);
                // }
            });

            // Redirigez vers la vue de création de courrier avec un message de succès
            return redirect()->route('liste_courriers')->with('success', 'Le courrier à été ajouté avec succès.');

        }

    public function showEditCourrier($id_courrier)
        {
            // Recherche du courrier avec les relations
            $courrier = Courrier::with(['centre', 'user', 'service'])
            ->find($id_courrier);
            
            // Récupérez également les listes de centres, utilisateurs et services
            $centres = Centre::all();
            $users = User::all();
            $services = Service::all();

            // Vérifiez si le courrier existe
            if ($courrier == null) 
            {
                // Message d'erreur
                return redirect()->route('liste_courriers')->with('error', 'Le courrier n\'a pas été trouvé.');
            }
            if($courrier->id_)

            // verrifie si l'utilisateur connecter à les droits d'accéder au courrier
            if($courrier->id_user !== auth()->user()->id_user && auth()->user()->privilege_user !== 3 )
                {
                    return view('gestion.erreur');
                }
            

           

            // Passez le courrier et les listes aux vues
            return view('courriers.editCourrier', [
                'courrier' => $courrier,
                'centres' => $centres,
                'users' => $users,
                'services' => $services,
            ]);
        }

    public function updateCourrier(Request $request, $id_courrier)
        {
            $courrier = Courrier::find($id_courrier);

            $rules = [
                'objet_courrier' => 'required|string|max:50',
                'destinataire_courrier' => 'nullable|numeric',
                // 'description_courrier' => 'string|max:255',
                'id_centre' => 'required',
                // 'id_user' => 'required',
                'id_service' => 'required',
            ];

            $messages = [
                'required' => 'Le champ :attribute est requis.',
                'max' => 'Le champ :attribute ne doit pas dépasser les :max caractères.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {

                return redirect()->route('edit_courrier',['id_courrier' => $courrier->id_courrier])
                    ->withErrors($validator)
                    ->withInput();
            }

            $courrier->update($request->all());

            // Redirigez vers la vue de création de courrier avec un message de succès
            return redirect()->route('liste_courriers');
        }


    public function deleteCourrier($id_courrier)
        {
            // Recherche du courrier à supprimer
            $courrier = Courrier::find($id_courrier);

            // Vérification si le courrier existe
            if ($courrier) {
                if(!empty($courrier->scan_courrier)){
                    // Suppression du scan courrier en local
                    Storage::delete($courrier->scan_courrier );
                } 

                // Suppression du courrier
                $courrier->delete();
                
                // Redirection vers la liste des courriers avec un message de succès
                return redirect()->route('liste_courriers')->with('success', 'Le courrier à été supprimé avec succès.');
            }

            // Redirection vers la liste des courriers avec un message d'erreur
            return redirect()->route('liste_courriers')->with('error', 'Le courrier n\'à pas été trouvé.');
        }

    /* public function showSearchCourrier()
        {
            $recherche = request()->recherche;

            // Recherche des courriers en fonction du terme de recherche
            $courriers = Courrier::select('courriers.*', 'centres.nom_centre', 'services.nom_service', 'users.nom_user', 'users.prenom_user')
                ->leftJoin('centres', 'courriers.id_centre', '=', 'centres.id_centre')
                ->leftJoin('services', 'courriers.id_service', '=', 'services.id_service')
                ->leftJoin('users', 'courriers.id_user', '=', 'users.id_user')
                ->where(function ($query) use ($recherche) {
                    $query->where('courriers.date_courrier', 'LIKE', "%$recherche%")
                        ->orWhere('courriers.objet_courrier', 'LIKE', "%$recherche%")
                        ->orWhere('courriers.destinataire_courrier', 'LIKE', "%$recherche%")
                        ->orWhere('courriers.description_courrier', 'LIKE', "%$recherche%")
                        ->orWhere('centres.nom_centre', 'LIKE', "%$recherche%")
                        ->orWhere('users.nom_user', 'LIKE', "%$recherche%")
                        ->orWhere('services.nom_service', 'LIKE', "%$recherche%");
                })
                ->get();

            // Charger uniquement les centres, utilisateurs et services nécessaires en utilisant pluck()
            $centres = Centre::pluck('nom_centre', 'id_centre');
            $users = User::pluck('nom_user', 'id_user');
            $services = Service::pluck('nom_service', 'id_service');

            return view('courriers.courrier', [
                'courriers' => $courriers,
                'centres' => $centres,
                'users' => $users,
                'services' => $services,
                'valeur_recherche' => $recherche
            ]);
        }
            */
    public function showSearchCourrier()
        {
            $recherche = request()->input('recherche');

            // Recherche des courriers en fonction du terme de recherche
            $courriers = Courrier::with(['centre', 'service', 'user']) //jointure 
                ->when($recherche, function ($query, $recherche) {
                    $query->where(function ($query) use ($recherche) {
                        $query->where('date_courrier', 'LIKE', "%$recherche%")
                            ->orWhere('objet_courrier', 'LIKE', "%$recherche%")
                            ->orWhere('destinataire_courrier', 'LIKE', "%$recherche%")
                            ->orWhere('description_courrier', 'LIKE', "%$recherche%")
                            ->orWhereHas('centre', function ($query) use ($recherche) {
                                $query->where('nom_centre', 'LIKE', "%$recherche%");
                            })
                            ->orWhereHas('service', function ($query) use ($recherche) {
                                $query->where('nom_service', 'LIKE', "%$recherche%");
                            })
                            ->orWhereHas('user', function ($query) use ($recherche) {
                                $query->where('nom_user', 'LIKE', "%$recherche%");
                            });
                    });
                })
                ->get();

            // Charger uniquement les centres, utilisateurs et services nécessaires en utilisant pluck()
            $centres = Centre::pluck('nom_centre', 'id_centre');
            $users = User::pluck('nom_user', 'id_user');
            $services = Service::pluck('nom_service', 'id_service');

            return view('courriers.courrier', [
                'courriers' => $courriers,
                'centres' => $centres,
                'users' => $users,
                'services' => $services,
                'valeur_recherche' => $recherche
            ]);
        }

    public function depotScanCourrier(Request $request, $id_courrier)
        {

            $request->validate(['scan_courrier' => 'required|file|mimes:pdf',]);

            // Vérifier si un fichier est téléchargé
            if ($request->hasFile('scan_courrier')) {
            
                // Enregistrer le fichier dans le stockage
                $chemin = $request->file('scan_courrier')->store();
            } else {
                // Gérer le cas où aucun fichier n'est téléchargé
                $chemin = null;
            }

            // Trouver le courrier et mettre à jour le chemin du fichier
            $courrier = Courrier::findOrFail($id_courrier);
            $courrier->scan_courrier = $chemin;
            $courrier->save();

            // Rediriger l'utilisateur avec un message de succès
            return redirect()->route('liste_courriers')->with('success', 'Le fichier à été téléchargé et enregistré avec succès.');
        }


    public function download ($chemin) 
        {
        
            // return Storage::download($chemin);
            return Storage::download($chemin, 'COURRIER - '.'-'.Carbon::now('Europe/Paris')->format('d-m-Y').'.pdf');
        }

    
    public function deleteScan ($id_courrier)
        {
        // Recupere les info du courrier
        $courrier = Courrier::find($id_courrier);

        // Vérification si le courrier existe
        if ($courrier) {
            
            // Suppression du scan courrier en local
            Storage::delete($courrier->scan_courrier );

            // Suppression du scan courrier dans la db
            $courrier->scan_courrier = null;
            $courrier->save();

            // Redirection vers la liste des courriers avec un message de succès
            return redirect()->route('liste_courriers')->with('success', 'Le scan à été supprimé avec succès.');
        }

        // Redirection vers la liste des courriers avec un message d'erreur
        return redirect()->route('liste_courriers')->with('error', 'Le courrier n\'à pas été trouvé.');
        }
}

