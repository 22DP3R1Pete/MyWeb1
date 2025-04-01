<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkoutPlanController;
use App\Http\Controllers\ExerciseLibraryController;
use App\Http\Controllers\ProgressTrackingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('splitify.home');
});

Route::get('/dashboard', function () {
    return view('splitify.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
