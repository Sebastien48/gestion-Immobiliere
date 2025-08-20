<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Paiements extends Model
{
    //
    protected $primaryKey = 'paiment_id';
    protected $table= 'paiements';

    public $incrementing = false;
     protected $keyType = 'string';
     protected $fillable =[
        'paiement_id','reference','montant','mois','mode_paiement','code_agence','code_batiment','code_appartement','code_locataire','code_location',
        'statut',
     ];
     protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function agence():BelongsTo
    {
                return $this->belongsTo(Agence::class, 'code_agence', 'numero');
    }

    public function batiment():BelongsTo
    {
        return  $this->belongsTo(Batiments::class, 'code_batiment', 'code_batiment');
    }

    public function appartement():BelongsTo
    {
        return $this->belongsTo(Appartements::class,'code_apartement','code_appartement');

    }


    public function locataire():BelongsTo
    {
        return $this->belongsTo(Locataires::class,'code_locataire','code_locataires');
    }

    public function location():BelongsTo
    {
        return $this ->belongsTo(Locations::class,'code_location','code_location');
    }

    public function quittance():HasOne
    {
         return $this ->hasOne(Quittances::class,'code_paiement','paiement_id');
    }
   
}
