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
        // Only create the table if it doesn't already exist
        if (!Schema::hasTable('workout_plans')) {
            Schema::create('workout_plans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users');
                $table->string('title');
                $table->text('description')->nullable();
                $table->integer('duration_weeks');
                $table->integer('sessions_per_week');
                $table->json('goals')->nullable();
                $table->boolean('is_public')->default(false);
                $table->boolean('is_template')->default(false);
                $table->json('metadata')->nullable();
                $table->timestamps();
                $table->softDeletes();
                
                $table->index(['user_id', 'is_public']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_plans');
    }
};
