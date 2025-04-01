<?php

namespace Database\Factories;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exercise>
 */
class ExerciseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Exercise::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $muscleGroups = [
            'Chest', 'Back', 'Shoulders', 'Arms', 'Legs', 'Core', 'Full Body', 'Cardio'
        ];
        
        $equipment = [
            'None', 'Dumbbells', 'Barbell', 'Kettlebell', 'Machine', 'Cable', 'Resistance Band', 'Other'
        ];
        
        return [
            'name' => $this->faker->unique()->words(rand(2, 4), true),
            'muscle_group' => $this->faker->randomElement($muscleGroups),
            'equipment' => $this->faker->randomElement($equipment),
            'instructions' => $this->faker->paragraph(),
            'user_id' => User::factory(),
        ];
    }

    /**
     * Configure the model factory to create an exercise with a specific muscle group.
     *
     * @param string $muscleGroup
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function forMuscleGroup(string $muscleGroup)
    {
        return $this->state(function (array $attributes) use ($muscleGroup) {
            return [
                'muscle_group' => $muscleGroup,
            ];
        });
    }

    /**
     * Configure the model factory to create an exercise with specific equipment.
     *
     * @param string $equipment
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withEquipment(string $equipment)
    {
        return $this->state(function (array $attributes) use ($equipment) {
            return [
                'equipment' => $equipment,
            ];
        });
    }

    /**
     * Configure the model factory to create a bodyweight exercise.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function bodyweight()
    {
        return $this->state(function (array $attributes) {
            return [
                'equipment' => 'None',
            ];
        });
    }
}
