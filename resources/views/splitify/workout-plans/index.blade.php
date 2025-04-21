<x-splitify-layout>
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Workout Plans') }}</h1>
            <a href="{{ route('workout-plans.create') }}" class="inline-flex items-center px-4 py-2 bg-splitify-teal border border-transparent rounded-full text-sm font-semibold text-white shadow-sm hover:bg-splitify-navy transition-all duration-300 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('New Plan') }}
            </a>
        </div>
        <p class="mt-1 text-sm text-gray-500">{{ __('Create and manage your workout routines') }}</p>
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

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
            <div class="flex-1">
                <label for="duration" class="block text-xs font-medium text-gray-500 mb-1">{{ __('Duration') }}</label>
                <select id="duration" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50 text-sm">
                    <option value="all">{{ __('All Durations') }}</option>
                    <option value="1-4">{{ __('1-4 weeks') }}</option>
                    <option value="5-8">{{ __('5-8 weeks') }}</option>
                    <option value="9-12">{{ __('9-12 weeks') }}</option>
                    <option value="13+">{{ __('13+ weeks') }}</option>
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
                    <input type="text" id="search" class="block w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50 text-sm" placeholder="{{ __('Search plans...') }}">
                </div>
            </div>
        </div>
    </div>

    <!-- Workout Plans Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($workoutPlans as $plan)
            <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300">
                <div class="p-5">
                    <div class="flex justify-between items-start">
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $plan->title }}</h3>
                    </div>
                    <p class="text-sm text-gray-500 line-clamp-2 mb-3">{{ $plan->description }}</p>
                    
                    <!-- Workout Schedule Summary -->
                    <div class="bg-gray-50 rounded-md p-3 mb-3 border border-gray-100">
                        <h4 class="text-xs font-medium text-gray-700 mb-1">{{ __('Weekly Schedule') }}</h4>
                        <div class="flex space-x-1">
                            @php
                                $splits = $plan->splits;
                                $activeDays = $splits->pluck('day_of_week')->toArray();
                            @endphp
                            
                            @for($day = 1; $day <= 7; $day++)
                                @if(in_array($day, $activeDays))
                                    <div class="w-7 h-7 rounded-full bg-splitify-teal flex items-center justify-center text-white text-xs">
                                        {{ substr(['M','T','W','T','F','S','S'][$day-1], 0, 1) }}
                                    </div>
                                @else
                                    <div class="w-7 h-7 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 text-xs">
                                        {{ substr(['M','T','W','T','F','S','S'][$day-1], 0, 1) }}
                                    </div>
                                @endif
                            @endfor
                        </div>
                    </div>
                    
                    <div class="flex items-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-xs text-gray-500">{{ $plan->duration_weeks }} {{ Str::plural('week', $plan->duration_weeks) }}</span>
                        <span class="mx-2 text-gray-300">•</span>
                        <span class="text-xs text-gray-500">{{ $plan->splits->count() }} {{ Str::plural('workout', $plan->splits->count()) }}/week</span>
                        <span class="mx-2 text-gray-300">•</span>
                        <span class="text-xs text-gray-500">Created {{ $plan->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <a href="{{ route('workout-plans.show', $plan) }}" class="text-sm font-medium text-splitify-teal hover:text-splitify-navy">
                            {{ __('View Details') }}
                        </a>
                        <div class="flex space-x-2">
                            <a href="{{ route('workout-plans.edit', $plan) }}" class="text-gray-400 hover:text-splitify-teal">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <button onclick="confirmDelete('{{ $plan->id }}')" class="text-gray-400 hover:text-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-lg shadow-sm p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-1">{{ __('No workout plans yet') }}</h3>
                <p class="text-sm text-gray-500 mb-4">{{ __('Create your first workout plan to get started with your fitness journey.') }}</p>
                <a href="{{ route('workout-plans.create') }}" class="inline-flex items-center px-4 py-2 bg-splitify-teal border border-transparent rounded-full text-sm font-semibold text-white shadow-sm hover:bg-splitify-navy transition-all duration-300 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    {{ __('Create Your First Plan') }}
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $workoutPlans->links() }}
    </div>

    <x-delete-workout-plan-modal />

    <script>
        function confirmDelete(planId) {
            window.dispatchEvent(new CustomEvent('open-delete-modal', {
                detail: { planId: planId }
            }));
        }
    </script>
</x-splitify-layout> 