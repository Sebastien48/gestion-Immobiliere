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
        Schema::create('locations', function (Blueprint $table) {
            $table->string('code_location')->primary();
            $table->string('periode');

            $table->decimal('caution');
            $table->string('code_agence');
            $table->string('code_locataire');
            $table->string('code_batiment');
            $table->string('code_appartement');
            $table->foreign('code_appartement')->references('code_appartement')->on('appartements')->onDelete('cascade');
            $table->foreign('code_agence')->references('numero')->on('agences')->onDelete('cascade');
            $table->string('statut');
            $table->foreign('code_locataire')->references('code_locataires')->on('locataires')->onDelete('cascade');
            $table->string('contrat_document');
            $table->foreign('code_batiment')->references('code_batiment')->on('batiments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
