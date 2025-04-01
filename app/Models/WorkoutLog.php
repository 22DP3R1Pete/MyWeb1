<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'workout_plan_id',
        'date',
        'notes',
        'completed_exercises',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get the user that owns the workout log.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the workout plan associated with the log.
     */
    public function workoutPlan()
    {
        return $this->belongsTo(WorkoutPlan::class);
    }

    /**
     * The exercises that belong to the workout log with performance data.
     */
    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'workout_log_exercise')
            ->withPivot('sets', 'reps', 'weight', 'notes')
            ->withTimestamps();
    }
}
