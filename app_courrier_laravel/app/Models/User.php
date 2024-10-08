<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// Déclare une classe User qui hérite des fonctionnalités d'Authenticatable pour l'authentification
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // Utilise des traits pour l'API, les factories, et les notifications

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_user',           // ID de l'utilisateur
        'nom_user',          // Nom de l'utilisateur
        'prenom_user',       // Prénom de l'utilisateur
        'login_user',
        'mail_user',         // Email de l'utilisateur
        'password',          // Mot de passe de l'utilisateur
        'privilege_user',    // Privilège de l'utilisateur
    ];

    /**
     * Les attributs qui doivent être cachés pour la sérialisation.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',          // Cache le mot de passe
        'remember_token',    // Cache le token de souvenir
    ];

    /**
     * Les attributs qui doivent être castés en types spécifiques.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime', // Cast l'attribut email_verified_at en datetime
        'password' => 'hashed',            // Hash le mot de passe
    ];

    // Désactive les timestamps automatiques
    public $timestamps = false;

    // Définition de la clé primaire personnalisée
    protected $primaryKey = 'id_user'; // Spécifie que la clé primaire de la table est 'id_user'

    // Récupère le mot de passe pour l'authentification
    public function getAuthPassword()
    {
        return $this->attributes['password'];
    }

    // Utilise l'email comme nom d'utilisateur pour l'authentification
    public function username()
    {
        return 'mail_user';
    }

    // Définir la relation avec les services via la table 'affecters'
    public function services()
    {
        // Relation plusieurs-à-plusieurs avec le modèle Service via la table 'affecters'
        return $this->belongsToMany(Service::class, 'affecters', 'id_user', 'id_service');
    }

    // Définir la relation entre User et Courrier
    public function courriers()
    {
        return $this->hasMany(Courrier::class, 'id_user');
    }


    // Méthode statique pour vérifier si l'utilisateur appartient à un service spécifique
    public static function inService($serviceAChecker)
    {
        // Récupère l'utilisateur authentifié
        $user = auth()->user()->id_user;

        // Compte le nombre d'affectations de l'utilisateur pour le service spécifique
        $affecterUsers = Affecter::select('*')
            ->where('id_user', '=', $user)  // Filtre par l'ID de l'utilisateur
            ->where('id_service', '=', $serviceAChecker) // Filtre par l'ID du service
            ->groupBy('id_user')  // Regroupe les résultats par utilisateur
            ->count(); // Compte le nombre de résultats

        // Retourne le nombre d'affectations trouvées
        return $affecterUsers;
    }

    // fonction qui lie l'intitulé au niveau de privilege
    public function getPrivilegeTitleAttribute()
    {
        switch ($this->privilege_user) {
            case 1:
                return 'Invité';
            case 2:
                return 'Employé';
            case 3:
                return 'Directeur';
            case 4:
                return 'Admin';
            case 0:
            default:
                return 'Désactivé';
        }
    }

}

