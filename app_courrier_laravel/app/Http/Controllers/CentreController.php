<?php
/* La classe CentreController gère les opérations CRUD (Créer, Lire, Mettre à jour, Supprimer) pour les centres,
 y compris l'affichage de la liste des centres, la création, l'édition, la mise à jour et la suppression de centres,
 avec validation des données et gestion des messages d'erreur.
*/
namespace App\Http\Controllers;

use App\Models\Centre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CentreController extends Controller
{
    // Affiche la liste des centres
    public function showCentre()
    {
        // Récupère tous les centres triés par nom
        $centres = Centre::orderBy('nom_centre')->get();

        // Retourne la vue avec la liste des centres
        return view('centres.listeCentres', compact('centres'));
    }

    // Affiche le formulaire de création d'un centre
    public function showCreateCentre()
    {
        // Récupère tous les centres
        $centres = Centre::all();

        // Retourne la vue pour créer un nouveau centre
        return view('centres.createCentre', compact('centres'));
    }

    // Crée un nouveau centre
    public function createCentre(Request $request)
    {
        // Définir les règles de validation
        $rules = [
            'nom_centre' => 'required|string|max:255',
            'adresse_centre' => 'required|string|max:255',
            'CP_centre' => 'required|string|max:5',
            'telephone_centre' => 'required|string|min:10|max:14',
        ];

        // Définir les messages d'erreur
        $messages = [
            'required' => 'Le champ :attribute est requis.',
            'min' => 'Le champ :attribute doit avoir au moins :min caractères.',
            'max' => 'Le champ :attribute ne doit pas avoir plus de :max caractères.',
        ];

        // Valider les données
        $validator = Validator::make($request->all(), $rules, $messages);

        // Si la validation échoue, rediriger avec les erreurs
        if ($validator->fails()) {
            return redirect()->route('creation_centre')
                ->withErrors($validator)
                ->withInput();
        }

        // Créer un nouveau centre
        Centre::create([
            'nom_centre' => $request->nom_centre,
            'adresse_centre' => $request->adresse_centre,
            'CP_centre' => $request->CP_centre,
            'telephone_centre' => $request->telephone_centre,
        ]);

        // Rediriger vers la liste des centres
        return redirect()->route('liste_centres');
    }

    // Affiche le formulaire d'édition d'un centre
    public function showEditCentre($id_centre)
    {
        // Récupérer le centre à éditer en fonction de l'id
        $centre = Centre::find($id_centre);

        // Vérifier si le centre a été trouvé
        if (!$centre) {
            return redirect()->route('liste_centres')->with('error', 'Centre non trouvé.');
        }

        // Retourne la vue pour éditer le centre
        return view('centres.editCentre', [
            'centre' => $centre,
        ]);
    }

    // Met à jour un centre existant
    public function updateCentre(Request $request, $id_centre)
    {
        // Récupérer le centre à mettre à jour
        $centre = Centre::find($id_centre);

        // Définir les règles de validation
        $rules = [
            'nom_centre' => 'required|string|max:255',
            'adresse_centre' => 'required|string|max:255',
            'CP_centre' => 'required|string|max:5',
            'telephone_centre' => 'required|string|min:10|max:14',
        ];

        // Définir les messages d'erreur
        $messages = [
            'required' => 'Le champ :attribute est requis.',
            'min' => 'Le champ :attribute doit avoir au moins :min caractères.',
            'max' => 'Le champ :attribute ne doit pas dépasser les :max caractères.',
        ];

        // Valider les données
        $validator = Validator::make($request->all(), $rules, $messages);

        // Si la validation échoue, rediriger avec les erreurs
        if ($validator->fails()) {
            return redirect()->route('edit_centre', ['id_centre' => $centre->id_centre])
                ->withErrors($validator)
                ->withInput();
        }

        // Mettre à jour le centre avec les nouvelles données
        $centre->update($request->all());

        // Rediriger vers la liste des centres avec un message de succès
        return redirect()->route('liste_centres')
            ->with('success', 'Le centre a été mis à jour avec succès.');
    }

    // Supprime un centre existant
    public function deleteCentre($id_centre)
    {
        try {
            // Recherche du centre à supprimer
            $centre = Centre::findOrFail($id_centre);

            // Suppression du centre
            $centre->delete();

            // Redirection vers la liste des centres avec un message de succès
            return redirect()->route('liste_centres')->with('success', ('Le centre a été supprimé avec succès.'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            // Redirection vers la liste des centres avec un message d'erreur
            return redirect()->route('liste_centres')->with('error', ('Le centre n\'a pas été trouvé.'));
        }
    }
}
