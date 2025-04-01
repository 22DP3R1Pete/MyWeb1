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
    }
};
