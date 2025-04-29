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
        // Create workout_plans table if it doesn't exist
        if (!Schema::hasTable('workout_plans')) {
            Schema::create('workout_plans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users');
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('difficulty_level');
                $table->integer('duration_weeks');
                $table->integer('sessions_per_week');
                $table->json('goals')->nullable();
                $table->boolean('is_public')->default(false);
                $table->boolean('is_template')->default(false);
                $table->json('metadata')->nullable();
                $table->timestamps();
                $table->softDeletes();
                
                $table->index(['user_id', 'is_public']);
                $table->index('difficulty_level');
            });
        }
        
        // Only create the table if it doesn't already exist
        if (!Schema::hasTable('workout_logs')) {
            Schema::create('workout_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users');
                $table->foreignId('workout_plan_id')->nullable()->constrained('workout_plans');
                $table->date('date');
                $table->boolean('completed')->default(false);
                $table->integer('completed_exercises')->default(0);
                $table->text('notes')->nullable();
                $table->timestamps();
                
                $table->index(['user_id', 'date']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_logs');
        // Don't drop workout_plans as it might be used by other tables
    }
}; 