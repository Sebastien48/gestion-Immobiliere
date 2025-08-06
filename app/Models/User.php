<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Authenticatable
{
    use Notifiable;
    use HasUuids;
    // Spécifiez que 'code' est la clé primaire
    protected $primaryKey = 'code';

    // Indiquez que la clé primaire n'est pas auto-incrémentée
    public $incrementing = false;

    // Spécifiez le type de la clé primaire
    protected $keyType = 'string';

    // Les attributs qui sont assignables en masse
    protected $fillable = [
        'code', 'nom', 'prenom', 'telephone', 'nomAgence', 'role', 'email', 'password', 'numero'
    ];

    // Les attributs qui doivent être cachés pour les tableaux
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Les attributs qui doivent être convertis en types natifs
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Générer un code unique pour l'utilisateur lors de la création
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->code)) {
                $user->code = Str::random(5); // Génère un UUID comme code
            }
        });
    }
}
