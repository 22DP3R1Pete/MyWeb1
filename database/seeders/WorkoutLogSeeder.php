<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\User;
use App\Models\WorkoutLog;
use App\Models\WorkoutPlan;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class WorkoutLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get a user to assign workout logs to
        $user = User::first();
        if (!$user) {
            $this->command->info('No users found. Please run UserSeeder first.');
            return;
        }

        // Get a workout plan to associate with logs
        $workoutPlan = WorkoutPlan::first();
        if (!$workoutPlan) {
            $this->command->info('No workout plans found. Please run WorkoutPlanSeeder first.');
            return;
        }

        // Get some exercises to associate with logs
        $exercises = Exercise::take(3)->get();
        if ($exercises->isEmpty()) {
            $this->command->info('No exercises found. Please run ExerciseSeeder first.');
            return;
        }

        // Create a few sample workout logs
        for ($i = 0; $i < 5; $i++) {
            $log = WorkoutLog::create([
                'user_id' => $user->id,
                'workout_plan_id' => $workoutPlan->id,
                'date' => Carbon::now()->subDays($i * 2),
                'completed' => true,
                'completed_exercises' => $exercises->count(),
                'notes' => "Sample workout log #" . ($i + 1),
            ]);

            // Attach exercises with random performance data
            foreach ($exercises as $exercise) {
                $log->exercises()->attach($exercise->id, [
                    'sets' => rand(3, 5),
                    'reps' => rand(8, 12),
                    'weight' => rand(50, 200) / 2,
                    'notes' => 'Sample exercise notes',
                ]);
            }
        }

        $this->command->info('Sample workout logs created successfully.');
    }
} 