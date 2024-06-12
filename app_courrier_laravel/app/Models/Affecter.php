<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Déclare une classe Affecter qui hérite des fonctionnalités de Model
class Affecter extends Model
{
    use HasFactory; // Utilise le trait HasFactory pour permettre la génération de données factices
    
    protected $table = 'affecters'; // Spécifie le nom de la table associée à ce modèle
    protected $fillable = ['id_service', 'id_user']; // Définit les colonnes qui peuvent être assignées en masse
    protected $primaryKey = ['id_service', 'id_user']; // Spécifie que la clé primaire est composée de deux colonnes
    public $timestamps = false; // Indique que le modèle ne gère pas les colonnes created_at et updated_at

    // Définit une relation inverse avec le modèle User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user'); 
        // Cette relation indique qu'un enregistrement de la table 'affecters' appartient à un enregistrement de la table 'users' via 'id_user'
    }

    // Définit une relation inverse avec le modèle Service
    public function service()
    {
        return $this->belongsTo(Service::class, 'id_service', 'id_service'); 
        // Cette relation indique qu'un enregistrement de la table 'affecters' appartient à un enregistrement de la table 'services' via 'id_service'
    }
}
