<?php

namespace Database\Factories;

use App\Models\Exercise;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exercise>
 */
class ExerciseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $muscleGroups = ['Chest', 'Back', 'Shoulders', 'Legs', 'Arms', 'Core', 'Full Body'];
        $equipment = ['Barbell', 'Dumbbell', 'Machine', 'Bodyweight', 'Cable', 'Kettlebell', null];

        return [
            'name' => $this->faker->unique()->words(rand(2, 4), true),
            'description' => $this->faker->paragraph(),
            'muscle_group' => $this->faker->randomElement($muscleGroups),
            'equipment_needed' => $this->faker->randomElement($equipment),
            'demo_url' => $this->faker->randomElement([$this->faker->url(), null]),
        ];
    }
}
