<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'exercise_id',
        'split_exercise_id',
        'date',
        'sets_completed',
        'reps_completed',
        'weight_used',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'sets_completed' => 'integer',
        'weight_used' => 'decimal:2',
    ];

    /**
     * Get the user who logged the workout.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the exercise that was logged.
     */
    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    /**
     * Get the split exercise that was logged.
     */
    public function splitExercise()
    {
        return $this->belongsTo(SplitExercise::class);
    }
}
