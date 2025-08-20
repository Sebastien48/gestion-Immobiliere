<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quittances extends Model
{
    use HasFactory;

    protected $table = 'quittances';
    protected $primaryKey = 'id_quittance';
    public $incrementing = false; // car ta clé n'est pas un auto-incrément
    protected $keyType = 'string';

    protected $fillable = [
        'id_quittance',
        'code_paiement',
        'date_creation',
    ];

    /**
     * Relation avec Paiement
     * Une quittance appartient à un paiement
     */
    public function paiement()
    {
        return $this->belongsTo(Paiements::class, 'code_paiement', 'paiement_id');
    }
}
