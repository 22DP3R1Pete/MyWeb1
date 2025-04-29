<x-splitify-layout title="{{ $progress->workoutPlan->title ?? 'Workout Log' }} - Splitify">
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Workout Details</h1>
            <div class="flex space-x-2">
                <a href="{{ url('/progress/' . $progress->id . '/edit') }}" class="inline-flex items-center px-4 py-2 bg-splitify-teal border border-transparent rounded-full text-sm font-semibold text-white shadow-sm hover:bg-splitify-navy transition-all duration-300 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    {{ __('Edit Workout') }}
                </a>
                <a href="{{ url('/progress') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-full text-sm font-semibold text-gray-700 hover:bg-gray-300 transition-all duration-300 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Back to Progress') }}
                </a>
            </div>
        </div>
        <p class="mt-1 text-sm text-gray-500">{{ __('View the details of your logged workout') }}</p>
    </div>

    <!-- Workout Log Details -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">
                        {{ $progress->workoutPlan?->title ?? __('Deleted Workout Plan') }}
                    </h2>
                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $progress->date->format('F d, Y') }}
                        <span class="mx-2">&bull;</span>
                        {{ $progress->date->diffForHumans() }}
                    </div>
                </div>
                <div class="flex items-center">
                    @if($progress->completed)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ __('Completed') }}
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ __('In Progress') }}
                        </span>
                    @endif
                </div>
            </div>

            @if($progress->notes)
                <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">{{ __('Notes') }}</h3>
                    <p class="text-sm text-gray-600 whitespace-pre-line">{{ $progress->notes }}</p>
                </div>
            @endif
        </div>

        <!-- Exercises -->
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
                {{ __('Exercises') }}
                <span class="text-sm font-normal text-gray-500 ml-2">
                    ({{ count($progress->exercises) }} {{ Str::plural('exercise', count($progress->exercises)) }})
                </span>
            </h3>

            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Exercise') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Sets') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Reps') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Weight') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Notes') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Previous') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($progress->exercises as $exercise)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $exercise->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $exercise->muscle_group }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $exercise->pivot->sets }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $exercise->pivot->reps }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $exercise->pivot->weight }} lbs</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $exercise->pivot->notes ?: '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $previousExercise = null;
                                            
                                            // Look for this exercise in previous logs
                                            if(isset($previousLogs) && count($previousLogs) > 0) {
                                                foreach($previousLogs[0]->exercises as $prevExercise) {
                                                    if($prevExercise->id === $exercise->id) {
                                                        $previousExercise = $prevExercise;
                                                        break;
                                                    }
                                                }
                                            }
                                        @endphp
                                        
                                        @if($previousExercise)
                                            <div class="text-xs text-gray-500">
                                                <div>{{ $previousExercise->pivot->sets }} {{ __('sets') }} ×</div>
                                                <div>{{ $previousExercise->pivot->reps }} {{ __('reps') }} ×</div>
                                                <div>{{ $previousExercise->pivot->weight }} {{ __('lbs') }}</div>
                                                
                                                @if($previousExercise->pivot->weight < $exercise->pivot->weight)
                                                    <div class="mt-1 text-green-500 font-medium flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                                        </svg>
                                                        {{ number_format((($exercise->pivot->weight - $previousExercise->pivot->weight) / $previousExercise->pivot->weight) * 100, 1) }}%
                                                    </div>
                                                @elseif($previousExercise->pivot->weight > $exercise->pivot->weight)
                                                    <div class="mt-1 text-red-500 font-medium flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                                        </svg>
                                                        {{ number_format((($previousExercise->pivot->weight - $exercise->pivot->weight) / $previousExercise->pivot->weight) * 100, 1) }}%
                                                    </div>
                                                @else
                                                    <div class="mt-1 text-gray-500 font-medium flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                        </svg>
                                                        {{ __('Same') }}
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <div class="text-xs text-gray-500">{{ __('No previous data') }}</div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">{{ __('No exercises recorded for this workout.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-between">
        <form action="{{ url('/progress/' . $progress->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this workout log?') }}');">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md text-sm font-semibold text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                {{ __('Delete Workout') }}
            </button>
        </form>
        <a href="{{ url('/progress') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">{{ __('Back to Progress') }}</a>
    </div>
</x-splitify-layout> 