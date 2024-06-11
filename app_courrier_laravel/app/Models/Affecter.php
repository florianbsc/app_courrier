<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affecter extends Model
    {
        use HasFactory;
        protected $table = 'affecters';
        protected $fillable = ['id_service', 'id_user'];
        protected $primaryKey = ['id_service', 'id_user'];
        public $timestamps = false;


        public function user()
        {
            return $this->belongsTo(User::class, 'id_user', 'id_user');
        }
        
        public function service()
        {
            return $this->belongsTo(Service::class, 'id_service', 'id_service');
        }
    }

  