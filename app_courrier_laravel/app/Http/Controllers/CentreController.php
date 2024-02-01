<?php

namespace App\Http\Controllers;

use App\Models\Centre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CentreController extends Controller
{
    public function showCentre ()
    {
        $centres = Centre::orderBy('nom_centre')->get(); // Tri par ordre alphabétique du nom
                
        return view('centres.listeCentres', compact('centres'));
    }

    public function showCreateCentre ()
    {
        // Récupere toutes les donneés
        $centres = Centre::all();

        // Envoi les données a la view createCentre
        return view('centres.createCentre', compact('centres'));
    }


    public function createCentre(Request $request)
    {

        $rules = [
            'nom_centre' => 'required|string|max:255',
            'adresse_centre' => 'required|string|max:255',
            'CP_centre' => 'required|string|max:5',
            'telephone_centre' => 'required|string|min:10|max:14',
        ];

        $messages = [
            'required' => 'Le champ :attribute est requis.',
            'min' => 'Le champ :attribute doit avoir au moins :min caratères.',
            'max' => 'Le champ :attribute ne doit pas avoir plus de :max caratères.',
        ];

        // Validation des données
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect()->route('creation_centre')
            ->withErrors($validator)
            ->withInput();
        }

        // Création du centre
        Centre::create([
            'nom_centre' => $request->nom_centre,
            'adresse_centre' => $request->adresse_centre,
            'CP_centre' => $request->CP_centre,
            'telephone_centre' => $request->telephone_centre,
        ]);

        // Redirection vers la liste des services
        return redirect()->route('liste_centres');
    }

          
    public function showEditCentre($id_centre)
    {
        // Récupérez le centre à éditer en fonction de l'id
        $centre = Centre::find($id_centre);
        
           // Vérifiez si le centre a été trouvé
        if (!$centre) {
            return redirect()->route('liste_centres')->with('error', 'Centre non trouvé.');
        }
    
        return view('centres.editCentre', [
            'centre' => $centre,
        ]);
    }
     

        public function updateCentre(Request $request, $id_centre)
    {
        $centre = Centre::find($id_centre);

        $rules = [
            'nom_centre' => 'required|string|max:255',
            'adresse_centre' => 'required|string|max:255',
            'CP_centre' => 'required|string|max:5',
            'telephone_centre' => 'required|string|min:10|max:14',
        ];

        $messages = [
            'required' => 'Le champ :attribute est requis.',
            'min' => 'Le champ :attribute doit avoir au moins :min caratères.',
            'max' => 'Le champ :attribute ne doit pas dépasser les :max caratères.'
        ];

        // Validation des données
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect()->route('edit_centre', ['id_centre' => $centre->id_centre])
            ->withErrors($validator)
            ->withInput();
        }
            $centre->update($request->all());
            return redirect()->route('liste_centres')      
            ->with('success', 'Centre à ete mis a jour.');
    }


    public function deleteCentre($id_centre)
    {
        try {
            // Recherche du centre à supprimer
            $centre = Centre::findOrFail($id_centre);

            // Suppression du centre
            $centre->delete();

            // Redirection vers la liste des centres avec un message de succès constant
            return redirect()->route('liste_centres')->with('success', __('Le centre a été supprimé avec succès.'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            // Redirection vers la liste des centres avec un message d'erreur constant
            return redirect()->route('liste_centres')->with('error', __('Le centre n\'a pas été trouvé.'));
        }
    }
        
}
