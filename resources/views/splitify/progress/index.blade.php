<x-splitify-layout>
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Progress Tracking') }}</h1>
            <a href="{{ url('/progress/create') }}" class="inline-flex items-center px-4 py-2 bg-splitify-teal border border-transparent rounded-full text-sm font-semibold text-white shadow-sm hover:bg-splitify-navy transition-all duration-300 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('Log Workout') }}
            </a>
        </div>
        <p class="mt-1 text-sm text-gray-500">{{ __('Track and analyze your workout progress over time') }}</p>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Total Workouts -->
        <div class="bg-white rounded-lg shadow-sm p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-splitify-teal/10 rounded-full p-3 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-splitify-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">{{ __('Total Workouts') }}</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalWorkouts }}</p>
                </div>
            </div>
        </div>

        <!-- Total Exercises -->
        <div class="bg-white rounded-lg shadow-sm p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-50 rounded-full p-3 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">{{ __('Exercises Completed') }}</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalExercises }}</p>
                </div>
            </div>
        </div>

        <!-- Current Streak -->
        <div class="bg-white rounded-lg shadow-sm p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-orange-50 rounded-full p-3 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">{{ __('Current Streak') }}</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $streakData['current_streak'] }} {{ Str::plural('day', $streakData['current_streak']) }}</p>
                    <p class="text-xs text-gray-500">{{ __('Longest: :days days', ['days' => $streakData['longest_streak']]) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <form action="{{ url('/progress') }}" method="GET" class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
            <div class="flex-1">
                <label for="timeframe" class="block text-xs font-medium text-gray-500 mb-1">{{ __('Timeframe') }}</label>
                <select id="timeframe" name="timeframe" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50 text-sm" onchange="this.form.submit()">
                    <option value="week" {{ $timeframe === 'week' ? 'selected' : '' }}>{{ __('Last Week') }}</option>
                    <option value="month" {{ $timeframe === 'month' ? 'selected' : '' }}>{{ __('Last Month') }}</option>
                    <option value="year" {{ $timeframe === 'year' ? 'selected' : '' }}>{{ __('Last Year') }}</option>
                    <option value="all" {{ $timeframe === 'all' ? 'selected' : '' }}>{{ __('All Time') }}</option>
                </select>
            </div>
            <div class="flex-1">
                <label for="workout_plan" class="block text-xs font-medium text-gray-500 mb-1">{{ __('Workout Plan') }}</label>
                <select id="workout_plan" name="workout_plan" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50 text-sm" onchange="this.form.submit()">
                    <option value="all">{{ __('All Plans') }}</option>
                    @foreach($workoutPlans as $plan)
                        <option value="{{ $plan->id }}" {{ $planId == $plan->id ? 'selected' : '' }}>{{ $plan->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 md:flex-2">
                <label for="search" class="block text-xs font-medium text-gray-500 mb-1">{{ __('Search') }}</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="search" name="search" value="{{ request('search') }}" class="block w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50 text-sm" placeholder="{{ __('Search in notes...') }}">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <button type="submit" class="text-splitify-teal hover:text-splitify-navy focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex-none md:flex-initial md:self-end">
                <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 bg-splitify-teal border border-transparent rounded-md text-sm font-medium text-white shadow-sm hover:bg-splitify-navy focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-splitify-teal">
                    {{ __('Filter') }}
                </button>
            </div>
        </form>
        
        @if(request('search') || $timeframe != 'month' || $planId != 'all')
            <div class="mt-3 flex items-center">
                <span class="text-xs text-gray-500 mr-2">
                    Filtered by: 
                    @if($timeframe != 'month')
                        {{ $timeframe == 'week' ? 'Last Week' : ($timeframe == 'year' ? 'Last Year' : 'All Time') }}
                    @endif
                    
                    @if($planId != 'all')
                        @if($timeframe != 'month') | @endif
                        Plan: {{ $workoutPlans->firstWhere('id', $planId)->title ?? 'Unknown' }}
                    @endif
                    
                    @if(request('search'))
                        @if($timeframe != 'month' || $planId != 'all') | @endif
                        Search: "{{ request('search') }}"
                    @endif
                </span>
                <a href="{{ url('/progress') }}" class="text-xs text-splitify-teal hover:text-splitify-navy">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Clear filters
                    </span>
                </a>
            </div>
        @endif
    </div>

    <!-- Workout Logs Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Date') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Workout Plan') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Exercises') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Notes') }}</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($logs as $log)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $log->date->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $log->date->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $log->workoutPlan?->title ?? __('Deleted Plan') }}</div>
                                <div class="text-xs text-gray-500">{{ ucfirst($log->workoutPlan?->difficulty ?? '-') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $log->completed_exercises ?? count($log->exercises) }} {{ Str::plural('exercise', $log->completed_exercises ?? count($log->exercises)) }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 truncate max-w-xs">{{ Str::limit($log->notes, 50) ?: '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end items-center space-x-2">
                                    <a href="{{ url('/progress/' . $log->id) }}" class="inline-flex items-center px-3 py-1 bg-splitify-teal border border-transparent rounded-md text-xs font-medium text-white hover:bg-splitify-navy transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        {{ __('View') }}
                                    </a>
                                    <a href="{{ url('/progress/' . $log->id . '/edit') }}" class="inline-flex items-center px-3 py-1 bg-blue-500 border border-transparent rounded-md text-xs font-medium text-white hover:bg-blue-600 transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        {{ __('Edit') }}
                                    </a>
                                    <button onclick="confirmDelete('{{ $log->id }}')" class="inline-flex items-center px-3 py-1 bg-red-500 border border-transparent rounded-md text-xs font-medium text-white hover:bg-red-600 transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        {{ __('Delete') }}
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-1">{{ __('No workout logs found') }}</h3>
                                <p class="text-sm text-gray-500 mb-4">{{ __('Start logging your workouts to track your progress over time.') }}</p>
                                <a href="{{ url('/progress/create') }}" class="inline-flex items-center px-4 py-2 bg-splitify-teal border border-transparent rounded-full text-sm font-semibold text-white shadow-sm hover:bg-splitify-navy transition-all duration-300 ease-in-out">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    {{ __('Log Your First Workout') }}
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $logs->withQueryString()->links() }}
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" x-data="{ open: false, logId: null }" x-show="open" x-cloak class="fixed inset-0 z-50 overflow-y-auto" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true" x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">{{ __('Delete Workout Log') }}</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">{{ __('Are you sure you want to delete this workout log? This action cannot be undone.') }}</p>
                                <p x-text="'Log ID: ' + logId" class="text-xs text-gray-400 mt-1"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form id="deleteForm" method="POST" :action="'{{ url('/progress') }}/' + logId">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">{{ __('Delete') }}</button>
                    </form>
                    <button @click="open = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">{{ __('Cancel') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js Status Check -->
    <div class="hidden text-xs text-gray-400 mt-4 p-2">
        <div x-data="{ alpineLoaded: true }" x-init="console.log('Alpine is working')">
            <span x-show="alpineLoaded">Alpine.js is working</span>
            <span x-show="!alpineLoaded">Alpine.js is not working</span>
        </div>
    </div>

    <script>
        function confirmDelete(logId) {
            // Ensure logId is defined
            if (!logId) {
                console.error('Log ID is undefined');
                return;
            }
            
            try {
                // Get the Alpine.js component for the modal
                const modalElement = document.getElementById('deleteModal');
                if (!modalElement) {
                    console.error('Delete modal element not found');
                    return;
                }
                
                const deleteModal = modalElement.__x;
                if (deleteModal) {
                    deleteModal.$data.open = true;
                    deleteModal.$data.logId = logId;
                } else {
                    console.error('Alpine component not found on modal element');
                }
            } catch (error) {
                console.error('Error showing modal:', error);
            }
        }
        
        // Handle Enter key for search
        document.getElementById('search').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                this.form.submit();
            }
        });
    </script>
</x-splitify-layout> 