<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ['nom_service', 'telephone_service'];
    public $timestamps = false;
    protected $primaryKey = 'id_service';

}
