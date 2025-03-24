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
            $table->foreignId('split_id')->constrained('workout_splits')->onDelete('cascade');
            $table->foreignId('exercise_id')->constrained('exercises');
            $table->integer('sets');
            $table->string('reps'); // Using string to accommodate ranges or time formats
            $table->string('rest_period');
            $table->integer('order');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['split_id', 'exercise_id']);
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
