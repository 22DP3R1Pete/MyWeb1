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
        Schema::create('workout_splits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained('workout_plans')->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->integer('day_of_week');
            $table->integer('order');
            $table->timestamps();
            
            $table->index('plan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_splits');
    }
};
