<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkoutLog;
use App\Models\WorkoutPlan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show the dashboard with workout progress stats.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        // Get completed workouts for the last 4 weeks
        $completedWorkouts = WorkoutLog::where('user_id', $user->id)
            ->where('date', '>=', Carbon::now()->subWeeks(4))
            ->where('completed', true)
            ->orderBy('date', 'desc')
            ->with(['workoutPlan', 'exercises'])
            ->get();

        // Calculate weekly workouts
        $currentWeekWorkouts = $completedWorkouts->filter(function($log) {
            return $log->date->isCurrentWeek();
        })->count();

        // Calculate planned workouts per week (default to 5 if no plans)
        $userPlans = WorkoutPlan::where('user_id', $user->id)->get();
        $plannedWorkoutsPerWeek = $userPlans->count() > 0 ? $userPlans->count() : 5;
        
        // Calculate weekly progress percentage
        $weeklyProgress = $plannedWorkoutsPerWeek > 0 
            ? min(100, ($currentWeekWorkouts / $plannedWorkoutsPerWeek) * 100) 
            : 0;

        // Calculate total volume lifted
        $totalVolume = 0;
        foreach ($completedWorkouts as $log) {
            foreach ($log->exercises as $exercise) {
                $totalVolume += $exercise->pivot->sets * $exercise->pivot->reps * $exercise->pivot->weight;
            }
        }

        // Calculate volume change from previous week
        $currentWeekVolume = $this->calculateVolumeForDateRange(
            $completedWorkouts, 
            Carbon::now()->startOfWeek(), 
            Carbon::now()->endOfWeek()
        );
        
        $previousWeekVolume = $this->calculateVolumeForDateRange(
            $completedWorkouts, 
            Carbon::now()->subWeek()->startOfWeek(), 
            Carbon::now()->subWeek()->endOfWeek()
        );
        
        $volumeChangePercentage = $previousWeekVolume > 0 
            ? round((($currentWeekVolume - $previousWeekVolume) / $previousWeekVolume) * 100, 1)
            : 0;

        // Calculate workout streak
        $streakData = $this->calculateStreak($user->id);
        $currentStreak = $streakData['current_streak'];

        // Calculate plan completion percentage
        $planCompletionPercentage = $this->calculatePlanCompletion($user->id);

        // Get recent workouts for display
        $recentWorkouts = $completedWorkouts->take(5);

        return view('splitify.dashboard', compact(
            'currentWeekWorkouts',
            'plannedWorkoutsPerWeek',
            'weeklyProgress',
            'totalVolume',
            'volumeChangePercentage',
            'currentStreak',
            'streakData',
            'planCompletionPercentage',
            'recentWorkouts'
        ));
    }

    /**
     * Calculate the volume lifted within a specific date range.
     *
     * @param \Illuminate\Support\Collection $logs
     * @param \Carbon\Carbon $startDate
     * @param \Carbon\Carbon $endDate
     * @return float
     */
    private function calculateVolumeForDateRange($logs, $startDate, $endDate)
    {
        $volume = 0;
        $logsInRange = $logs->filter(function($log) use ($startDate, $endDate) {
            return $log->date->between($startDate, $endDate);
        });

        foreach ($logsInRange as $log) {
            foreach ($log->exercises as $exercise) {
                $volume += $exercise->pivot->sets * $exercise->pivot->reps * $exercise->pivot->weight;
            }
        }

        return $volume;
    }

    /**
     * Calculate the user's current workout streak.
     *
     * @param int $userId
     * @return array
     */
    private function calculateStreak($userId)
    {
        // Get all workout logs ordered by date
        $logs = WorkoutLog::where('user_id', $userId)
            ->where('completed', true)
            ->orderBy('date', 'desc')
            ->get()
            ->groupBy(function($log) {
                return $log->date->format('Y-m-d');
            });

        $currentStreak = 0;
        $today = Carbon::today();
        $maxStreak = 0;

        // Check if there's a workout today to start the streak
        if ($logs->has($today->format('Y-m-d'))) {
            $currentStreak = 1;
            $checkDate = $today->copy()->subDay();

            // Count consecutive days with workouts
            while ($logs->has($checkDate->format('Y-m-d'))) {
                $currentStreak++;
                $checkDate->subDay();
            }
        } else {
            // If no workout today, check if there was one yesterday
            $checkDate = $today->copy()->subDay();
            if ($logs->has($checkDate->format('Y-m-d'))) {
                $currentStreak = 1;
                $checkDate->subDay();

                // Count consecutive days with workouts
                while ($logs->has($checkDate->format('Y-m-d'))) {
                    $currentStreak++;
                    $checkDate->subDay();
                }
            }
        }

        // Calculate last 7 days for streak display
        $last7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $last7Days[] = [
                'date' => $date->format('Y-m-d'),
                'has_workout' => $logs->has($date->format('Y-m-d'))
            ];
        }

        return [
            'current_streak' => $currentStreak,
            'last_7_days' => $last7Days
        ];
    }

    /**
     * Calculate the user's plan completion percentage.
     *
     * @param int $userId
     * @return int
     */
    private function calculatePlanCompletion($userId)
    {
        // Get active workout plans - removing the completed_at filter since it doesn't exist
        $activePlans = WorkoutPlan::where('user_id', $userId)
            ->get();

        if ($activePlans->isEmpty()) {
            return 0;
        }

        $totalCompletionPercentage = 0;
        
        foreach ($activePlans as $plan) {
            // Get total exercises in the plan
            $totalExercises = 0;
            foreach ($plan->splits as $split) {
                $totalExercises += $split->exercises->count();
            }
            
            if ($totalExercises === 0) {
                continue;
            }

            // Get completed exercises for this plan
            $completedLogs = WorkoutLog::where('user_id', $userId)
                ->where('workout_plan_id', $plan->id)
                ->where('completed', true)
                ->get();
                
            $completedExercises = 0;
            foreach ($completedLogs as $log) {
                $completedExercises += $log->completed_exercises;
            }

            // Calculate completion percentage for this plan
            $planPercentage = min(100, ($completedExercises / $totalExercises) * 100);
            $totalCompletionPercentage += $planPercentage;
        }

        // Average completion percentage across all plans
        return round($totalCompletionPercentage / $activePlans->count());
    }
}
