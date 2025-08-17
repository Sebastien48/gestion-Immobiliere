<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
class Locataires extends Model
{
    //use HasFactory
    protected$primary= 'code_locataire';

    protected$table= 'locataires';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable =[
        'code_locataires','nom','prenom','telephone','email','nationalité',
        'date_naissance','profession','adresse','photo_identite','code_agence',
    ];

    protected $hidden = [
        'create_at','updated_at',
    ];

// relation de de locataires à  l'agence
 public function agence()
    {
        return $this->belongsTo(Agence::class, 'code_agence', 'numero');
    }
}
