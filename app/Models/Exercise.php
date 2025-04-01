<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exercise extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'muscle_group',
        'equipment',
        'instructions',
        'media_url',
    ];

    /**
     * Get the workout splits that include this exercise.
     */
    public function workoutSplits()
    {
        return $this->belongsToMany(WorkoutSplit::class, 'split_exercises', 'exercise_id', 'split_id')
            ->withPivot('sets', 'reps', 'rest_period', 'order', 'notes')
            ->withTimestamps();
    }

    /**
     * Get the split exercises for this exercise.
     */
    public function splitExercises()
    {
        return $this->hasMany(SplitExercise::class, 'exercise_id');
    }

    /**
     * Get the workout logs for this exercise.
     */
    public function workoutLogs()
    {
        return $this->belongsToMany(WorkoutLog::class, 'workout_log_exercise')
            ->withPivot('sets', 'reps', 'weight', 'notes')
            ->withTimestamps();
    }

    /**
     * Get the workout plans that include this exercise.
     */
    public function workoutPlans()
    {
        return $this->belongsToMany(WorkoutPlan::class, 'split_exercise')
            ->withPivot('sets', 'reps', 'rest', 'day', 'order')
            ->withTimestamps();
    }
}
