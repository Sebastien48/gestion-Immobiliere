<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Locations extends Model
{
    use HasFactory;

    /**
     * Le nom de la clé primaire.
     *
     * @var string
     */
    protected $primaryKey = 'code_location';

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'locations';

    /**
     * Indique si la clé primaire est auto-incrémentée.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Le type de la clé primaire.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Les attributs assignables en masse.
     *
     * @var array
     */
    protected $fillable = [
        'code_location', 'periode', 'caution', 'statut', 'code_agence', 'code_batiment', 'code_locataire','contrat_document','code_appartement',
    ];

    /**
     * Les attributs cachés lors de la conversion en tableau ou JSON.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    // Relations

    public function agence()
    {
        return $this->belongsTo(Agence::class, 'code_agence', 'numero');
    }

    public function batiment()
    {
        return $this->belongsTo(Batiments::class, 'code_batiment', 'code_batiment');
    }

   public function appartement() { return $this->belongsTo(Appartements::class, 'code_appartement', 'code_appartement'); }
   
   public function locataire() {
    return $this->belongsTo(Locataires::class,'code_locataire','code_locataires');
   }
}