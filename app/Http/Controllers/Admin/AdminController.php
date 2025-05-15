<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WorkoutPlan;
use App\Models\Exercise;
use App\Models\WorkoutLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        // Get count statistics for dashboard
        $userCount = User::count();
        $workoutPlansCount = WorkoutPlan::count();
        $exerciseCount = Exercise::count();
        $workoutLogsCount = WorkoutLog::count();
        
        // Get recent users
        $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get();
        
        // Get popular workout plans
        $popularPlans = WorkoutPlan::withCount('subscribers')
            ->orderBy('subscribers_count', 'desc')
            ->take(5)
            ->get();
            
        return view('admin.dashboard', compact(
            'userCount', 
            'workoutPlansCount', 
            'exerciseCount', 
            'workoutLogsCount',
            'recentUsers',
            'popularPlans'
        ));
    }
    
    /**
     * Display a list of all users.
     */
    public function users(Request $request)
    {
        $query = User::query();
        
        // Apply search if provided
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Apply admin filter if provided
        if ($request->filled('filter')) {
            if ($request->input('filter') === 'admin') {
                $query->where('admin', 1);
            } elseif ($request->input('filter') === 'regular') {
                $query->where('admin', 0);
            }
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.users.index', compact('users'));
    }
    
    /**
     * Toggle admin status for a user.
     */
    public function toggleAdmin(User $user)
    {
        $user->admin = $user->admin == 1 ? 0 : 1;
        $user->save();
        
        return redirect()->route('admin.users')->with('success', 'User admin status updated successfully');
    }
    
    /**
     * Show the form for editing a user.
     */
    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }
    
    /**
     * Update the specified user in storage.
     */
    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'birth_year' => 'nullable|integer|digits:4|min:1900|max:' . date('Y'),
            'fitness_goals' => 'nullable|string',
        ]);
        
        $user->update($validated);
        
        return redirect()
            ->route('admin.users')
            ->with('success', 'User updated successfully!');
    }
    
    /**
     * Remove the specified user from storage.
     */
    public function destroyUser(User $user)
    {
        // Prevent deleting the currently authenticated user
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('admin.users')
                ->with('error', 'You cannot delete your own account while logged in.');
        }
        
        // Delete the user's data (workout plans, logs, etc.) or handle as needed
        // This might need to be adjusted based on your specific data relationships
        
        $user->delete();
        
        return redirect()
            ->route('admin.users')
            ->with('success', 'User deleted successfully!');
    }
    
    /**
     * Display a list of all workout plans.
     */
    public function workoutPlans()
    {
        $plans = WorkoutPlan::with('creator')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.workout-plans.index', compact('plans'));
    }
    
    /**
     * Show the form for editing a workout plan.
     */
    public function editWorkoutPlan(WorkoutPlan $workoutPlan)
    {
        return view('admin.workout-plans.edit', compact('workoutPlan'));
    }
    
    /**
     * Update the specified workout plan in storage.
     */
    public function updateWorkoutPlan(Request $request, WorkoutPlan $workoutPlan)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'difficulty_level' => 'required|string|in:beginner,intermediate,advanced',
            'duration_weeks' => 'required|integer|min:1|max:52',
            'sessions_per_week' => 'required|integer|min:1|max:7',
            'goals' => 'nullable|array',
            'is_public' => 'boolean',
            'is_template' => 'boolean',
        ]);
        
        $workoutPlan->update($validated);
        
        return redirect()
            ->route('admin.workout-plans')
            ->with('success', 'Workout plan updated successfully!');
    }
    
    /**
     * Remove the specified workout plan from storage.
     */
    public function destroyWorkoutPlan(WorkoutPlan $workoutPlan)
    {
        // Delete associated image if exists
        if ($workoutPlan->image) {
            $path = str_replace('/storage/', '', $workoutPlan->image);
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
        
        // Delete the workout plan (this will use soft delete as defined in the model)
        $workoutPlan->delete();
        
        return redirect()
            ->route('admin.workout-plans')
            ->with('success', 'Workout plan deleted successfully!');
    }
    
    /**
     * Display a list of all exercises.
     */
    public function exercises()
    {
        $exercises = Exercise::orderBy('name')->paginate(20);
        return view('admin.exercises.index', compact('exercises'));
    }
    
    /**
     * Show the form for creating a new exercise.
     */
    public function createExercise()
    {
        return view('admin.exercises.create');
    }
    
    /**
     * Store a newly created exercise in storage.
     */
    public function storeExercise(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:exercises',
            'muscle_group' => 'required|string|max:100',
            'equipment_needed' => 'required|string|max:100',
            'difficulty_level' => 'required|string|in:Beginner,Intermediate,Advanced',
            'instructions' => 'required|string',
            'media' => 'nullable|image|max:2048', // Max 2MB
        ]);
        
        $exercise = new Exercise();
        $exercise->name = $validated['name'];
        $exercise->muscle_group = $validated['muscle_group'];
        $exercise->equipment_needed = $validated['equipment_needed'];
        $exercise->difficulty_level = $validated['difficulty_level'];
        $exercise->instructions = $validated['instructions'];
        
        // Handle media upload if provided
        if ($request->hasFile('media')) {
            $path = $request->file('media')->store('exercises', 'public');
            $exercise->media_url = Storage::url($path);
        }
        
        $exercise->save();
        
        return redirect()
            ->route('admin.exercises')
            ->with('success', 'Exercise created successfully!');
    }
    
    /**
     * Show the form for editing an exercise.
     */
    public function editExercise(Exercise $exercise)
    {
        return view('admin.exercises.edit', compact('exercise'));
    }
    
    /**
     * Update the specified exercise in storage.
     */
    public function updateExercise(Request $request, Exercise $exercise)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:exercises,name,' . $exercise->id,
            'muscle_group' => 'required|string|max:100',
            'equipment_needed' => 'required|string|max:100',
            'difficulty_level' => 'required|string|in:Beginner,Intermediate,Advanced',
            'instructions' => 'required|string',
            'media' => 'nullable|image|max:2048', // Max 2MB
        ]);
        
        $exercise->name = $validated['name'];
        $exercise->muscle_group = $validated['muscle_group'];
        $exercise->equipment_needed = $validated['equipment_needed'];
        $exercise->difficulty_level = $validated['difficulty_level'];
        $exercise->instructions = $validated['instructions'];
        
        // Handle media upload if provided
        if ($request->hasFile('media')) {
            // Delete old image if exists
            if ($exercise->media_url) {
                $oldPath = str_replace('/storage/', '', $exercise->media_url);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
            
            $path = $request->file('media')->store('exercises', 'public');
            $exercise->media_url = Storage::url($path);
        }
        
        $exercise->save();
        
        return redirect()
            ->route('admin.exercises')
            ->with('success', 'Exercise updated successfully!');
    }
    
    /**
     * Remove the specified exercise from storage.
     */
    public function destroyExercise(Exercise $exercise)
    {
        // Delete media if exists
        if ($exercise->media_url) {
            $path = str_replace('/storage/', '', $exercise->media_url);
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
        
        $exercise->delete();
        
        return redirect()
            ->route('admin.exercises')
            ->with('success', 'Exercise deleted successfully!');
    }
    
    /**
     * Display system statistics.
     */
    public function statistics()
    {
        // User growth by month
        $userGrowth = DB::table('users')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as count'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        // Workout plan creation by month
        $planCreation = DB::table('workout_plans')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as count'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        // Most active users by workout logs
        $mostActiveUsers = User::withCount('workoutLogs')
            ->orderBy('workout_logs_count', 'desc')
            ->take(10)
            ->get();
        
        return view('admin.statistics', compact('userGrowth', 'planCreation', 'mostActiveUsers'));
    }
} 