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
        Schema::table('exercises', function (Blueprint $table) {
            // Check if description column exists
            if (Schema::hasColumn('exercises', 'description')) {
                // Rename description to instructions
                $table->renameColumn('description', 'instructions');
            } else if (!Schema::hasColumn('exercises', 'instructions')) {
                // Add instructions if neither exists
                $table->text('instructions')->after('name');
            }
            
            // Check for equipment_needed and rename if needed
            if (Schema::hasColumn('exercises', 'equipment_needed')) {
                $table->renameColumn('equipment_needed', 'equipment');
            } else if (!Schema::hasColumn('exercises', 'equipment')) {
                // Add equipment if it doesn't exist
                $table->string('equipment')->after('muscle_group');
            }
            
            // Add media_url if it doesn't exist
            if (!Schema::hasColumn('exercises', 'media_url')) {
                $table->string('media_url')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exercises', function (Blueprint $table) {
            if (Schema::hasColumn('exercises', 'instructions')) {
                $table->renameColumn('instructions', 'description');
            }
            
            if (Schema::hasColumn('exercises', 'equipment')) {
                $table->renameColumn('equipment', 'equipment_needed');
            }
            
            if (Schema::hasColumn('exercises', 'media_url')) {
                $table->dropColumn('media_url');
            }
        });
    }
};
