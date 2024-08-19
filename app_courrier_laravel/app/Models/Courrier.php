<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Déclare une classe Courrier qui hérite des fonctionnalités de Model
class Courrier extends Model
{
    use HasFactory; // Utilise le trait HasFactory pour permettre la génération de données factices

    // Définition des attributs qui sont castés en types de données spécifiques
    protected $casts = [
        'date_courrier' => 'date' // Cast l'attribut 'date_courrier' en type date
    ];
    
    // Définition des relations avec d'autres modèles
    public function user(): BelongsTo
    {
        // Un courrier appartient à un utilisateur (relation BelongsTo)
        return $this->belongsTo(User::class, 'id_user');
    }

    public function centre(): BelongsTo
    {
        // Un courrier appartient à un centre (relation BelongsTo)
        return $this->belongsTo(Centre::class, 'id_centre');
    }

    public function service(): BelongsTo
    {
        // Un courrier appartient à un service (relation BelongsTo)
        return $this->belongsTo(Service::class, 'id_service');
    }

    // Désactivation des timestamps automatiques
    public $timestamps = false;

    // Définition des attributs remplissables
    protected $fillable = [
        'date_courrier',          // Date du courrier
        'objet_courrier',         // Objet du courrier
        'destinataire_courrier',  // Destinataire du courrier
        'description_courrier',   // Description du courrier
        'scan_courrier',          // Scan du courrier (fichier)
        'id_centre',              // ID du centre associé
        'id_user',                // ID de l'utilisateur associé
        'id_service',             // ID du service associé
    ];

    // Définition de la clé primaire personnalisée
    protected $primaryKey = 'id_courrier'; // Spécifie que la clé primaire de la table est 'id_courrier'
}