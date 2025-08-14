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
        $table->string('code_batiment')->primary();
        $table->string('nom')->nullable();
        $table->string('proprietaire');
        $table->integer('nombre_Appartements');
        $table->string('adresse');
        $table->string('description')->nullable();
        $table->string('code_agence');
        $table->foreign('code_agence')->references('numero')->on('agences')->onDelete('cascade');
        $table->string('status')->default('actif');
        $table->string('user_id');
        $table->foreign('user_id')->references('code')->on('users')->onDelete('cascade');
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
