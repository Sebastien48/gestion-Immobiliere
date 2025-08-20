<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Ajouter la colonne numero comme nullable d'abord
            $table->string('numero')->nullable()->after('telephone');
        });
        
        // Récupérer le premier numero d'agence disponible
        $firstAgence = DB::table('agences')->first();
        $defaultNumero = $firstAgence ? $firstAgence->numero : null;
        
        if ($defaultNumero) {
            // Mettre à jour les utilisateurs existants avec le numero de la première agence
            DB::table('users')->update(['numero' => $defaultNumero]);
        }
        
        // Maintenant rendre la colonne non nullable
        Schema::table('users', function (Blueprint $table) {
            $table->string('numero')->nullable(false)->change();
        });
        
        // Ajouter la clé étrangère
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('numero')
                ->references('numero')
                ->on('agences')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Supprimer la clé étrangère
            $table->dropForeign(['numero']);
            
            // Supprimer la colonne numero
            $table->dropColumn('numero');
        });
    }
};
