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
        ->orderByDesc('date_courrier')
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
        $date_maintenant = now()->toDateString();

        // Vérifier si un fichier est téléchargé
        if ($request->hasFile('scan_courrier')) {
          
            // Enregistrer le fichier dans le stockage
            $chemin = $request->file('scan_courrier')->store('scans_courriers');
        } else {
            // Gérer le cas où aucun fichier n'est téléchargé
            $chemin = null;
        }

        $rules =[
            'objet_courrier' => 'required|string|max:50',
            'destinataire_courrier' => 'required|string|max:50',
            'description_courrier' => 'nullable|string|max:255',
            'scan_courrier' => 'nullable|file|max:250',
            'id_centre' => 'required|numeric',
            'id_user' => 'required|numeric',
            'id_service' => 'required|numeric',
        ];

        $messages = [
            'required' => 'Le champ :attribute est requis.',
            'string' => 'Le champ :attribute doit être une chaîne de caractères.',
            'max' => 'Le champ :attribute ne doit pas dépasser :max caractères.',
            'numeric' => 'Le champ :attribute doit être un nombre.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect()->route('creation_courrier')
                ->withErrors($validator)
                ->withInput();
        }

        Courrier::create([
            'date_courrier' => $date_maintenant,
            'objet_courrier' => $request->objet_courrier,
            'destinataire_courrier' => $request->destinataire_courrier,
            'description_courrier' => $chemin,
            'scan_courrier' => $chemin,
            'id_centre' => $request->id_centre,
            'id_user' => auth()->user()->id_user,
            'id_service' => $request->id_service,
        ]);

        // Redirigez vers la vue de création de courrier avec un message de succès
        return redirect()->route('liste_courriers')->with('success', 'Le courrier à été ajouté avec succès.');

    }

    public function showEditCourrier($id_courrier)
    {
        // Recherche du courrier avec les relations
        $courrier = Courrier::with(['centre', 'user', 'service'])
            ->find($id_courrier);

        // Vérifiez si le courrier existe
        if (!$courrier) {
            // Redirigez ou affichez une erreur selon vos besoins
            return redirect()->route('liste_courriers')->with('error', 'Le courrier n\'a pas été trouvé.');
        }

        // Récupérez également les listes de centres, utilisateurs et services
        $centres = Centre::all();
        $users = User::all();
        $services = Service::all();

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
            'destinataire_courrier' => 'required|string|max:50',
            'description_courrier' => 'string|max:255',
            'id_centre' => 'required',
            'id_user' => 'required',
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
            // Suppression du courrier
            $courrier->delete();

            // Redirection vers la liste des courriers avec un message de succès
            return redirect()->route('liste_courriers')->with('success', 'Le courrier a été supprimé avec succès.');
        }

        // Redirection vers la liste des courriers avec un message d'erreur
        return redirect()->route('liste_courriers')->with('error', 'Le courrier n\'a pas été trouvé.');
    }

    public function showSearchCourrier()
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
    
    public function depotcourrier (Request $request, $id_courrier)
    {
        // Charger le fichier courrier
        $file = request()->courrier;
        $path = $file->store();

        // Trouver la visite et mettre à jour
        // $Courrier = Courrier::find($id_courrier)
        // ->update('scan_courrier' => $chemin,);
         

        return redirect()->route('courriers.courrier');
    }

    public function download ($chemin, $id_courrier) 
    {
        $courrier = Courrier::where($id_courrier)
            ->get();

        return Storage::download($chemin, 'COURRIER - '.$courrier->objet_courrier.'-'.Carbon::now('Europe/Paris')->format('d-m-Y'));
    }


}

