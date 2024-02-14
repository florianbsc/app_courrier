<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Courrier extends Model
{
    use HasFactory;

    protected $casts = [
        'date_courrier' => 'date'
    ];
    
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
    
    protected $primaryKey = 'id_courrier';
}
