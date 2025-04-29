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
        // Check if exercises table exists, if not create it
        if (!Schema::hasTable('exercises')) {
            Schema::create('exercises', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users');
                $table->string('name');
                $table->text('description')->nullable();
                $table->string('muscle_group');
                $table->string('equipment_needed')->nullable();
                $table->string('difficulty_level');
                $table->string('video_url')->nullable();
                $table->string('image_url')->nullable();
                $table->text('instructions')->nullable();
                $table->boolean('is_custom')->default(false);
                $table->timestamps();
                $table->softDeletes();
                
                $table->index('muscle_group');
                $table->index('user_id');
            });
        }
        
        Schema::create('workout_log_exercise', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_log_id')->constrained()->onDelete('cascade');
            $table->foreignId('exercise_id')->constrained()->onDelete('cascade');
            $table->integer('sets')->default(1);
            $table->integer('reps')->default(1);
            $table->decimal('weight', 8, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Ensure each exercise is only added once per workout log
            $table->unique(['workout_log_id', 'exercise_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_log_exercise');
        // Don't drop exercises table here as it might be used by other tables
    }
}; 