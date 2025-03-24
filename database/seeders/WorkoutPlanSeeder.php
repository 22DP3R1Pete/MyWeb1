<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\SplitExercise;
use App\Models\User;
use App\Models\WorkoutPlan;
use App\Models\WorkoutSplit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkoutPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create exercises
        $exercises = Exercise::factory(30)->create();
        
        // Create workout plans with splits and exercises
        WorkoutPlan::factory(5)->create()->each(function ($plan) use ($exercises) {
            // Create 3-6 splits per plan
            $splitCount = rand(3, 6);
            
            for ($i = 1; $i <= $splitCount; $i++) {
                $split = WorkoutSplit::create([
                    'plan_id' => $plan->id,
                    'name' => $this->getSplitName($i, $splitCount),
                    'description' => "Day $i of this workout plan",
                    'day_of_week' => $i % 7,
                    'order' => $i,
                ]);
                
                // Add 4-8 exercises to each split
                $splitExercises = $exercises->random(rand(4, 8));
                
                foreach ($splitExercises as $index => $exercise) {
                    SplitExercise::create([
                        'split_id' => $split->id,
                        'exercise_id' => $exercise->id,
                        'sets' => rand(3, 5),
                        'reps' => $this->getRandomReps(),
                        'rest_period' => $this->getRandomRestPeriod(),
                        'order' => $index + 1,
                        'notes' => rand(0, 1) ? "Focus on form for this exercise" : null,
                    ]);
                }
            }
            
            // Subscribe some users to plans
            $users = User::inRandomOrder()->take(rand(1, 5))->get();
            
            foreach ($users as $user) {
                $user->subscribedPlans()->attach($plan->id, [
                    'start_date' => now()->subDays(rand(0, 30)),
                    'status' => $this->getRandomStatus(),
                    'current_week' => rand(1, $plan->duration),
                ]);
            }
        });
    }
    
    private function getSplitName($day, $totalDays)
    {
        if ($totalDays <= 3) {
            $splits = ['Push Day', 'Pull Day', 'Leg Day'];
            return $splits[($day - 1) % 3];
        } else {
            $splits = ['Chest & Triceps', 'Back & Biceps', 'Shoulders & Arms', 'Legs', 'Full Body', 'Core & Cardio'];
            return $splits[($day - 1) % 6];
        }
    }
    
    private function getRandomReps()
    {
        $repTypes = [
            '8-12', '10-15', '12-15', '6-8', '15-20', 
            '30 seconds', '45 seconds', '60 seconds'
        ];
        
        return $repTypes[array_rand($repTypes)];
    }
    
    private function getRandomRestPeriod()
    {
        $restPeriods = [
            '30 seconds', '45 seconds', '60 seconds', 
            '90 seconds', '2 minutes', '3 minutes'
        ];
        
        return $restPeriods[array_rand($restPeriods)];
    }
    
    private function getRandomStatus()
    {
        $statuses = ['active', 'completed', 'paused'];
        $weights = [70, 20, 10];
        
        return $this->weightedRandom($statuses, $weights);
    }
    
    private function weightedRandom($items, $weights)
    {
        $totalWeight = array_sum($weights);
        $randomNumber = mt_rand(1, $totalWeight);
        
        $currentWeight = 0;
        foreach ($items as $index => $item) {
            $currentWeight += $weights[$index];
            if ($randomNumber <= $currentWeight) {
                return $item;
            }
        }
        
        return $items[0]; // Fallback
    }
}
