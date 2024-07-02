<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ['id_service', 'nom_service', 'telephone_service'];
    public $timestamps = false;
    protected $primaryKey = 'id_service';

    // Définir la relation avec les utilisateurs via la table 'affecters'
    public function users()
    {
        return $this->belongsToMany(User::class, 'affecters', 'id_service', 'id_user');
    }

    // Définir la relation entre Service et Courrier
    public function courriers()
    {
        return $this->hasMany(Courrier::class, 'id_user');
    }


}
