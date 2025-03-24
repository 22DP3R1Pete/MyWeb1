<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exercise extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'muscle_group',
        'equipment_needed',
        'demo_url',
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
        return $this->hasMany(WorkoutLog::class);
    }
}
