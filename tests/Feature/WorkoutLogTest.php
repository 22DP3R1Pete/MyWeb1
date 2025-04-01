<?php

namespace Tests\Feature;

use App\Models\Exercise;
use App\Models\User;
use App\Models\WorkoutLog;
use App\Models\WorkoutPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WorkoutLogTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test that the workout logs index page requires authentication.
     *
     * @return void
     */
    public function test_workout_logs_index_requires_authentication()
    {
        $response = $this->get(route('workout-logs.index'));
        
        $response->assertRedirect(route('login'));
    }
    
    /**
     * Test that an authenticated user can see the workout logs index page.
     *
     * @return void
     */
    public function test_authenticated_user_can_see_workout_logs_index()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
                         ->get(route('workout-logs.index'));
        
        $response->assertStatus(200)
                 ->assertViewIs('splitify.workout-logs.index');
    }
    
    /**
     * Test that a user can create a new workout log.
     *
     * @return void
     */
    public function test_user_can_create_workout_log()
    {
        $user = User::factory()->create();
        $exercise = Exercise::factory()->create(['user_id' => $user->id]);
        
        $workoutLogData = [
            'workout_date' => now()->format('Y-m-d'),
            'duration' => 60,
            'intensity' => 'medium',
            'notes' => 'Test workout log',
            'exercises' => [
                [
                    'exercise_id' => $exercise->id,
                    'sets' => 3,
                    'reps' => 10,
                    'weight' => 50,
                    'completed' => 1
                ]
            ]
        ];
        
        $response = $this->actingAs($user)
                         ->post(route('workout-logs.store'), $workoutLogData);
        
        $response->assertRedirect(route('workout-logs.index'));
        
        $this->assertDatabaseHas('workout_logs', [
            'workout_date' => now()->format('Y-m-d'),
            'duration' => 60,
            'user_id' => $user->id
        ]);
        
        $workoutLog = WorkoutLog::where('user_id', $user->id)->first();
        
        $this->assertDatabaseHas('exercise_workout_log', [
            'workout_log_id' => $workoutLog->id,
            'exercise_id' => $exercise->id,
            'sets' => 3,
            'reps' => 10,
            'weight' => 50
        ]);
    }
    
    /**
     * Test that a user can create a workout log linked to a workout plan.
     *
     * @return void
     */
    public function test_user_can_create_workout_log_from_plan()
    {
        $user = User::factory()->create();
        $workoutPlan = WorkoutPlan::factory()->create(['user_id' => $user->id]);
        $exercise = Exercise::factory()->create(['user_id' => $user->id]);
        
        // Attach the exercise to the workout plan
        $workoutPlan->exercises()->attach($exercise->id, [
            'day' => 1,
            'sets' => 4,
            'reps' => 8,
            'rest' => 60
        ]);
        
        $workoutLogData = [
            'workout_date' => now()->format('Y-m-d'),
            'duration' => 45,
            'intensity' => 'high',
            'notes' => 'Test workout log from plan',
            'workout_plan_id' => $workoutPlan->id,
            'exercises' => [
                [
                    'exercise_id' => $exercise->id,
                    'sets' => 4,
                    'reps' => 8,
                    'weight' => 60,
                    'completed' => 1
                ]
            ]
        ];
        
        $response = $this->actingAs($user)
                         ->post(route('workout-logs.store'), $workoutLogData);
        
        $response->assertRedirect(route('workout-logs.index'));
        
        $this->assertDatabaseHas('workout_logs', [
            'workout_date' => now()->format('Y-m-d'),
            'duration' => 45,
            'user_id' => $user->id,
            'workout_plan_id' => $workoutPlan->id
        ]);
    }
    
    /**
     * Test that a user can update their workout log.
     *
     * @return void
     */
    public function test_user_can_update_their_workout_log()
    {
        $user = User::factory()->create();
        $workoutLog = WorkoutLog::factory()->create(['user_id' => $user->id]);
        $exercise = Exercise::factory()->create(['user_id' => $user->id]);
        
        // Attach the exercise to the workout log
        $workoutLog->exercises()->attach($exercise->id, [
            'sets' => 3,
            'reps' => 10,
            'weight' => 50,
            'completed' => true
        ]);
        
        $updatedData = [
            'workout_date' => now()->subDay()->format('Y-m-d'),
            'duration' => 75,
            'intensity' => 'high',
            'notes' => 'Updated workout log',
            'exercises' => [
                [
                    'exercise_id' => $exercise->id,
                    'sets' => 4,
                    'reps' => 12,
                    'weight' => 55,
                    'completed' => 1
                ]
            ]
        ];
        
        $response = $this->actingAs($user)
                         ->put(route('workout-logs.update', $workoutLog), $updatedData);
        
        $response->assertRedirect(route('workout-logs.show', $workoutLog->fresh()));
        
        $this->assertDatabaseHas('workout_logs', [
            'id' => $workoutLog->id,
            'workout_date' => now()->subDay()->format('Y-m-d'),
            'duration' => 75,
            'intensity' => 'high',
            'notes' => 'Updated workout log'
        ]);
        
        $this->assertDatabaseHas('exercise_workout_log', [
            'workout_log_id' => $workoutLog->id,
            'exercise_id' => $exercise->id,
            'sets' => 4,
            'reps' => 12,
            'weight' => 55
        ]);
    }
    
    /**
     * Test that a user can't update another user's workout log.
     *
     * @return void
     */
    public function test_user_cannot_update_another_users_workout_log()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $workoutLog = WorkoutLog::factory()->create(['user_id' => $user1->id]);
        
        $updatedData = [
            'workout_date' => now()->format('Y-m-d'),
            'duration' => 90,
            'intensity' => 'low',
            'notes' => 'Attempted update by another user'
        ];
        
        $response = $this->actingAs($user2)
                         ->put(route('workout-logs.update', $workoutLog), $updatedData);
        
        $response->assertStatus(403); // Forbidden
        
        $this->assertDatabaseMissing('workout_logs', [
            'id' => $workoutLog->id,
            'notes' => 'Attempted update by another user'
        ]);
    }
    
    /**
     * Test that a user can delete their workout log.
     *
     * @return void
     */
    public function test_user_can_delete_their_workout_log()
    {
        $user = User::factory()->create();
        $workoutLog = WorkoutLog::factory()->create(['user_id' => $user->id]);
        
        $response = $this->actingAs($user)
                         ->delete(route('workout-logs.destroy', $workoutLog));
        
        $response->assertRedirect(route('workout-logs.index'));
        
        $this->assertDatabaseMissing('workout_logs', [
            'id' => $workoutLog->id
        ]);
    }
    
    /**
     * Test that a user can't delete another user's workout log.
     *
     * @return void
     */
    public function test_user_cannot_delete_another_users_workout_log()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $workoutLog = WorkoutLog::factory()->create(['user_id' => $user1->id]);
        
        $response = $this->actingAs($user2)
                         ->delete(route('workout-logs.destroy', $workoutLog));
        
        $response->assertStatus(403); // Forbidden
        
        $this->assertDatabaseHas('workout_logs', [
            'id' => $workoutLog->id
        ]);
    }
    
    /**
     * Test that a user can view their own workout log details.
     *
     * @return void
     */
    public function test_user_can_view_their_workout_log()
    {
        $user = User::factory()->create();
        $workoutLog = WorkoutLog::factory()->create(['user_id' => $user->id]);
        
        $response = $this->actingAs($user)
                         ->get(route('workout-logs.show', $workoutLog));
        
        $response->assertStatus(200)
                 ->assertViewIs('splitify.workout-logs.show')
                 ->assertViewHas('workoutLog', $workoutLog);
    }
    
    /**
     * Test that a user can't view another user's workout log.
     *
     * @return void
     */
    public function test_user_cannot_view_another_users_workout_log()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $workoutLog = WorkoutLog::factory()->create(['user_id' => $user1->id]);
        
        $response = $this->actingAs($user2)
                         ->get(route('workout-logs.show', $workoutLog));
        
        $response->assertStatus(403); // Forbidden
    }
    
    /**
     * Test that workout log validation works correctly.
     *
     * @return void
     */
    public function test_workout_log_validation()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
                         ->post(route('workout-logs.store'), [
                             'workout_date' => '',
                             'duration' => 'not-a-number',
                             'intensity' => 'invalid-intensity'
                         ]);
        
        $response->assertSessionHasErrors(['workout_date', 'duration', 'intensity']);
    }
} 