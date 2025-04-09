<?php

namespace App\Http\Controllers;

use App\Models\WorkoutPlan;
use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkoutPlanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // The middleware is already defined in the routes/web.php file
        // so we don't need to repeat it here
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workoutPlans = WorkoutPlan::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
            
        return view('splitify.workout-plans.index', compact('workoutPlans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $exercises = Exercise::orderBy('name')->get();
        return view('splitify.workout-plans.create', compact('exercises'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|integer|min:1|max:52',
            'exercises_validation' => 'required',
            'exercises' => 'required|array',
            'exercises.*' => 'exists:exercises,id',
            'day' => 'required|array',
            'day.*' => 'integer|min:1|max:7'
        ]);

        $workoutPlan = new WorkoutPlan();
        $workoutPlan->title = $validated['title'];
        $workoutPlan->description = $validated['description'];
        $workoutPlan->duration = $validated['duration'];
        $workoutPlan->user_id = Auth::id();
        $workoutPlan->save();

        // Attach exercises with pivot data
        if (isset($validated['exercises'])) {
            $days = $request->day;
            
            // Group exercises by day
            $exercisesByDay = [];
            foreach ($request->exercises as $index => $exerciseId) {
                $day = $days[$index] ?? 1; // Default to day 1 if day not specified
                
                if (!isset($exercisesByDay[$day])) {
                    $exercisesByDay[$day] = [];
                }
                
                $exercisesByDay[$day][] = [
                    'exercise_id' => $exerciseId,
                    'sets' => $request->sets[$index] ?? 3,
                    'reps' => $request->reps[$index] ?? 10,
                    'rest' => $request->rest[$index] ?? 60,
                    'order' => count($exercisesByDay[$day]) + 1
                ];
            }
            
            // Create splits for each day and attach exercises
            foreach ($exercisesByDay as $day => $exercises) {
                $split = $workoutPlan->splits()->create([
                    'name' => 'Day ' . $day,
                    'description' => 'Workout for day ' . $day,
                    'day_of_week' => $day,
                    'order' => $day
                ]);
                
                foreach ($exercises as $exerciseData) {
                    $split->exercises()->attach($exerciseData['exercise_id'], [
                        'sets' => $exerciseData['sets'],
                        'reps' => $exerciseData['reps'],
                        'rest_period' => $exerciseData['rest'],
                        'order' => $exerciseData['order']
                    ]);
                }
            }
        }

        return redirect()
            ->route('workout-plans.show', $workoutPlan)
            ->with('success', 'Workout plan created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkoutPlan $workoutPlan)
    {
        $this->authorize('view', $workoutPlan);
        
        // Get all workout splits with their exercises
        $splits = $workoutPlan->splits()->with(['exercises' => function($query) {
            $query->orderBy('split_exercise.order', 'asc');
        }])->orderBy('day_of_week', 'asc')->get();
        
        // Calculate some stats for the view
        $totalExercises = $splits->sum(function($split) {
            return $split->exercises->count();
        });
        
        $totalTrainingDays = $splits->count();
        
        return view('splitify.workout-plans.show', compact('workoutPlan', 'splits', 'totalExercises', 'totalTrainingDays'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkoutPlan $workoutPlan)
    {
        $this->authorize('update', $workoutPlan);
        
        $exercises = Exercise::orderBy('name')->get();
        
        // Get exercises with their respective days
        $planExercises = [];
        $splits = $workoutPlan->splits()->with('exercises')->get();
        
        foreach ($splits as $split) {
            foreach ($split->exercises as $exercise) {
                // Add the day to each exercise
                $exercise->pivot->day = $split->day_of_week;
                $planExercises[] = $exercise;
            }
        }
        
        return view('splitify.workout-plans.edit', compact('workoutPlan', 'exercises', 'planExercises'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkoutPlan $workoutPlan)
    {
        $this->authorize('update', $workoutPlan);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|integer|min:1|max:52',
            'exercises' => 'required|array',
            'exercises.*' => 'exists:exercises,id',
            'day' => 'required|array',
            'day.*' => 'integer|min:1|max:7'
        ]);

        $workoutPlan->title = $validated['title'];
        $workoutPlan->description = $validated['description'];
        $workoutPlan->duration = $validated['duration'];
        $workoutPlan->save();

        // Sync exercises with pivot data
        if (isset($validated['exercises'])) {
            // Remove all existing splits and their exercises
            $workoutPlan->splits()->delete();
            
            // Group exercises by day
            $exercisesByDay = [];
            foreach ($request->exercises as $index => $exerciseId) {
                $day = $request->day[$index] ?? 1;
                
                if (!isset($exercisesByDay[$day])) {
                    $exercisesByDay[$day] = [];
                }
                
                $exercisesByDay[$day][] = [
                    'exercise_id' => $exerciseId,
                    'sets' => $request->sets[$index] ?? 3,
                    'reps' => $request->reps[$index] ?? 10,
                    'rest' => $request->rest[$index] ?? 60,
                    'order' => count($exercisesByDay[$day]) + 1
                ];
            }
            
            // Create splits for each day and attach exercises
            foreach ($exercisesByDay as $day => $exercises) {
                $split = $workoutPlan->splits()->create([
                    'name' => 'Day ' . $day,
                    'description' => 'Workout for day ' . $day,
                    'day_of_week' => $day,
                    'order' => $day
                ]);
                
                foreach ($exercises as $exerciseData) {
                    $split->exercises()->attach($exerciseData['exercise_id'], [
                        'sets' => $exerciseData['sets'],
                        'reps' => $exerciseData['reps'],
                        'rest_period' => $exerciseData['rest'],
                        'order' => $exerciseData['order']
                    ]);
                }
            }
        }

        return redirect()
            ->route('workout-plans.show', $workoutPlan)
            ->with('success', 'Workout plan updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkoutPlan $workoutPlan)
    {
        $this->authorize('delete', $workoutPlan);
        
        // Force delete since we're using soft deletes and tests expect the record to be completely gone
        $workoutPlan->forceDelete();

        return redirect()
            ->route('workout-plans.index')
            ->with('success', 'Workout plan deleted successfully!');
    }
}
