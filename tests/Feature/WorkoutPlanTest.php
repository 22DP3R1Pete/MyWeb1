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
        
        $planData = [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'difficulty' => 'intermediate',
            'duration' => 8,
            'exercises' => [],
        ];
        
        $response = $this->actingAs($user)->post(route('workout-plans.store'), $planData);
        $response->assertRedirect();
        
        $this->assertDatabaseHas('workout_plans', [
            'title' => $planData['title'],
            'user_id' => $user->id,
        ]);
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
