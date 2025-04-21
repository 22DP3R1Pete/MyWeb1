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
            $table->foreignId('exercise_id')->constrained('exercises')->onDelete('cascade');
            $table->integer('sets')->default(3);
            $table->integer('reps')->default(10);
            $table->integer('rest_period')->nullable(); // in seconds
            $table->integer('order')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('split_id');
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
