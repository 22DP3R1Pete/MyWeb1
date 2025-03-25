<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'height' => fake()->randomFloat(2, 150, 210), // Height in cm
            'weight' => fake()->randomFloat(2, 50, 120), // Weight in kg
            'birth_year' => fake()->numberBetween(1960, 2005), // Birth year (18-63 years old)
            'fitness_goals' => fake()->randomElement([
                'Weight loss',
                'Muscle gain',
                'Strength building',
                'Endurance improvement',
                'General fitness',
                'Flexibility',
                null
            ]),
            'admin' => false,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
