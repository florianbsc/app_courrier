<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Courrier extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public $timestamps = false;

    protected $fillable = [
        'date_courrier',
        'objet_courrier',
        'destinataire_courrier',
        'description_courrier',
        'id_centre',
        'id_user',
        'id_service',
    ];
    // protected $primaryKey = [
    //     'id_centre',
    //     'id_user',
    //     'id_service',  
    // ];

}
