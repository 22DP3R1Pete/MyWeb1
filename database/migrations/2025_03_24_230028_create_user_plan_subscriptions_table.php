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
        Schema::create('user_plan_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('plan_id')->constrained('workout_plans');
            $table->date('start_date');
            $table->enum('status', ['active', 'completed', 'paused']);
            $table->integer('current_week');
            $table->timestamps();
            
            $table->index(['user_id', 'plan_id']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_plan_subscriptions');
    }
};
