<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPlanSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'start_date',
        'status',
        'current_week',
    ];

    protected $casts = [
        'start_date' => 'date',
        'current_week' => 'integer',
    ];

    /**
     * Get the user who subscribed to the plan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the plan that the user subscribed to.
     */
    public function plan()
    {
        return $this->belongsTo(WorkoutPlan::class, 'plan_id');
    }
}
