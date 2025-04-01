<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\WorkoutLog;
use App\Models\WorkoutPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkoutLog>
 */
class WorkoutLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WorkoutLog::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'workout_date' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'duration' => $this->faker->numberBetween(30, 120),
            'intensity' => $this->faker->randomElement(['low', 'medium', 'high']),
            'notes' => $this->faker->optional(0.7)->paragraph(),
            'user_id' => User::factory(),
            'workout_plan_id' => $this->faker->optional(0.6)->passthrough(
                WorkoutPlan::factory()
            ),
        ];
    }

    /**
     * Configure the model factory to create a workout log with high intensity.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function highIntensity()
    {
        return $this->state(function (array $attributes) {
            return [
                'intensity' => 'high',
            ];
        });
    }

    /**
     * Configure the model factory to create a workout log with medium intensity.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function mediumIntensity()
    {
        return $this->state(function (array $attributes) {
            return [
                'intensity' => 'medium',
            ];
        });
    }

    /**
     * Configure the model factory to create a workout log with low intensity.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function lowIntensity()
    {
        return $this->state(function (array $attributes) {
            return [
                'intensity' => 'low',
            ];
        });
    }

    /**
     * Configure the model factory to create a workout log for a specific workout plan.
     *
     * @param WorkoutPlan $workoutPlan
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function forWorkoutPlan(WorkoutPlan $workoutPlan)
    {
        return $this->state(function (array $attributes) use ($workoutPlan) {
            return [
                'workout_plan_id' => $workoutPlan->id,
                'user_id' => $workoutPlan->user_id,
            ];
        });
    }
} 