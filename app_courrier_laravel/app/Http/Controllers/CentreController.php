<?php

namespace App\Http\Controllers;

use App\Models\Centre;
use Illuminate\Http\Request;


class CentreController extends Controller
{
    public function showCentre ()
    {
        $centres = Centre::all();

        return view('centres.listeCentres',[
            'centres' => $centres,
        ]);
    }

    public function showCreateCentre ()
    {
        // Récupere toutes les donneés
        $centres = Centre::all();

        // Envoi les données a la view createCentre
        return view('centres.createCentre',[
            'centres' => $centres,
        ]);
    }

    public function createCentre(Request $request)
    {
        // Validation des données
        $request->validate([
            'nom_centre' => 'required|string|max:255',
            'adresse_centre' => 'required|string|max:255',
            'CP_centre' => 'required|string|max:10',
            'telephone_centre' => 'required|string|max:20',
        ]);

        // Création du centre
        Centre::create([
            'nom_centre' => $request->nom_centre,
            'adresse_centre' => $request->adresse_centre,
            'CP_centre' => $request->CP_centre,
            'telephone_centre' => $request->telephone_centre,
        ]);

        // Redirection vers la liste des centres
        return redirect()->route('liste_centres');
    }

    public function showEditCentre($id_centre)
    {
        // Récupérez le centre à éditer en fonction de l'id
        $centre = Centre::find($id_centre);
    
        return view('centres.editCentre', [
            'centre' => $centre,
        ]);
    }

        public function updateCentre(Request $request, $id_centre)
    {
        // Récupérez le centre à mettre à jour en fonction de l'id
        $centre = Centre::find($id_centre);

        // Mettez à jour les propriétés du centre avec les données du formulaire
        $centre->nom_centre = $request->nom_centre;
        $centre->adresse_centre = $request->adresse_centre;
        $centre->CP_centre = $request->CP_centre;
        $centre->telephone_centre = $request->telephone_centre;

        // Enregistrez les modifications
        $centre->update($request->all());

        return redirect()->route('liste_centres')      
        ->with('success', 'Centre à ete mis a jour.');
    }


    public function deleteCentre($id_centre)
    {
        // Recherche du centre à supprimer
        $centre = Centre::find($id_centre);
    
        // Vérification si le centre existe
        if (isset($centre)) {
            // Suppression du centre
            $centre->delete();
    
            // Redirection vers la liste des centres avec un message de succès
            return redirect()->route('liste_centres')->with('success', 'Le centre a été supprimé avec succès.');
        } else {
            // Redirection vers la liste des centres avec un message d'erreur
            return redirect()->route('liste_centres')->with('error', 'Le centre n\'a pas été trouvé.');
        }
    }
        
}
