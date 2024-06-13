<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_user',
        'nom_user',
        'prenom_user',
        'mail_user',
        'password',
        'privilege_user',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
//     public function courriers() : HasMany
//     {
//         return $this->hasMany(Courrier::class);
//     }
    public $timestamps = false;
    protected $primaryKey = 'id_user';

    public function getAuthPassword()
        {
            return $this->attributes['password'];
        }

    public function username()
        {
            return 'mail_user';
        }


    // Définir la relation avec les services via la table 'affecters'
    public function services()
        {
            return $this->belongsToMany(Service::class, 'affecters', 'id_user', 'id_service');
        }

    // public function affecter()
    //     {
    //         return $this->hasOne(Affecter::class, 'id_user', 'id_service');
    //     }

    public static function inService($serviceAChecker) 
    {
        $user = auth()->user()->id_user;
        $affecterUsers = Affecter::select('*')
        ->where('id_user', '=', $user)
        ->whereAnd('id_service', '=', $serviceAChecker)
        ->groupBy('id_user')
        ->count();
        return $affecterUsers;

    }
}


// <?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Relations\BelongsToMany;
// use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;

// class User extends Authenticatable
// {
//     use HasApiTokens, HasFactory, Notifiable;

//     protected $fillable = [
//         'id_user',
//         'nom_user',
//         'prenom_user',
//         'mail_user',
//         'password',
//         'privilege_user',
//     ];

//     protected $hidden = [
//         'password',
//         'remember_token',
//     ];

//     protected $casts = [
//         'email_verified_at' => 'datetime',
//         'password' => 'hashed',
//     ];

//     public $timestamps = false;
//     protected $primaryKey = 'id_user';

//     public function getAuthPassword()
//     {
//         return $this->attributes['password'];
//     }

//     public function username()
//     {
//         return 'mail_user';
//     }


//     // Définir la relation avec les services via la table 'affecters'
//     public function services()
//     {
//         return $this->belongsToMany(Service::class, 'affecters', 'id_user', 'id_service');
//     }

//     public function courriers(): BelongsToMany
//     {
//         return $this->belongsToMany(Courrier::class, 'affecters', 'id_user', 'id_courrier');
//     }

//     public static function inService($serviceAChecker) 
//     {
//         $user = auth()->user()->id_user;
//         $affecterUsers = Affecter::select('*')
//             ->where('id_user', '=', $user)
//             ->where('id_service', '=', $serviceAChecker)
//             ->groupBy('id_user')
//             ->count();
//         return $affecterUsers;
//     }
// }
