<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WorkoutPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WorkoutPlanTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_workout_plans_page_requires_authentication()
    {
        $response = $this->get(route('workout-plans.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_see_workout_plans_page()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('workout-plans.index'));
        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_create_workout_plan()
    {
        $user = User::factory()->create();
        
        // Create some exercises in the database
        $exercise1 = \App\Models\Exercise::factory()->create(['name' => 'Bench Press', 'muscle_group' => 'Chest']);
        $exercise2 = \App\Models\Exercise::factory()->create(['name' => 'Squats', 'muscle_group' => 'Legs']);
        
        $planData = [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'difficulty' => 'intermediate',
            'duration' => 8,
            'exercises' => [$exercise1->id, $exercise2->id],
            'sets' => [3, 4],
            'reps' => [10, 12],
            'rest' => [60, 90],
            'day' => [1, 2],
        ];
        
        $response = $this->actingAs($user)->post(route('workout-plans.store'), $planData);
        $response->assertRedirect();
        
        $this->assertDatabaseHas('workout_plans', [
            'title' => $planData['title'],
            'user_id' => $user->id,
        ]);
        
        // Get the created workout plan
        $plan = WorkoutPlan::where('title', $planData['title'])->first();
        
        // Get the split and its exercises
        $split = $plan->splits()->first();
        $exercises = $split->exercises;
        
        // Check if exercises were attached correctly
        $this->assertCount(2, $exercises);
        
        // Check if specific exercises exist
        $exercise1InSplit = $exercises->where('id', $exercise1->id)->first();
        $exercise2InSplit = $exercises->where('id', $exercise2->id)->first();
        
        $this->assertNotNull($exercise1InSplit);
        $this->assertNotNull($exercise2InSplit);
        
        // Check exercise details
        $this->assertEquals(3, $exercise1InSplit->pivot->sets);
        $this->assertEquals(10, $exercise1InSplit->pivot->reps);
    }

    public function test_workout_plan_creation_with_array_notation()
    {
        $user = User::factory()->create();
        
        // Create some exercises in the database
        $exercise1 = \App\Models\Exercise::factory()->create(['name' => 'Deadlift', 'muscle_group' => 'Back']);
        $exercise2 = \App\Models\Exercise::factory()->create(['name' => 'Pull-ups', 'muscle_group' => 'Back']);
        
        $planData = [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'difficulty' => 'advanced',
            'duration' => 6,
            'exercises' => [$exercise1->id, $exercise2->id],
            'sets' => [5, 3],
            'reps' => [5, 8],
            'rest' => [120, 60],
            'day' => [1, 1],
        ];
        
        $response = $this->actingAs($user)->post(route('workout-plans.store'), $planData);
        $response->assertRedirect();
        
        $this->assertDatabaseHas('workout_plans', [
            'title' => $planData['title'],
            'user_id' => $user->id,
        ]);
        
        // Get the created workout plan
        $plan = WorkoutPlan::where('title', $planData['title'])->first();
        
        // Get the split and verify its day_of_week is 1
        $split = $plan->splits()->first();
        $this->assertEquals(1, $split->day_of_week);
        
        // Check that both exercises are attached to this split
        $this->assertCount(2, $split->exercises);
    }

    public function test_user_can_only_view_own_workout_plans()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        $plan1 = WorkoutPlan::factory()->create([
            'user_id' => $user1->id,
            'title' => 'User 1 Plan',
        ]);
        
        $plan2 = WorkoutPlan::factory()->create([
            'user_id' => $user2->id,
            'title' => 'User 2 Plan',
        ]);
        
        $response = $this->actingAs($user1)->get(route('workout-plans.index'));
        $response->assertSee('User 1 Plan');
        $response->assertDontSee('User 2 Plan');
    }

    public function test_user_can_delete_own_workout_plan()
    {
        $user = User::factory()->create();
        
        $plan = WorkoutPlan::factory()->create([
            'user_id' => $user->id,
        ]);
        
        $response = $this->actingAs($user)->delete(route('workout-plans.destroy', $plan));
        $response->assertRedirect();
        
        $this->assertDatabaseMissing('workout_plans', [
            'id' => $plan->id,
        ]);
    }
}
