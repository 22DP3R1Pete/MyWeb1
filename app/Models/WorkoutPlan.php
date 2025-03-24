<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkoutPlan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'difficulty_level',
        'duration',
        'image',
        'created_by',
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
}
