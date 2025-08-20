<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quittances', function (Blueprint $table) {
            $table->string('id_quittance')->primary();
            
            // clé étrangère vers paiements
            $table->string('code_paiement');
            $table->foreign('code_paiement')
                  ->references('paiement_id')
                  ->on('paiements')
                  ->cascadeOnDelete(); // si tu veux que la quittance disparaisse si le paiement est supprimé

            $table->date('date_creation')->useCurrent(); // valeur par défaut = aujourd'hui
            $table->timestamps(); // created_at et updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quittances');
    }
};
