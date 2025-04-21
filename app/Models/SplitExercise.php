<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SplitExercise extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'split_exercises';

    protected $fillable = [
        'split_id',
        'exercise_id',
        'sets',
        'reps',
        'rest_period',
        'order',
        'notes',
    ];

    protected $casts = [
        'sets' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Get the split that this exercise belongs to.
     */
    public function split()
    {
        return $this->belongsTo(WorkoutSplit::class, 'split_id');
    }

    /**
     * Get the exercise for this split exercise.
     */
    public function exercise()
    {
        return $this->belongsTo(Exercise::class, 'exercise_id');
    }

    /**
     * Get the workout logs for this split exercise.
     */
    public function workoutLogs()
    {
        return $this->hasMany(WorkoutLog::class);
    }
}
