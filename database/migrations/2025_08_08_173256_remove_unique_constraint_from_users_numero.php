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
        Schema::table('users', function (Blueprint $table) {
            // Supprimer la contrainte unique sur numero
            $table->dropUnique(['numero']);
            
            // Supprimer la clé étrangère sur numero
            $table->dropForeign(['numero']);
            
            // Supprimer la colonne numero car elle n'est plus nécessaire
            $table->dropColumn('numero');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Recréer la colonne numero
            $table->string('numero')->unique();
            
            // Recréer la clé étrangère
            $table->foreign('numero')
                ->references('numero')
                ->on('agences')
                ->onDelete('cascade');
        });
    }
};
