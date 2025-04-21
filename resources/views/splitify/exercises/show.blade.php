<x-splitify-layout>
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">{{ $exercise->name }}</h1>
            <div class="flex space-x-2">
                <a href="{{ route('exercises.edit', $exercise) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-full text-sm font-semibold text-gray-700 hover:bg-gray-300 transition-all duration-300 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    {{ __('Edit Exercise') }}
                </a>
                
                <a href="{{ route('exercises.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-full text-sm font-semibold text-gray-700 hover:bg-gray-300 transition-all duration-300 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Back to Exercise Library') }}
                </a>
                
                <form method="POST" action="{{ route('exercises.destroy', $exercise) }}" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this exercise?') }}');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-100 border border-transparent rounded-full text-sm font-semibold text-red-700 hover:bg-red-200 transition-all duration-300 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        {{ __('Delete') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="bg-white shadow-sm rounded-lg overflow-hidden mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4">
            <!-- Exercise Details Sidebar -->
            <div class="bg-gray-50 p-6 md:border-r md:border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Exercise Details') }}</h2>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">{{ __('Muscle Group') }}</p>
                        <div class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $exercise->muscle_group }}
                            </span>
                        </div>
                    </div>
                    
                    @if($exercise->equipment)
                    <div>
                        <p class="text-sm font-medium text-gray-500">{{ __('Equipment') }}</p>
                        <p class="text-gray-900">{{ $exercise->equipment }}</p>
                    </div>
                    @endif
                    
                    @if($exercise->difficulty)
                    <div>
                        <p class="text-sm font-medium text-gray-500">{{ __('Difficulty') }}</p>
                        <div class="mt-1">
                            @if($exercise->difficulty == 'beginner')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ __('Beginner') }}
                                </span>
                            @elseif($exercise->difficulty == 'intermediate')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    {{ __('Intermediate') }}
                                </span>
                            @elseif($exercise->difficulty == 'advanced')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    {{ __('Advanced') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    <div>
                        <p class="text-sm font-medium text-gray-500">{{ __('Added On') }}</p>
                        <p class="text-gray-900">{{ $exercise->created_at->format('M j, Y') }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm font-medium text-gray-500">{{ __('Last Updated') }}</p>
                        <p class="text-gray-900">{{ $exercise->updated_at->format('M j, Y') }}</p>
                    </div>
                </div>
                
                <div class="mt-6">
                    <a href="#" class="inline-flex items-center justify-center w-full px-4 py-2 bg-splitify-teal border border-transparent rounded-md text-sm font-semibold text-white shadow-sm hover:bg-splitify-navy focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-splitify-teal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        {{ __('Add to Workout Plan') }}
                    </a>
                </div>
            </div>
            
            <!-- Exercise Content -->
            <div class="p-6 md:col-span-3">
                <!-- Instructions Section -->
                @if($exercise->instructions)
                <div class="mb-8">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Instructions') }}</h2>
                    <div class="prose max-w-none text-gray-700">
                        <p>{{ $exercise->instructions }}</p>
                    </div>
                </div>
                @endif
                
                <!-- Notes Section -->
                @if($exercise->notes)
                <div class="mb-8">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Notes') }}</h2>
                    <div class="prose max-w-none text-gray-700">
                        <p>{{ $exercise->notes }}</p>
                    </div>
                </div>
                @endif
                
                <!-- Workout Plans Section -->
                <div>
                    <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Associated Workout Plans') }}</h2>
                    
                    @if($workoutPlans->count() > 0)
                        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                            <ul class="divide-y divide-gray-200">
                                @foreach($workoutPlans as $plan)
                                    <li class="p-4 hover:bg-gray-50">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <a href="{{ route('workout-plans.show', $plan) }}" class="text-splitify-teal hover:text-splitify-navy font-medium">
                                                    {{ $plan->title }}
                                                </a>
                                                <p class="text-sm text-gray-500">
                                                    {{ $plan->sessions_per_week }} {{ __('sessions per week') }} · {{ $plan->duration_weeks }} {{ __('weeks') }}
                                                </p>
                                            </div>
                                            <div>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $plan->difficulty_level == 'beginner' ? 'bg-green-100 text-green-800' : ($plan->difficulty_level == 'intermediate' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800') }}">
                                                    {{ ucfirst($plan->difficulty_level) }}
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-lg border border-gray-200 p-6 text-center">
                            <p class="text-gray-500">{{ __('This exercise is not used in any workout plans yet.') }}</p>
                            <div class="mt-4">
                                <a href="{{ route('workout-plans.create') }}" class="inline-flex items-center text-sm text-splitify-teal hover:text-splitify-navy">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    {{ __('Create a new workout plan with this exercise') }}
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-splitify-layout> 