<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExerciseLibraryController extends Controller
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
        $query = Exercise::query();
        
        // Apply filters if they exist
        if ($request->has('muscle_group') && $request->muscle_group != 'all') {
            $query->where('muscle_group', $request->muscle_group);
        }
        
        if ($request->has('equipment') && $request->equipment != 'all') {
            $query->where('equipment', $request->equipment);
        }
        
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('instructions', 'like', '%' . $request->search . '%');
        }
        
        $exercises = $query->orderBy('name')->paginate(12);
        
        // Get unique muscle groups and equipment for filters
        $muscleGroups = Exercise::distinct()->pluck('muscle_group');
        $equipment = Exercise::distinct()->pluck('equipment');
        
        return view('splitify.exercises.index', compact('exercises', 'muscleGroups', 'equipment'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Only allow admins to create exercises
        $this->authorize('create', Exercise::class);
        
        return view('splitify.exercises.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Only allow admins to create exercises
        $this->authorize('create', Exercise::class);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:exercises',
            'muscle_group' => 'required|string|max:100',
            'equipment' => 'required|string|max:100',
            'instructions' => 'required|string',
            'media' => 'nullable|image|max:2048', // Max 2MB
        ]);
        
        $exercise = new Exercise();
        $exercise->name = $validated['name'];
        $exercise->muscle_group = $validated['muscle_group'];
        $exercise->equipment = $validated['equipment'];
        $exercise->instructions = $validated['instructions'];
        
        // Handle media upload if provided
        if ($request->hasFile('media')) {
            $path = $request->file('media')->store('exercises', 'public');
            $exercise->media_url = Storage::url($path);
        }
        
        $exercise->save();
        
        return redirect()
            ->route('exercises.show', $exercise)
            ->with('success', 'Exercise created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Exercise $exercise)
    {
        // Find related exercises (same muscle group)
        $relatedExercises = Exercise::where('muscle_group', $exercise->muscle_group)
            ->where('id', '!=', $exercise->id)
            ->limit(4)
            ->get();
            
        return view('splitify.exercises.show', compact('exercise', 'relatedExercises'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exercise $exercise)
    {
        // Only allow admins to edit exercises
        $this->authorize('update', $exercise);
        
        return view('splitify.exercises.edit', compact('exercise'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exercise $exercise)
    {
        // Only allow admins to update exercises
        $this->authorize('update', $exercise);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:exercises,name,' . $exercise->id,
            'muscle_group' => 'required|string|max:100',
            'equipment' => 'required|string|max:100',
            'instructions' => 'required|string',
            'media' => 'nullable|image|max:2048', // Max 2MB
        ]);
        
        $exercise->name = $validated['name'];
        $exercise->muscle_group = $validated['muscle_group'];
        $exercise->equipment = $validated['equipment'];
        $exercise->instructions = $validated['instructions'];
        
        // Handle media upload if provided
        if ($request->hasFile('media')) {
            // Delete old image if exists
            if ($exercise->media_url) {
                $oldPath = str_replace('/storage/', '', $exercise->media_url);
                Storage::disk('public')->delete($oldPath);
            }
            
            $path = $request->file('media')->store('exercises', 'public');
            $exercise->media_url = Storage::url($path);
        }
        
        $exercise->save();
        
        return redirect()
            ->route('exercises.show', $exercise)
            ->with('success', 'Exercise updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exercise $exercise)
    {
        // Only allow admins to delete exercises
        $this->authorize('delete', $exercise);
        
        // Delete media if exists
        if ($exercise->media_url) {
            $path = str_replace('/storage/', '', $exercise->media_url);
            Storage::disk('public')->delete($path);
        }
        
        $exercise->delete();
        
        return redirect()
            ->route('exercises.index')
            ->with('success', 'Exercise deleted successfully!');
    }
}
