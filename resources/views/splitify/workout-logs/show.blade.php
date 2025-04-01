<x-splitify-layout>
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Workout Log') }} - {{ $workoutLog->workout_date->format('M j, Y') }}</h1>
            <div class="flex space-x-2">
                <a href="{{ route('workout-logs.edit', $workoutLog) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-full text-sm font-semibold text-gray-700 hover:bg-gray-300 transition-all duration-300 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    {{ __('Edit Log') }}
                </a>
                
                <a href="{{ route('workout-logs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-full text-sm font-semibold text-gray-700 hover:bg-gray-300 transition-all duration-300 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Back to Workout Logs') }}
                </a>
                
                <form method="POST" action="{{ route('workout-logs.destroy', $workoutLog) }}" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this workout log?') }}');">
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
            <!-- Workout Log Details Sidebar -->
            <div class="bg-gray-50 p-6 md:border-r md:border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Workout Details') }}</h2>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">{{ __('Date') }}</p>
                        <p class="text-gray-900">{{ $workoutLog->workout_date->format('F j, Y') }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm font-medium text-gray-500">{{ __('Duration') }}</p>
                        <p class="text-gray-900">{{ $workoutLog->duration }} {{ __('minutes') }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm font-medium text-gray-500">{{ __('Intensity') }}</p>
                        <div class="mt-1">
                            @if($workoutLog->intensity == 'low')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ __('Low') }}
                                </span>
                            @elseif($workoutLog->intensity == 'medium')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    {{ __('Medium') }}
                                </span>
                            @elseif($workoutLog->intensity == 'high')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    {{ __('High') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    @if($workoutLog->workoutPlan)
                    <div>
                        <p class="text-sm font-medium text-gray-500">{{ __('Workout Plan') }}</p>
                        <a href="{{ route('workout-plans.show', $workoutLog->workoutPlan) }}" class="text-splitify-teal hover:text-splitify-navy">
                            {{ $workoutLog->workoutPlan->title }}
                        </a>
                    </div>
                    @endif
                    
                    <div>
                        <p class="text-sm font-medium text-gray-500">{{ __('Exercises Completed') }}</p>
                        <p class="text-gray-900">{{ $workoutLog->exercises->where('pivot.completed', true)->count() }} / {{ $workoutLog->exercises->count() }}</p>
                    </div>
                </div>
                
                <div class="mt-6">
                    <a href="{{ route('workout-logs.create') }}" class="inline-flex items-center justify-center w-full px-4 py-2 bg-splitify-teal border border-transparent rounded-md text-sm font-semibold text-white shadow-sm hover:bg-splitify-navy focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-splitify-teal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        {{ __('Log Another Workout') }}
                    </a>
                </div>
            </div>
            
            <!-- Workout Log Content -->
            <div class="p-6 md:col-span-3">
                <!-- Notes Section -->
                @if($workoutLog->notes)
                <div class="mb-8">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Notes') }}</h2>
                    <div class="prose max-w-none text-gray-700">
                        <p>{{ $workoutLog->notes }}</p>
                    </div>
                </div>
                @endif
                
                <!-- Exercises Section -->
                <div>
                    <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Exercises Performed') }}</h2>
                    
                    @if($workoutLog->exercises->count() > 0)
                        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Exercise') }}</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Sets') }}</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Reps') }}</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Weight') }}</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($workoutLog->exercises as $exercise)
                                            <tr class="{{ $exercise->pivot->completed ? '' : 'bg-gray-50' }}">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">{{ $exercise->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $exercise->muscle_group }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $exercise->pivot->sets }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $exercise->pivot->reps }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $exercise->pivot->weight ? $exercise->pivot->weight . ' kg' : '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($exercise->pivot->completed)
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                            {{ __('Completed') }}
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                            {{ __('Skipped') }}
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-lg border border-gray-200 p-6 text-center">
                            <p class="text-gray-500">{{ __('No exercises recorded for this workout.') }}</p>
                        </div>
                    @endif
                </div>
                
                <!-- Performance Insights -->
                <div class="mt-8">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Performance Insights') }}</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200 flex flex-col items-center justify-center">
                            <div class="text-3xl font-bold text-splitify-navy mb-1">{{ $workoutLog->duration }}</div>
                            <div class="text-sm text-gray-500">{{ __('Minutes') }}</div>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200 flex flex-col items-center justify-center">
                            <div class="text-3xl font-bold text-splitify-navy mb-1">{{ $workoutLog->exercises->sum('pivot.sets') }}</div>
                            <div class="text-sm text-gray-500">{{ __('Total Sets') }}</div>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200 flex flex-col items-center justify-center">
                            @php
                                $totalVolume = 0;
                                foreach($workoutLog->exercises as $exercise) {
                                    if($exercise->pivot->completed && $exercise->pivot->weight) {
                                        $totalVolume += $exercise->pivot->sets * $exercise->pivot->reps * $exercise->pivot->weight;
                                    }
                                }
                            @endphp
                            <div class="text-3xl font-bold text-splitify-navy mb-1">{{ number_format($totalVolume) }}</div>
                            <div class="text-sm text-gray-500">{{ __('Volume (kg)') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-splitify-layout> 