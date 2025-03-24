<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\WorkoutPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkoutPlan>
 */
class WorkoutPlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $difficultyLevels = ['Beginner', 'Intermediate', 'Advanced'];
        
        return [
            'name' => $this->faker->unique()->words(rand(2, 4), true) . ' Plan',
            'description' => $this->faker->paragraph(),
            'difficulty_level' => $this->faker->randomElement($difficultyLevels),
            'duration' => $this->faker->numberBetween(4, 12),
            'image' => $this->faker->randomElement([$this->faker->imageUrl(), null]),
            'created_by' => User::inRandomOrder()->first()->id ?? User::factory(),
        ];
    }
}
