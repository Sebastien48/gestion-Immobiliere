<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('agences', function (Blueprint $table) {
        $table->string('numero')->primary(); // Définit 'numero' comme clé primaire
        $table->string('nomAgence');
        $table->string('fondateur');
        $table->string('emailAgence')->unique();
        $table->string('adresse');
        $table->string('telephoneAgence');
        $table->string('logo')->nullable()->unique();
        $table->string('document')->nullable();
        $table->id();
        
        
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agences');
    }
};
