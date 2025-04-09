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
        Schema::create('workout_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('difficulty_level');
            $table->integer('duration_weeks');
            $table->integer('sessions_per_week');
            $table->json('goals')->nullable();
            $table->boolean('is_public')->default(false);
            $table->boolean('is_template')->default(false);
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'is_public']);
            $table->index('difficulty_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_plans');
    }
};
