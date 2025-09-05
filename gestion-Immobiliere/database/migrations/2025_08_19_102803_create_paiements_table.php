<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->string('paiement_id')->primary();
            $table->string('reference')->unique();
             $table->decimal('montant', 12, 2);
             $table->string('mois');
               $table->string('mode_paiement')->nullable(); // espèces, virement, mobile money

               $table->string('code_agence');
               $table->string('code_appartement');
               $table->string('code_locataire');
               $table->string('code_batiment');
               $table->string('code_location')->nullable();
               //clé etrangers
               $table->foreign('code_agence')->references('numero')->on('agences')->onDelete('cascade');
               $table->foreign('code_appartement')->references('code_appartement')->on('appartements')->onDelete('cascade');
               $table->foreign('code_locataire')->references('code_locataires')->on('locataires')->onDelete('cascade');
               $table->foreign('code_location')->references('code_location')->on('locations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
