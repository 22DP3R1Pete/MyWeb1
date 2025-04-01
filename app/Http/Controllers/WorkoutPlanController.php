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
            'difficulty' => 'required|string|in:beginner,intermediate,advanced',
            'duration' => 'required|integer|min:1|max:52',
            'exercises' => 'required|array',
            'exercises.*' => 'exists:exercises,id'
        ]);

        $workoutPlan = new WorkoutPlan();
        $workoutPlan->title = $validated['title'];
        $workoutPlan->description = $validated['description'];
        $workoutPlan->difficulty = $validated['difficulty'];
        $workoutPlan->duration = $validated['duration'];
        $workoutPlan->user_id = Auth::id();
        $workoutPlan->save();

        // Attach exercises with pivot data
        if (isset($validated['exercises'])) {
            $exercises = [];
            foreach ($request->exercises as $index => $id) {
                $exercises[$id] = [
                    'sets' => $request->sets[$index] ?? 3,
                    'reps' => $request->reps[$index] ?? 10,
                    'rest' => $request->rest[$index] ?? 60,
                    'day' => $request->day[$index] ?? 1,
                    'order' => $index + 1
                ];
            }
            $workoutPlan->exercises()->attach($exercises);
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
        
        $exercises = $workoutPlan->exercises()
            ->orderBy('day')
            ->orderBy('split_exercise.order')
            ->get();
            
        // Group exercises by day
        $exercisesByDay = $exercises->groupBy('pivot.day');
        
        return view('splitify.workout-plans.show', compact('workoutPlan', 'exercisesByDay'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkoutPlan $workoutPlan)
    {
        $this->authorize('update', $workoutPlan);
        
        $exercises = Exercise::orderBy('name')->get();
        $planExercises = $workoutPlan->exercises;
        
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
            'difficulty' => 'required|string|in:beginner,intermediate,advanced',
            'duration' => 'required|integer|min:1|max:52',
            'exercises' => 'required|array',
            'exercises.*' => 'exists:exercises,id'
        ]);

        $workoutPlan->title = $validated['title'];
        $workoutPlan->description = $validated['description'];
        $workoutPlan->difficulty = $validated['difficulty'];
        $workoutPlan->duration = $validated['duration'];
        $workoutPlan->save();

        // Sync exercises with pivot data
        if (isset($validated['exercises'])) {
            $workoutPlan->exercises()->detach();
            
            $exercises = [];
            foreach ($request->exercises as $index => $id) {
                $exercises[$id] = [
                    'sets' => $request->sets[$index] ?? 3,
                    'reps' => $request->reps[$index] ?? 10,
                    'rest' => $request->rest[$index] ?? 60,
                    'day' => $request->day[$index] ?? 1,
                    'order' => $index + 1
                ];
            }
            $workoutPlan->exercises()->attach($exercises);
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
        
        $workoutPlan->exercises()->detach();
        $workoutPlan->delete();

        return redirect()
            ->route('workout-plans.index')
            ->with('success', 'Workout plan deleted successfully!');
    }
}
