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
            Schema::create('users', function (Blueprint $table) {
            $table->string('code', 5)->primary();
            $table->string('nom');
            $table->string('prenom');
            $table->string('telephone');
            $table->string('nomAgence');
            $table->string('role')->default('utilisateur');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('numero')->unique(); // Doit correspondre au type dans la table agences
            
            // Clé étrangère
            $table->foreign('numero')
                ->references('numero')
                ->on('agences')
                ->onDelete('cascade');
            
            $table->timestamps(); // Gardez si vous voulez les timestamps
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
        $table->string('id')->primary();
        $table->string('user_id')->nullable(); // Modifier en string
        $table->string('ip_address', 45)->nullable();
        $table->text('user_agent')->nullable();
        $table->longText('payload');
        $table->integer('last_activity')->index();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
