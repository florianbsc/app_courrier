<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Centre extends Model
{
    use HasFactory;
    protected $fillable = ['id_centre','nom_centre', 'adresse_centre', 'CP_centre', 'telephone_centre'];
    public $timestamps = false;
    protected $primaryKey = 'id_centre';
}
