<?php

namespace Tests\Feature;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExerciseTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test that the exercise index page requires authentication.
     *
     * @return void
     */
    public function test_exercise_index_requires_authentication()
    {
        $response = $this->get(route('exercises.index'));
        
        $response->assertRedirect(route('login'));
    }
    
    /**
     * Test that an authenticated user can see the exercises index page.
     *
     * @return void
     */
    public function test_authenticated_user_can_see_exercises_index()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
                         ->get(route('exercises.index'));
        
        $response->assertStatus(200)
                 ->assertViewIs('splitify.exercises.index');
    }
    
    /**
     * Test that a user can create a new exercise.
     *
     * @return void
     */
    public function test_user_can_create_exercise()
    {
        $user = User::factory()->create();
        
        $exerciseData = [
            'name' => 'Bench Press',
            'muscle_group' => 'Chest',
            'equipment' => 'Barbell',
            'difficulty' => 'intermediate',
            'instructions' => 'Lie on the bench, lower the bar to your chest, and press up.',
            'notes' => 'Keep elbows at 45 degrees'
        ];
        
        $response = $this->actingAs($user)
                         ->post(route('exercises.store'), $exerciseData);
        
        $response->assertRedirect(route('exercises.index'));
        
        $this->assertDatabaseHas('exercises', [
            'name' => 'Bench Press',
            'user_id' => $user->id
        ]);
    }
    
    /**
     * Test that a user can update their exercise.
     *
     * @return void
     */
    public function test_user_can_update_their_exercise()
    {
        $user = User::factory()->create();
        $exercise = Exercise::factory()->create(['user_id' => $user->id]);
        
        $updatedData = [
            'name' => 'Updated Exercise Name',
            'muscle_group' => $exercise->muscle_group,
            'equipment' => $exercise->equipment,
            'difficulty' => $exercise->difficulty,
        ];
        
        $response = $this->actingAs($user)
                         ->put(route('exercises.update', $exercise), $updatedData);
        
        $response->assertRedirect(route('exercises.show', $exercise->fresh()));
        
        $this->assertDatabaseHas('exercises', [
            'id' => $exercise->id,
            'name' => 'Updated Exercise Name'
        ]);
    }
    
    /**
     * Test that a user can't update another user's exercise.
     *
     * @return void
     */
    public function test_user_cannot_update_another_users_exercise()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $exercise = Exercise::factory()->create(['user_id' => $user1->id]);
        
        $updatedData = [
            'name' => 'Updated Exercise Name',
            'muscle_group' => $exercise->muscle_group,
            'equipment' => $exercise->equipment,
            'difficulty' => $exercise->difficulty,
        ];
        
        $response = $this->actingAs($user2)
                         ->put(route('exercises.update', $exercise), $updatedData);
        
        $response->assertStatus(403); // Forbidden
        
        $this->assertDatabaseMissing('exercises', [
            'id' => $exercise->id,
            'name' => 'Updated Exercise Name'
        ]);
    }
    
    /**
     * Test that a user can delete their exercise.
     *
     * @return void
     */
    public function test_user_can_delete_their_exercise()
    {
        $user = User::factory()->create();
        $exercise = Exercise::factory()->create(['user_id' => $user->id]);
        
        $response = $this->actingAs($user)
                         ->delete(route('exercises.destroy', $exercise));
        
        $response->assertRedirect(route('exercises.index'));
        
        $this->assertDatabaseMissing('exercises', [
            'id' => $exercise->id
        ]);
    }
    
    /**
     * Test that a user can't delete another user's exercise.
     *
     * @return void
     */
    public function test_user_cannot_delete_another_users_exercise()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $exercise = Exercise::factory()->create(['user_id' => $user1->id]);
        
        $response = $this->actingAs($user2)
                         ->delete(route('exercises.destroy', $exercise));
        
        $response->assertStatus(403); // Forbidden
        
        $this->assertDatabaseHas('exercises', [
            'id' => $exercise->id
        ]);
    }
    
    /**
     * Test that a user can view their own exercise details.
     *
     * @return void
     */
    public function test_user_can_view_their_exercise()
    {
        $user = User::factory()->create();
        $exercise = Exercise::factory()->create(['user_id' => $user->id]);
        
        $response = $this->actingAs($user)
                         ->get(route('exercises.show', $exercise));
        
        $response->assertStatus(200)
                 ->assertViewIs('splitify.exercises.show')
                 ->assertViewHas('exercise', $exercise);
    }
    
    /**
     * Test that exercise validation works correctly.
     *
     * @return void
     */
    public function test_exercise_validation()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
                         ->post(route('exercises.store'), [
                             'name' => '',
                             'muscle_group' => '',
                         ]);
        
        $response->assertSessionHasErrors(['name', 'muscle_group']);
    }
} 