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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
