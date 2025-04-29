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
        // Only create the table if it doesn't exist
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
    }
};
