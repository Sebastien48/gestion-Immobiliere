<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agence extends Model
{
    // Model logic goes here
     use HasFactory;
          // Assuming 'numero' is the primary key
     protected$primary ='numero'; 
     protected$table='agences';


      public $incrementing = false;


      protected $keyType = 'string';

    // The attributes that are mass assignable
    protected $fillable = [
        'numero', 'nomAgence', 'fondateur', 'emailAgence', 'adresse', 'telephoneAgence', 'logo', 'document'
    ];
    
    // The attributes that should be hidden for arrays
    protected $hidden = [
        'created_at', 'updated_at',
    ];
    // Relation avec les bâtiments respectant de plusieurs à plusieurs
    public function batiments()
    {
        return $this->hasMany(Batiments::class, 'code_agence', 'numero');
    }

    // Relation avec les utilisateurs
    public function users()
    {
        return $this->hasMany(User::class, 'numero', 'numero');
    }
}
