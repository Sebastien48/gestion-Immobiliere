<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Batiments extends Model
{
    //
    use HasFactory;
    protected$primary ='code_batiment';
    // Assuming 'code_batiment' is the primary key
    protected$table='batiments';
    public $incrementing = false;

    protected $keyType = 'string';

    // The attributes that are mass assignable
    protected $fillable = [
        'code_batiment', 'nom','proprietaire', 'adresse', 'nombre_Appartements','description', 'code_agence', 'user_id', 'status',      ];
    // The attributes that should be hidden for arrays
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    // Relation avec l'agence
    public function agence()
    {
        return $this->belongsTo(Agence::class, 'code_agence', 'numero');
    }

    // Relation avec les utilisateurs
    public function users()
    {
        return $this->belongsTo(User::class, 'code_batiment', 'code');
    }
    // Générer un code unique pour le bâtiment lors de la création
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($batiment) {
            if (empty($batiment->code_batiment)) {
                $batiment->code_batiment = (String) Str::uuid(); // Génère un UUID comme code
            }
        });
    }

}

