<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Locataires extends Model
{
    // use HasFactory;

    /**
     * La clé primaire du modèle.
     *
     * @var string
     */
    protected $primaryKey = 'code_locataires';

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'locataires';

    /**
     * Le type de la clé primaire.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indique si la clé primaire est auto-incrémentée.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Les attributs assignables en masse.
     *
     * @var array
     */
    protected $fillable = [
        'code_locataires', 'nom', 'prenom', 'telephone', 'email', 'nationalité',
        'date_naissance', 'profession', 'adresse', 'photo_identite', 'code_agence',
    ];

    /**
     * Les attributs cachés lors de la conversion en tableau ou JSON.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    /**
     * Relation : locataire → agence.
     */
    public function agence(): BelongsTo
    {
        return $this->belongsTo(Agence::class, 'code_agence', 'numero');
    }

    /**
     * Relation : locataire → locations (plusieurs).
     */
    public function locations(): HasMany
    {
        // Clé étrangère sur locations = code_locataires, local = code_locataires (avec S)
        return $this->hasMany(Locations::class, 'code_locataire', 'code_locataires');
    }
}