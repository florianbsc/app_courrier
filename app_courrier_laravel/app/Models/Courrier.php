<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Courrier extends Model
{
    use HasFactory;

    // Définition des attributs qui sont castés en types de données spécifiques
    protected $casts = [
        'date_courrier' => 'date'
    ];
    
    // Définition des relations avec d'autres modèles
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function centre(): BelongsTo
    {
        return $this->belongsTo(Centre::class, 'id_centre');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'id_service');
    }

    // Désactivation des timestamps automatiques
    public $timestamps = false;

    // Définition des attributs remplissables
    protected $fillable = [
        'date_courrier',
        'objet_courrier',
        'destinataire_courrier',
        'description_courrier',
        'scan_courrier',
        'id_centre',
        'id_user',
        'id_service',
    ];

    // Définition de la clé primaire personnalisée
    protected $primaryKey = 'id_courrier';
}
