<x-splitify-layout>
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">{{ $workoutPlan->title }}</h1>
            <div class="flex space-x-2">
                <a href="{{ route('workout-plans.edit', $workoutPlan) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-full text-sm font-semibold text-gray-700 hover:bg-gray-300 transition-all duration-300 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    {{ __('Edit Plan') }}
                </a>
                
                <a href="{{ route('workout-plans.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-full text-sm font-semibold text-gray-700 hover:bg-gray-300 transition-all duration-300 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Back to Plans') }}
                </a>
                
                <form method="POST" action="{{ route('workout-plans.destroy', $workoutPlan) }}" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this workout plan?') }}');">
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
        <!-- Plan Information -->
        <div class="border-b border-gray-200">
            <div class="flex flex-wrap">
                <div class="w-full p-6 md:w-3/4 md:border-r md:border-gray-200">
                    <div class="prose max-w-none">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Description') }}</h2>
                        <p class="text-gray-700">{{ $workoutPlan->description }}</p>
                    </div>
                </div>
                
                <div class="w-full p-6 md:w-1/4 bg-gray-50 flex flex-col">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Plan Details') }}</h2>
                    
                    <div class="space-y-4 flex-grow">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('Created') }}</p>
                            <p class="text-gray-900">{{ $workoutPlan->created_at->format('M j, Y') }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('Duration') }}</p>
                            <p class="text-gray-900">{{ $workoutPlan->duration }} {{ __('weeks') }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('Difficulty') }}</p>
                            <div class="mt-1">
                                @if($workoutPlan->difficulty == 'beginner')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ __('Beginner') }}
                                    </span>
                                @elseif($workoutPlan->difficulty == 'intermediate')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ __('Intermediate') }}
                                    </span>
                                @elseif($workoutPlan->difficulty == 'advanced')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        {{ __('Advanced') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('Total Exercises') }}</p>
                            <p class="text-gray-900">{{ $workoutPlan->exercises->count() }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-6 space-y-3">
                        <a href="{{ route('progress.create', ['workout_plan_id' => $workoutPlan->id]) }}" class="inline-flex items-center justify-center w-full px-4 py-2 bg-splitify-teal border border-transparent rounded-md text-sm font-semibold text-white shadow-sm hover:bg-splitify-navy focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-splitify-teal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            {{ __('Log a Workout') }}
                        </a>
                        
                        <a href="{{ route('progress.index', ['workout_plan' => $workoutPlan->id]) }}" class="inline-flex items-center justify-center w-full px-4 py-2 bg-splitify-teal/80 border border-transparent rounded-md text-sm font-semibold text-white shadow-sm hover:bg-splitify-navy focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-splitify-teal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                            </svg>
                            {{ __('View Progress') }}
                        </a>
                        
                        <a href="{{ route('exercises.index') }}" class="inline-flex items-center justify-center w-full px-4 py-2 bg-gray-200 border border-transparent rounded-md text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            {{ __('Exercise Library') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Workout Schedule -->
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Workout Schedule') }}</h2>
            
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @php
                    $exercisesByDay = $workoutPlan->exercises->groupBy('pivot.day');
                    $maxDays = 7;
                @endphp
                
                @for($day = 1; $day <= $maxDays; $day++)
                    <div class="bg-gray-50 rounded-lg overflow-hidden border border-gray-200">
                        <div class="bg-gray-100 px-4 py-2 border-b border-gray-200">
                            <h3 class="font-medium text-gray-900">{{ __('Day') }} {{ $day }}</h3>
                        </div>
                        
                        <div class="p-4">
                            @if($exercisesByDay->has($day) && $exercisesByDay[$day]->count() > 0)
                                <ul class="space-y-3">
                                    @foreach($exercisesByDay[$day] as $exercise)
                                        <li class="bg-white p-3 rounded-md shadow-sm border border-gray-100">
                                            <div class="flex justify-between">
                                                <div>
                                                    <h4 class="font-medium text-gray-900">{{ $exercise->name }}</h4>
                                                    <p class="text-xs text-gray-500">{{ $exercise->muscle_group }}</p>
                                                </div>
                                                <div class="text-xs text-gray-500 text-right">
                                                    <p>{{ $exercise->pivot->sets }} × {{ $exercise->pivot->reps }}</p>
                                                    <p>{{ $exercise->pivot->rest }}s rest</p>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="py-4 text-center text-sm text-gray-500">
                                    <p>{{ __('Rest Day') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
    
    <!-- Action Buttons at Bottom -->
    <div class="flex flex-wrap gap-3 justify-end mb-6">
        <a href="{{ route('progress.create', ['workout_plan_id' => $workoutPlan->id]) }}" class="inline-flex items-center px-5 py-2.5 bg-splitify-teal border border-transparent rounded-lg text-sm font-semibold text-white shadow-sm hover:bg-splitify-navy focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-splitify-teal">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            {{ __('Log New Workout') }}
        </a>
        
        <a href="{{ route('exercises.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-200 border border-transparent rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-300 transition-all duration-300 ease-in-out">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            {{ __('Browse Exercise Library') }}
        </a>
    </div>
</x-splitify-layout> 