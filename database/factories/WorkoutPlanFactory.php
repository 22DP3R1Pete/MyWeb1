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
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WorkoutPlan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'duration_weeks' => $this->faker->numberBetween(1, 12),
            'difficulty_level' => $this->faker->randomElement(['beginner', 'intermediate', 'advanced']),
            'user_id' => User::factory(),
            'sessions_per_week' => $this->faker->numberBetween(3, 6),
            'is_public' => false,
            'is_template' => false,
        ];
    }

    /**
     * Indicate that the workout plan is for a beginner.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function beginner()
    {
        return $this->state(function (array $attributes) {
            return [
                'difficulty_level' => 'beginner',
            ];
        });
    }

    /**
     * Indicate that the workout plan is for an intermediate user.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function intermediate()
    {
        return $this->state(function (array $attributes) {
            return [
                'difficulty_level' => 'intermediate',
            ];
        });
    }

    /**
     * Indicate that the workout plan is for an advanced user.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function advanced()
    {
        return $this->state(function (array $attributes) {
            return [
                'difficulty_level' => 'advanced',
            ];
        });
    }
}
