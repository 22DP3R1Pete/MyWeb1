<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkoutPlanController;
use App\Http\Controllers\ExerciseLibraryController;
use App\Http\Controllers\ProgressTrackingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('splitify.home');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Workout Plans Routes
    Route::resource('workout-plans', WorkoutPlanController::class);
    
    // Exercise Library Routes
    Route::resource('exercises', ExerciseLibraryController::class);
    
    // Progress Tracking Routes
    Route::resource('progress', ProgressTrackingController::class);
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::patch('/users/{user}/toggle-admin', [AdminController::class, 'toggleAdmin'])->name('users.toggle-admin');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::get('/workout-plans', [AdminController::class, 'workoutPlans'])->name('workout-plans');
    Route::get('/workout-plans/{workoutPlan}/edit', [AdminController::class, 'editWorkoutPlan'])->name('workout-plans.edit');
    Route::put('/workout-plans/{workoutPlan}', [AdminController::class, 'updateWorkoutPlan'])->name('workout-plans.update');
    Route::delete('/workout-plans/{workoutPlan}', [AdminController::class, 'destroyWorkoutPlan'])->name('workout-plans.destroy');
    Route::get('/exercises', [AdminController::class, 'exercises'])->name('exercises');
    Route::get('/exercises/create', [AdminController::class, 'createExercise'])->name('exercises.create');
    Route::post('/exercises', [AdminController::class, 'storeExercise'])->name('exercises.store');
    Route::get('/exercises/{exercise}/edit', [AdminController::class, 'editExercise'])->name('exercises.edit');
    Route::put('/exercises/{exercise}', [AdminController::class, 'updateExercise'])->name('exercises.update');
    Route::delete('/exercises/{exercise}', [AdminController::class, 'destroyExercise'])->name('exercises.destroy');
    Route::get('/statistics', [AdminController::class, 'statistics'])->name('statistics');
});

// Test route to check user data
Route::get('/test-users', function () {
    $admin = \App\Models\User::where('email', 'admin@example.com')->first();
    $regularUser = \App\Models\User::where('admin', false)->first();
    
    return [
        'admin' => [
            'name' => $admin->name,
            'height' => $admin->height,
            'weight' => $admin->weight,
            'birth_year' => $admin->birth_year,
            'age' => $admin->age,
            'fitness_goals' => $admin->fitness_goals,
        ],
        'regular_user' => [
            'name' => $regularUser->name,
            'height' => $regularUser->height,
            'weight' => $regularUser->weight,
            'birth_year' => $regularUser->birth_year,
            'age' => $regularUser->age,
            'fitness_goals' => $regularUser->fitness_goals,
        ]
    ];
});

require __DIR__.'/auth.php';
