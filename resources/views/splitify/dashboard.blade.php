<x-splitify-layout title="Dashboard - Splitify">
    <div class="space-y-6">
        <!-- Dashboard Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                <p class="text-gray-600">Welcome back, {{ Auth::user()->name }}! Here's your workout summary.</p>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-3">
                <a href="{{ route('workout-plans.index') }}" class="splitify-btn splitify-btn-secondary">Workout Plans</a>
                <a href="{{ route('exercises.index') }}" class="splitify-btn splitify-btn-secondary">Exercise Library</a>
                <a href="{{ route('progress.index') }}" class="splitify-btn splitify-btn-secondary">Progress Tracking</a>
                <a href="{{ route('workout-plans.create') }}" class="splitify-btn splitify-btn-primary">Create New Workout</a>
            </div>
        </div>
        
        <!-- Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Weekly Workouts -->
            <div class="splitify-card p-6">
                <div class="flex items-start">
                    <div class="p-2 rounded-lg bg-teal-100" style="color: var(--teal);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium text-gray-600">Weekly Workouts</h2>
                        @if(isset($currentWeekWorkouts) && isset($plannedWorkoutsPerWeek))
                            <div class="flex items-baseline">
                                <p class="text-2xl font-semibold">{{ $currentWeekWorkouts }}</p>
                                <p class="ml-2 text-sm text-gray-500">/ {{ $plannedWorkoutsPerWeek }} planned</p>
                            </div>
                            <div class="splitify-progress mt-2">
                                <div class="splitify-progress-bar" style="width: {{ $weeklyProgress }}%;"></div>
                            </div>
                        @else
                            <div class="flex items-baseline">
                                <p class="text-2xl font-semibold">0</p>
                                <p class="ml-2 text-sm text-gray-500">/ 0 planned</p>
                            </div>
                            <div class="splitify-progress mt-2">
                                <div class="splitify-progress-bar" style="width: 0%;"></div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Volume Lifted -->
            <div class="splitify-card p-6">
                <div class="flex items-start">
                    <div class="p-2 rounded-lg bg-teal-100" style="color: var(--teal);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium text-gray-600">Total Volume Lifted</h2>
                        @if(isset($totalVolume))
                            <div class="flex items-baseline">
                                <p class="text-2xl font-semibold">{{ number_format($totalVolume) }}</p>
                                <p class="ml-2 text-sm text-gray-500">lbs</p>
                            </div>
                            @if(isset($volumeChangePercentage) && $volumeChangePercentage != 0)
                                <p class="text-xs {{ $volumeChangePercentage > 0 ? 'text-green-500' : 'text-red-500' }} mt-1 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $volumeChangePercentage > 0 ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}" />
                                    </svg>
                                    {{ abs($volumeChangePercentage) }}% from last week
                                </p>
                            @else
                                <p class="text-xs text-gray-500 mt-1">No change from last week</p>
                            @endif
                        @else
                            <div class="flex items-baseline">
                                <p class="text-2xl font-semibold">0</p>
                                <p class="ml-2 text-sm text-gray-500">lbs</p>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">No workout data available</p>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Workout Streak -->
            <div class="splitify-card p-6">
                <div class="flex items-start">
                    <div class="p-2 rounded-lg bg-teal-100" style="color: var(--teal);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium text-gray-600">Workout Streak</h2>
                        @if(isset($currentStreak) && isset($streakData))
                            <div class="flex items-baseline">
                                <p class="text-2xl font-semibold">{{ $currentStreak }}</p>
                                <p class="ml-2 text-sm text-gray-500">days</p>
                            </div>
                            <div class="flex space-x-1 mt-2">
                                @foreach($streakData['last_7_days'] as $day)
                                    <div class="w-6 h-2 rounded-full {{ $day['has_workout'] ? 'bg-teal-500' : 'bg-gray-200' }}"></div>
                                @endforeach
                            </div>
                        @else
                            <div class="flex items-baseline">
                                <p class="text-2xl font-semibold">0</p>
                                <p class="ml-2 text-sm text-gray-500">days</p>
                            </div>
                            <div class="flex space-x-1 mt-2">
                                @for($i = 0; $i < 7; $i++)
                                    <div class="w-6 h-2 rounded-full bg-gray-200"></div>
                                @endfor
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Plan Completion -->
            <div class="splitify-card p-6">
                <div class="flex items-start">
                    <div class="p-2 rounded-lg bg-teal-100" style="color: var(--teal);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium text-gray-600">Plan Completion</h2>
                        @if(isset($planCompletionPercentage))
                            <div class="flex items-baseline">
                                <p class="text-2xl font-semibold">{{ $planCompletionPercentage }}%</p>
                            </div>
                            <div class="splitify-progress mt-2">
                                <div class="splitify-progress-bar" style="width: {{ $planCompletionPercentage }}%;"></div>
                            </div>
                        @else
                            <div class="flex items-baseline">
                                <p class="text-2xl font-semibold">0%</p>
                            </div>
                            <div class="splitify-progress mt-2">
                                <div class="splitify-progress-bar" style="width: 0%;"></div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content Area -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left column (wider) -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- User Stats -->
                <div class="splitify-card p-6">
                    <h2 class="text-lg font-semibold mb-4">Your Performance</h2>
                    @if(isset($recentWorkouts) && count($recentWorkouts) > 0)
                        <div class="h-64 w-full">
                            <!-- Chart can be implemented here -->
                            <div class="w-full h-full flex items-center justify-center bg-gray-50 rounded-lg">
                                <p class="text-gray-400">Performance chart will appear here</p>
                            </div>
                        </div>
                    @else
                        <div class="w-full flex items-center justify-center bg-gray-50 rounded-lg p-8">
                            <div class="text-center">
                                <p class="text-gray-500 mb-4">No workout data available to display performance.</p>
                                <a href="{{ route('workout-plans.create') }}" class="splitify-btn splitify-btn-primary">Create a Workout Plan</a>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Recent Workouts -->
                <div class="splitify-card p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">Recent Workouts</h2>
                        <a href="{{ route('progress.index') }}" class="text-sm font-medium" style="color: var(--teal);">View All</a>
                    </div>
                    
                    <div class="overflow-hidden">
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-4 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Workout</th>
                                    <th class="px-4 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Exercises</th>
                                    <th class="px-4 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Volume</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if(isset($recentWorkouts) && count($recentWorkouts) > 0)
                                    @foreach($recentWorkouts as $workout)
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $workout->date->format('M d, Y') }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-8 w-8 flex-shrink-0 rounded-full bg-teal-100 flex items-center justify-center" style="color: var(--teal);">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                        </svg>
                                                    </div>
                                                    <div class="ml-3">
                                                        <p class="text-sm font-medium text-gray-900">{{ $workout->workoutPlan->title ?? 'Unnamed Workout' }}</p>
                                                        <p class="text-xs text-gray-500">
                                                            @php
                                                                $muscleGroups = $workout->exercises->pluck('muscle_group')->unique();
                                                                echo $muscleGroups->count() > 0 ? $muscleGroups->join(', ') : 'No muscle groups';
                                                            @endphp
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $workout->exercises->count() }} exercises</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                                @php
                                                    $volume = 0;
                                                    foreach ($workout->exercises as $exercise) {
                                                        $volume += $exercise->pivot->sets * $exercise->pivot->reps * ($exercise->pivot->weight ?? 0);
                                                    }
                                                    echo number_format($volume) . ' lbs';
                                                @endphp
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                            No workouts completed yet. 
                                            <a href="{{ route('workout-plans.create') }}" class="text-teal-500 hover:underline">Create your first workout plan</a>.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Right column -->
            <div class="space-y-6">
                <!-- Get Started Card -->
                @if(!isset($recentWorkouts) || count($recentWorkouts) === 0)
                    <div class="splitify-card p-6">
                        <h2 class="text-lg font-semibold mb-4">Get Started</h2>
                        <div class="bg-teal-50 p-4 rounded-lg border border-teal-100 mb-4">
                            <p class="text-teal-800 text-sm">Welcome to Splitify! Start by creating your first workout plan. Track your progress and achieve your fitness goals.</p>
                        </div>
                        <div class="space-y-3">
                            <a href="{{ route('workout-plans.create') }}" class="splitify-btn splitify-btn-primary w-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Create Workout Plan
                            </a>
                            <a href="{{ route('exercises.index') }}" class="splitify-btn splitify-btn-secondary w-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                Browse Exercise Library
                            </a>
                        </div>
                    </div>
                @else
                    <!-- Current Workout Plan -->
                    <div class="splitify-card overflow-hidden">
                        <div class="p-4 border-b" style="background: var(--gradient-primary);">
                            <h2 class="text-lg font-semibold text-white">Current Plan</h2>
                            <p class="text-teal-100 text-sm">
                                {{ isset($recentWorkouts[0]->workoutPlan) ? $recentWorkouts[0]->workoutPlan->title : 'Your Active Workout' }}
                            </p>
                        </div>
                        <div class="p-4">
                            <div class="space-y-4">
                                @if(isset($recentWorkouts[0]) && isset($recentWorkouts[0]->exercises) && $recentWorkouts[0]->exercises->count() > 0)
                                    @foreach($recentWorkouts[0]->exercises->take(5) as $exercise)
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="font-medium">{{ $exercise->name }}</p>
                                                <p class="text-sm text-gray-500">{{ $exercise->pivot->sets ?? 3 }} sets × {{ $exercise->pivot->reps ?? '8-10' }} reps</p>
                                            </div>
                                            <div class="text-sm font-semibold" style="color: var(--teal);">{{ $exercise->pivot->weight ?? '-' }} {{ $exercise->pivot->weight ? 'lbs' : '' }}</div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="py-4 text-center text-gray-500">
                                        <p>No exercises found in your recent workout.</p>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-6">
                                <a href="{{ route('workout-plans.index') }}" class="splitify-btn splitify-btn-primary w-full">View Workout Plans</a>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Workout Plan Progress or Suggested Plans -->
                @if(isset($recentWorkouts) && count($recentWorkouts) > 0)
                    <div class="splitify-card p-6">
                        <h2 class="text-lg font-semibold mb-3">Workout Plan Progress</h2>
                        @if(isset($recentWorkouts[0]->workoutPlan))
                            <p class="text-sm text-gray-600 mb-4">{{ $recentWorkouts[0]->workoutPlan->title }} - Week {{ $recentWorkouts[0]->current_week ?? 1 }} of {{ $recentWorkouts[0]->workoutPlan->duration ?? 8 }}</p>
                            
                            <div class="space-y-4">
                                @if(isset($planProgress) && count($planProgress) > 0)
                                    @foreach($planProgress as $split)
                                        <div>
                                            <div class="flex justify-between text-sm mb-1">
                                                <span>{{ $split['name'] }}</span>
                                                <span class="font-medium">{{ $split['completed'] }}/{{ $split['total'] }}</span>
                                            </div>
                                            <div class="splitify-progress">
                                                <div class="splitify-progress-bar" style="width: {{ $split['percentage'] }}%;"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div>
                                        <div class="flex justify-between text-sm mb-1">
                                            <span>Overall Progress</span>
                                            <span class="font-medium">{{ $planCompletionPercentage ?? 0 }}%</span>
                                        </div>
                                        <div class="splitify-progress">
                                            <div class="splitify-progress-bar" style="width: {{ $planCompletionPercentage ?? 0 }}%;"></div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <p class="text-sm text-gray-500 mb-4">No active workout plan found.</p>
                            <a href="{{ route('workout-plans.create') }}" class="splitify-btn splitify-btn-primary w-full">Create Workout Plan</a>
                        @endif
                    </div>
                @else
                    <!-- Suggested Splits for New Users -->
                    <div class="splitify-card p-6">
                        <h2 class="text-lg font-semibold mb-4">Suggested Workout Splits</h2>
                        
                        <div class="space-y-4">
                            <div class="flex items-center p-3 border rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="h-10 w-10 flex-shrink-0 rounded-full bg-teal-100 flex items-center justify-center" style="color: var(--teal);">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium">Push/Pull/Legs</p>
                                    <p class="text-xs text-gray-500">6 days per week</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center p-3 border rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="h-10 w-10 flex-shrink-0 rounded-full bg-teal-100 flex items-center justify-center" style="color: var(--teal);">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium">Upper/Lower Split</p>
                                    <p class="text-xs text-gray-500">4 days per week</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center p-3 border rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="h-10 w-10 flex-shrink-0 rounded-full bg-teal-100 flex items-center justify-center" style="color: var(--teal);">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium">Full Body Split</p>
                                    <p class="text-xs text-gray-500">3 days per week</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-splitify-layout> 