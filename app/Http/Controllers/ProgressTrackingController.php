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
        
        // Apply search if provided
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('notes', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('workoutPlan', function($q2) use ($searchTerm) {
                      $q2->where('title', 'like', '%' . $searchTerm . '%');
                  });
            });
        }
        
        // Get the logs ordered by date
        $logs = $query->with('workoutPlan', 'exercises')
            ->orderBy('date', 'desc')
            ->paginate(10)
            ->withQueryString();
            
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
    public function create(Request $request)
    {
        $workoutPlans = WorkoutPlan::where('user_id', Auth::id())->get();
        $exercises = Exercise::orderBy('name')->get();
        
        // Check if workout_plan_id is specified in the request
        $selectedPlanId = $request->input('workout_plan_id');
        
        // Initialize planExercises as null
        $planExercises = null;
        
        // If a workout plan is selected, get its exercises
        if ($selectedPlanId) {
            $workoutPlan = WorkoutPlan::findOrFail($selectedPlanId);
            
            // Make sure this plan belongs to the user
            if ($workoutPlan->user_id === Auth::id()) {
                // Get unique exercises used in this workout plan through splits
                $planExercises = $workoutPlan->splits()
                    ->with('exercises')
                    ->get()
                    ->pluck('exercises')
                    ->flatten()
                    ->unique('id')
                    ->values();
            }
        }
        
        return view('splitify.progress.create', compact('workoutPlans', 'exercises', 'selectedPlanId', 'planExercises'));
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
            'weight.*' => 'required|numeric|min:0|max:1000',
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
    public function show(WorkoutLog $progress)
    {
        // Make sure the log belongs to the user
        if ($progress->user_id !== Auth::id()) {
            return redirect()->route('progress.index')->with('error', 'Unauthorized access to this workout log.');
        }
        
        // Load relationships
        $progress->load('workoutPlan', 'exercises');
        
        // Get previous logs for comparison
        $previousLogs = WorkoutLog::where('user_id', Auth::id())
            ->where('workout_plan_id', $progress->workout_plan_id)
            ->where('date', '<', $progress->date)
            ->orderBy('date', 'desc')
            ->limit(1)
            ->with('exercises')
            ->get();
            
        return view('splitify.progress.show', compact('progress', 'previousLogs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkoutLog $progress)
    {
        // Make sure the log belongs to the user
        if ($progress->user_id !== Auth::id()) {
            return redirect()->route('progress.index')->with('error', 'Unauthorized access to this workout log.');
        }
        
        $workoutPlans = WorkoutPlan::where('user_id', Auth::id())->get();
        $exercises = Exercise::orderBy('name')->get();
        $logExercises = $progress->exercises;
        
        return view('splitify.progress.edit', compact('progress', 'workoutPlans', 'exercises', 'logExercises'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkoutLog $progress)
    {
        // Make sure the log belongs to the user
        if ($progress->user_id !== Auth::id()) {
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
            'weight.*' => 'required|numeric|min:0|max:1000',
            'completed' => 'nullable|boolean'
        ]);
        
        // Make sure the workout plan belongs to the user
        $workoutPlan = WorkoutPlan::findOrFail($validated['workout_plan_id']);
        if ($workoutPlan->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized access to this workout plan.');
        }
        
        // Update the workout log
        $progress->workout_plan_id = $validated['workout_plan_id'];
        $progress->date = $validated['date'];
        $progress->notes = $validated['notes'] ?? null;
        $progress->completed_exercises = count($validated['exercises']);
        $progress->completed = $request->has('completed');
        $progress->save();
        
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
        $progress->exercises()->sync($exercisesData);
        
        return redirect()
            ->route('progress.show', $progress)
            ->with('success', 'Workout log updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkoutLog $progress)
    {
        // Make sure the log belongs to the user
        if ($progress->user_id !== Auth::id()) {
            return redirect()->route('progress.index')->with('error', 'Unauthorized access to this workout log.');
        }
        
        // Detach exercises
        $progress->exercises()->detach();
        
        // Delete the log
        $progress->delete();
        
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
