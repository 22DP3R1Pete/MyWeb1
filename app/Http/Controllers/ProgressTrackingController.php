<?php

namespace App\Http\Controllers;

use App\Models\WorkoutLog;
use App\Models\WorkoutPlan;
use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProgressTrackingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // The middleware is already defined in the routes/web.php file
    // so we don't need to repeat it here
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $timeframe = $request->input('timeframe', 'month');
        $planId = $request->input('workout_plan', 'all');
        
        // Get the user's workout logs
        $query = WorkoutLog::query()->where('user_id', Auth::id());
        
        // Apply filters
        if ($timeframe === 'week') {
            $query->where('date', '>=', Carbon::now()->subWeek());
        } elseif ($timeframe === 'month') {
            $query->where('date', '>=', Carbon::now()->subMonth());
        } elseif ($timeframe === 'year') {
            $query->where('date', '>=', Carbon::now()->subYear());
        }
        
        if ($planId !== 'all') {
            $query->where('workout_plan_id', $planId);
        }
        
        // Get the logs ordered by date
        $logs = $query->with('workoutPlan', 'exercises')
            ->orderBy('date', 'desc')
            ->paginate(10);
            
        // Get workout plans for the filter dropdown
        $workoutPlans = WorkoutPlan::where('user_id', Auth::id())->get();
        
        // Get stats
        $totalWorkouts = $query->count();
        
        // Get total exercises completed - handle missing column gracefully
        $totalExercises = 0;
        try {
            $totalExercises = $query->sum('completed_exercises') ?: 0;
        } catch (\Exception $e) {
            // If there's an error with the column, just use 0
            $totalExercises = 0;
        }
        
        $streakData = $this->calculateStreak();
        
        return view('splitify.progress.index', compact(
            'logs', 
            'workoutPlans', 
            'timeframe', 
            'planId', 
            'totalWorkouts', 
            'totalExercises',
            'streakData'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $workoutPlans = WorkoutPlan::where('user_id', Auth::id())->get();
        $exercises = Exercise::orderBy('name')->get();
        
        return view('splitify.progress.create', compact('workoutPlans', 'exercises'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'workout_plan_id' => 'required|exists:workout_plans,id',
            'date' => 'required|date|before_or_equal:today',
            'notes' => 'nullable|string',
            'exercises' => 'required|array',
            'exercises.*' => 'exists:exercises,id',
            'sets.*' => 'required|integer|min:1',
            'reps.*' => 'required|integer|min:1',
            'weight.*' => 'required|numeric|min:0',
            'completed' => 'nullable|boolean'
        ]);
        
        // Make sure the workout plan belongs to the user
        $workoutPlan = WorkoutPlan::findOrFail($validated['workout_plan_id']);
        if ($workoutPlan->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized access to this workout plan.');
        }
        
        // Create the workout log
        $log = new WorkoutLog();
        $log->user_id = Auth::id();
        $log->workout_plan_id = $validated['workout_plan_id'];
        $log->date = $validated['date'];
        $log->notes = $validated['notes'] ?? null;
        $log->completed_exercises = count($validated['exercises']);
        $log->completed = $request->has('completed');
        $log->save();
        
        // Attach exercises with their performance data
        $exercisesData = [];
        foreach ($request->exercises as $index => $exerciseId) {
            $exercisesData[$exerciseId] = [
                'sets' => $request->sets[$index],
                'reps' => $request->reps[$index],
                'weight' => $request->weight[$index],
                'notes' => $request->exercise_notes[$index] ?? null,
            ];
        }
        $log->exercises()->attach($exercisesData);
        
        return redirect()
            ->route('progress.show', $log)
            ->with('success', 'Workout logged successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkoutLog $workoutLog)
    {
        // Make sure the log belongs to the user
        if ($workoutLog->user_id !== Auth::id()) {
            return redirect()->route('progress.index')->with('error', 'Unauthorized access to this workout log.');
        }
        
        // Load relationships
        $workoutLog->load('workoutPlan', 'exercises');
        
        // Get previous logs for comparison
        $previousLogs = WorkoutLog::where('user_id', Auth::id())
            ->where('workout_plan_id', $workoutLog->workout_plan_id)
            ->where('date', '<', $workoutLog->date)
            ->orderBy('date', 'desc')
            ->limit(1)
            ->with('exercises')
            ->get();
            
        return view('splitify.progress.show', compact('workoutLog', 'previousLogs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkoutLog $workoutLog)
    {
        // Make sure the log belongs to the user
        if ($workoutLog->user_id !== Auth::id()) {
            return redirect()->route('progress.index')->with('error', 'Unauthorized access to this workout log.');
        }
        
        $workoutPlans = WorkoutPlan::where('user_id', Auth::id())->get();
        $exercises = Exercise::orderBy('name')->get();
        $logExercises = $workoutLog->exercises;
        
        return view('splitify.progress.edit', compact('workoutLog', 'workoutPlans', 'exercises', 'logExercises'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkoutLog $workoutLog)
    {
        // Make sure the log belongs to the user
        if ($workoutLog->user_id !== Auth::id()) {
            return redirect()->route('progress.index')->with('error', 'Unauthorized access to this workout log.');
        }
        
        $validated = $request->validate([
            'workout_plan_id' => 'required|exists:workout_plans,id',
            'date' => 'required|date|before_or_equal:today',
            'notes' => 'nullable|string',
            'exercises' => 'required|array',
            'exercises.*' => 'exists:exercises,id',
            'sets.*' => 'required|integer|min:1',
            'reps.*' => 'required|integer|min:1',
            'weight.*' => 'required|numeric|min:0',
            'completed' => 'nullable|boolean'
        ]);
        
        // Make sure the workout plan belongs to the user
        $workoutPlan = WorkoutPlan::findOrFail($validated['workout_plan_id']);
        if ($workoutPlan->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized access to this workout plan.');
        }
        
        // Update the workout log
        $workoutLog->workout_plan_id = $validated['workout_plan_id'];
        $workoutLog->date = $validated['date'];
        $workoutLog->notes = $validated['notes'] ?? null;
        $workoutLog->completed_exercises = count($validated['exercises']);
        $workoutLog->completed = $request->has('completed');
        $workoutLog->save();
        
        // Sync exercises with their performance data
        $exercisesData = [];
        foreach ($request->exercises as $index => $exerciseId) {
            $exercisesData[$exerciseId] = [
                'sets' => $request->sets[$index],
                'reps' => $request->reps[$index],
                'weight' => $request->weight[$index],
                'notes' => $request->exercise_notes[$index] ?? null,
            ];
        }
        $workoutLog->exercises()->sync($exercisesData);
        
        return redirect()
            ->route('progress.show', $workoutLog)
            ->with('success', 'Workout log updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkoutLog $workoutLog)
    {
        // Make sure the log belongs to the user
        if ($workoutLog->user_id !== Auth::id()) {
            return redirect()->route('progress.index')->with('error', 'Unauthorized access to this workout log.');
        }
        
        // Detach exercises
        $workoutLog->exercises()->detach();
        
        // Delete the log
        $workoutLog->delete();
        
        return redirect()
            ->route('progress.index')
            ->with('success', 'Workout log deleted successfully!');
    }
    
    /**
     * Calculate the user's current workout streak.
     */
    private function calculateStreak()
    {
        $logs = WorkoutLog::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->pluck('date')
            ->map(function ($date) {
                return Carbon::parse($date)->format('Y-m-d');
            });
            
        if ($logs->isEmpty()) {
            return [
                'current_streak' => 0,
                'longest_streak' => 0
            ];
        }
        
        // Check if there's a workout today
        $today = Carbon::today()->format('Y-m-d');
        $hasWorkoutToday = $logs->contains($today);
        
        // Calculate current streak
        $currentStreak = $hasWorkoutToday ? 1 : 0;
        $checkDate = $hasWorkoutToday ? Carbon::yesterday() : Carbon::today();
        
        while (true) {
            $dateString = $checkDate->format('Y-m-d');
            if ($logs->contains($dateString)) {
                $currentStreak++;
                $checkDate->subDay();
            } else {
                break;
            }
        }
        
        // Calculate longest streak
        $uniqueDates = $logs->unique()->values()->toArray();
        $longestStreak = 0;
        $currentCount = 1;
        
        for ($i = 0; $i < count($uniqueDates) - 1; $i++) {
            $current = Carbon::parse($uniqueDates[$i]);
            $next = Carbon::parse($uniqueDates[$i + 1]);
            
            if ($current->diffInDays($next) === 1) {
                $currentCount++;
            } else {
                $longestStreak = max($longestStreak, $currentCount);
                $currentCount = 1;
            }
        }
        
        $longestStreak = max($longestStreak, $currentCount);
        
        return [
            'current_streak' => $currentStreak,
            'longest_streak' => $longestStreak
        ];
    }
}
