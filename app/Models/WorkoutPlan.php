<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkoutPlan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'duration',
        'image',
        'user_id',
    ];

    protected $casts = [
        'duration' => 'integer',
    ];

    /**
     * Get the user who created this plan.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the splits for this plan.
     */
    public function splits()
    {
        return $this->hasMany(WorkoutSplit::class, 'plan_id');
    }

    /**
     * Get users subscribed to this plan.
     */
    public function subscribers()
    {
        return $this->belongsToMany(User::class, 'user_plan_subscriptions', 'plan_id', 'user_id')
            ->withPivot('start_date', 'status', 'current_week')
            ->withTimestamps();
    }

    /**
     * Get subscriptions for this plan.
     */
    public function subscriptions()
    {
        return $this->hasMany(UserPlanSubscription::class, 'plan_id');
    }

    /**
     * Get exercises for this workout plan (used for fetching exercises).
     */
    public function exercises()
    {
        // Using hasManyThrough to fetch exercises via workout_splits
        return $this->hasManyThrough(
            Exercise::class,
            WorkoutSplit::class,
            'plan_id', // Foreign key on workout_splits table
            'id',      // Foreign key on exercises table (via split_exercises) 
            'id',      // Local key on workout_plans table
            'id'       // Local key on workout_splits table
        );
    }
    
    /**
     * Temporary method to handle attaching/detaching exercises
     * This is needed to maintain compatibility with the controller that 
     * expects a belongsToMany relationship with attach/detach methods
     */
    public function exercisesRelation()
    {
        // For now, we'll create a temporary split for each workout plan
        // This is not ideal but will maintain compatibility with the existing controller
        return $this->belongsToMany(Exercise::class, 'split_exercise', 'split_id', 'exercise_id')
            ->withPivot('sets', 'reps', 'rest_period as rest', 'order', 'notes')
            ->withTimestamps()
            ->using(SplitExercise::class);
    }
}
