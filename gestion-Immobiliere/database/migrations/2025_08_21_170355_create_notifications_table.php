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
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            // --- Important! --- //
            // Remplace morphs() pour autoriser notifiable_id string/uuid
            $table->string('notifiable_id');
            $table->string('notifiable_type');
            // ------------------ //
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            // Eventuelle index composite optimisé :
            $table->index(['notifiable_type', 'notifiable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};