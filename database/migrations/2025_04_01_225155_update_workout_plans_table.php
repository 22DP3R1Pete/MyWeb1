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
        Schema::table('workout_plans', function (Blueprint $table) {
            // Check if created_by column exists and rename to user_id
            if (Schema::hasColumn('workout_plans', 'created_by')) {
                $table->renameColumn('created_by', 'user_id');
            } else if (!Schema::hasColumn('workout_plans', 'user_id')) {
                // Add user_id if neither exists
                $table->foreignId('user_id')->constrained('users');
            }
            
            // Check if name column exists and rename to title
            if (Schema::hasColumn('workout_plans', 'name')) {
                $table->renameColumn('name', 'title');
            } else if (!Schema::hasColumn('workout_plans', 'title')) {
                // Add title if neither exists
                $table->string('title')->after('id');
            }
            
            // Check if difficulty_level column exists and rename to difficulty
            if (Schema::hasColumn('workout_plans', 'difficulty_level')) {
                $table->renameColumn('difficulty_level', 'difficulty');
            } else if (!Schema::hasColumn('workout_plans', 'difficulty')) {
                // Add difficulty if neither exists
                $table->string('difficulty')->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workout_plans', function (Blueprint $table) {
            if (Schema::hasColumn('workout_plans', 'user_id')) {
                $table->renameColumn('user_id', 'created_by');
            }
            
            if (Schema::hasColumn('workout_plans', 'title')) {
                $table->renameColumn('title', 'name');
            }
            
            if (Schema::hasColumn('workout_plans', 'difficulty')) {
                $table->renameColumn('difficulty', 'difficulty_level');
            }
        });
    }
};
