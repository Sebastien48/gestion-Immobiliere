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
        Schema::create('batiments', function (Blueprint $table) {
            // Définit 'code_batiment' comme clé primaire
           $table->string('code_batiment')->primary();
           $table->string('nom');
           $table->string('adresse');
           $table->string('description');
            // lier 'code_batiment' à 'agences'
            $table->string('code_agence');
            $table->foreign('code_agence')
                ->references('numero')
                ->on('agences')
                ->onDelete('cascade');
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batiments');
    }
};
