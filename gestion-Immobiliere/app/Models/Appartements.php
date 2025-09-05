<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appartements extends Model
{
    protected $table = 'appartements';
    protected $primaryKey = 'code_appartement';
    public $incrementing = false; // car la PK n'est pas auto-incrémentée
    protected $keyType = 'string';

    protected $fillable = [
        'code_appartement',
        'numero',
        'superficie',
        'loyer_mensuel',
        'statut',
        'code_batiment',
        'capacite'
    ];

   
    public function batiment() {
    return $this->belongsTo(Batiments::class, 'code_batiment', 'code_batiment');
}
}
