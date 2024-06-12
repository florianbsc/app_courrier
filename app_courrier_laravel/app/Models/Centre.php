<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Déclare une classe Centre qui hérite des fonctionnalités de Model
class Centre extends Model
{
    use HasFactory; // Utilise le trait HasFactory pour permettre la génération de données factices

    // Définit les colonnes qui peuvent être assignées en masse
    protected $fillable = [
        'id_centre',        // L'ID unique du centre
        'nom_centre',       // Le nom du centre
        'adresse_centre',   // L'adresse du centre
        'CP_centre',        // Le code postal du centre
        'telephone_centre'  // Le numéro de téléphone du centre
    ];

    public $timestamps = false; // Indique que le modèle ne gère pas les colonnes created_at et updated_at

    protected $primaryKey = 'id_centre'; // Spécifie que la clé primaire de la table est la colonne id_centre
}
