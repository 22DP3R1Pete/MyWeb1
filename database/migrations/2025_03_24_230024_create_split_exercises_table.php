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
        Schema::create('split_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_plan_id')->constrained('workout_plans');
            $table->foreignId('exercise_id')->constrained('exercises');
            $table->string('split_name');
            $table->integer('order')->default(0);
            $table->integer('sets')->default(3);
            $table->integer('reps')->default(12);
            $table->decimal('weight', 8, 2)->nullable();
            $table->integer('rest_time')->nullable(); // in seconds
            $table->json('notes')->nullable();
            $table->timestamps();
            
            $table->index(['workout_plan_id', 'split_name']);
            $table->index('exercise_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('split_exercises');
    }
};
