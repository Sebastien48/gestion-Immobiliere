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
       Schema::create('appartements', function (Blueprint $table) {
    $table->string('code_appartement')->primary();
    $table->string('numero');
    $table->decimal('superficie', 12, 2); // ou integer si tu ne veux que des entiers
    $table->decimal('loyer_mensuel', 10, 2);
    $table->string('statut')->default('libre');
    $table->string('code_batiment');
    $table->string('capacite')->nullable();
    $table->timestamps();

    $table->foreign('code_batiment')
        ->references('code_batiment')
        ->on('batiments')
        ->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appartements');
    }
};
