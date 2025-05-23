<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'admin' => 'boolean',
        ];
    }

    /**
     * Get the user's age.
     */
    public function getAgeAttribute()
    {
        if (!$this->birth_year) {
            return null;
        }
        
        return date('Y') - $this->birth_year;
    }

    /**
     * Get workout plans created by this user.
     */
    public function createdWorkoutPlans()
    {
        return $this->hasMany(WorkoutPlan::class, 'created_by');
    }

    /**
     * Get plan subscriptions for this user.
     */
    public function planSubscriptions()
    {
        return $this->hasMany(UserPlanSubscription::class);
    }

    /**
     * Get plans that this user is subscribed to.
     */
    public function subscribedPlans()
    {
        return $this->belongsToMany(WorkoutPlan::class, 'user_plan_subscriptions', 'user_id', 'plan_id')
            ->withPivot('start_date', 'status', 'current_week')
            ->withTimestamps();
    }

    /**
     * Get workout logs for this user.
     */
    public function workoutLogs()
    {
        return $this->hasMany(WorkoutLog::class);
    }
}
