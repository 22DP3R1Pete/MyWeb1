<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutSplit extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'name',
        'description',
        'day_of_week',
        'order',
    ];

    protected $casts = [
        'day_of_week' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Get the workout plan that this split belongs to.
     */
    public function plan()
    {
        return $this->belongsTo(WorkoutPlan::class, 'plan_id');
    }

    /**
     * Get the exercises in this split.
     */
    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'split_exercises', 'split_id', 'exercise_id')
            ->withPivot('sets', 'reps', 'rest_period', 'order', 'notes')
            ->withTimestamps();
    }

    /**
     * Get the split exercises for this split.
     */
    public function splitExercises()
    {
        return $this->hasMany(SplitExercise::class, 'split_id');
    }
}
