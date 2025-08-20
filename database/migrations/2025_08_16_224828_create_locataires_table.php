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
        Schema::create('locataires', function (Blueprint $table) {
            $table->string('code_locataires')->primary();
            $table->string('nom') ;
            $table->string('prenom');
            $table->string('telephone');
            $table->string('email')->unique();
            $table->string('nationalité');
            $table->date('date_naissance');
            $table->string('profession');
            $table->string('adresse');
            $table->string('photo_identite');
            
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locataires');
    }
};
