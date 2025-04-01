<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WorkoutPlan;
use Illuminate\Auth\Access\Response;

class WorkoutPlanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Any authenticated user can view workout plans
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, WorkoutPlan $workoutPlan): bool
    {
        return $user->id === $workoutPlan->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Any authenticated user can create workout plans
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, WorkoutPlan $workoutPlan): bool
    {
        return $user->id === $workoutPlan->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, WorkoutPlan $workoutPlan): bool
    {
        return $user->id === $workoutPlan->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, WorkoutPlan $workoutPlan): bool
    {
        return $user->id === $workoutPlan->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, WorkoutPlan $workoutPlan): bool
    {
        return $user->id === $workoutPlan->user_id;
    }
}
