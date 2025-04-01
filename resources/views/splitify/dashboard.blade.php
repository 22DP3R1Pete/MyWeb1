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
                        <div class="flex items-baseline">
                            <p class="text-2xl font-semibold">3</p>
                            <p class="ml-2 text-sm text-gray-500">/ 5 planned</p>
                        </div>
                        <div class="splitify-progress mt-2">
                            <div class="splitify-progress-bar" style="width: 60%;"></div>
                        </div>
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
                        <div class="flex items-baseline">
                            <p class="text-2xl font-semibold">12,540</p>
                            <p class="ml-2 text-sm text-gray-500">lbs</p>
                        </div>
                        <p class="text-xs text-green-500 mt-1 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                            8% from last week
                        </p>
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
                        <div class="flex items-baseline">
                            <p class="text-2xl font-semibold">5</p>
                            <p class="ml-2 text-sm text-gray-500">days</p>
                        </div>
                        <div class="flex space-x-1 mt-2">
                            <div class="w-6 h-2 rounded-full bg-teal-500"></div>
                            <div class="w-6 h-2 rounded-full bg-teal-500"></div>
                            <div class="w-6 h-2 rounded-full bg-teal-500"></div>
                            <div class="w-6 h-2 rounded-full bg-teal-500"></div>
                            <div class="w-6 h-2 rounded-full bg-teal-500"></div>
                            <div class="w-6 h-2 rounded-full bg-gray-200"></div>
                            <div class="w-6 h-2 rounded-full bg-gray-200"></div>
                        </div>
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
                        <div class="flex items-baseline">
                            <p class="text-2xl font-semibold">37%</p>
                        </div>
                        <div class="splitify-progress mt-2">
                            <div class="splitify-progress-bar" style="width: 37%;"></div>
                        </div>
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
                    <div class="h-64 w-full">
                        <!-- Placeholder for chart -->
                        <div class="w-full h-full flex items-center justify-center bg-gray-50 rounded-lg">
                            <p class="text-gray-400">Performance chart will appear here</p>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Workouts -->
                <div class="splitify-card p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">Recent Workouts</h2>
                        <a href="#" class="text-sm font-medium" style="color: var(--teal);">View All</a>
                    </div>
                    
                    <div class="overflow-hidden">
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-4 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Workout</th>
                                    <th class="px-4 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                    <th class="px-4 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Volume</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">July 10, 2023</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 flex-shrink-0 rounded-full bg-teal-100 flex items-center justify-center" style="color: var(--teal);">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">Push Day</p>
                                                <p class="text-xs text-gray-500">Chest, Shoulders, Triceps</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">58 min</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">4,320 lbs</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">July 8, 2023</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 flex-shrink-0 rounded-full bg-teal-100 flex items-center justify-center" style="color: var(--teal);">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">Pull Day</p>
                                                <p class="text-xs text-gray-500">Back, Biceps</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">62 min</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">3,980 lbs</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">July 6, 2023</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 flex-shrink-0 rounded-full bg-teal-100 flex items-center justify-center" style="color: var(--teal);">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">Leg Day</p>
                                                <p class="text-xs text-gray-500">Quads, Hamstrings, Calves</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">70 min</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">5,240 lbs</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Right column -->
            <div class="space-y-6">
                <!-- Today's Workout -->
                <div class="splitify-card overflow-hidden">
                    <div class="p-4 border-b" style="background: var(--gradient-primary);">
                        <h2 class="text-lg font-semibold text-white">Today's Workout</h2>
                        <p class="text-teal-100 text-sm">Push Day</p>
                    </div>
                    <div class="p-4">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-medium">Bench Press</p>
                                    <p class="text-sm text-gray-500">3 sets × 8-10 reps</p>
                                </div>
                                <div class="text-sm font-semibold" style="color: var(--teal);">135 lbs</div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-medium">Overhead Press</p>
                                    <p class="text-sm text-gray-500">3 sets × 8-10 reps</p>
                                </div>
                                <div class="text-sm font-semibold" style="color: var(--teal);">85 lbs</div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-medium">Incline Dumbbell Press</p>
                                    <p class="text-sm text-gray-500">3 sets × 10-12 reps</p>
                                </div>
                                <div class="text-sm font-semibold" style="color: var(--teal);">40 lbs</div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-medium">Tricep Pushdowns</p>
                                    <p class="text-sm text-gray-500">3 sets × 12-15 reps</p>
                                </div>
                                <div class="text-sm font-semibold" style="color: var(--teal);">50 lbs</div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-medium">Lateral Raises</p>
                                    <p class="text-sm text-gray-500">3 sets × 12-15 reps</p>
                                </div>
                                <div class="text-sm font-semibold" style="color: var(--teal);">15 lbs</div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('workout-plans.index') }}" class="splitify-btn splitify-btn-primary w-full">View Workout Plans</a>
                        </div>
                    </div>
                </div>
                
                <!-- Workout Plan Progress -->
                <div class="splitify-card p-6">
                    <h2 class="text-lg font-semibold mb-3">Workout Plan Progress</h2>
                    <p class="text-sm text-gray-600 mb-4">PPL Split - Week 3 of 8</p>
                    
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span>Push Day</span>
                                <span class="font-medium">3/4</span>
                            </div>
                            <div class="splitify-progress">
                                <div class="splitify-progress-bar" style="width: 75%;"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span>Pull Day</span>
                                <span class="font-medium">2/4</span>
                            </div>
                            <div class="splitify-progress">
                                <div class="splitify-progress-bar" style="width: 50%;"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span>Leg Day</span>
                                <span class="font-medium">3/4</span>
                            </div>
                            <div class="splitify-progress">
                                <div class="splitify-progress-bar" style="width: 75%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Suggested Splits -->
                <div class="splitify-card p-6">
                    <h2 class="text-lg font-semibold mb-4">Suggested Splits</h2>
                    
                    <div class="space-y-4">
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
                                <p class="font-medium">Arnold Split</p>
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
                                <p class="font-medium">Full Body Split</p>
                                <p class="text-xs text-gray-500">3 days per week</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-splitify-layout> 