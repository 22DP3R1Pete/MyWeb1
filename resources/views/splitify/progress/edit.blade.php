<x-splitify-layout title="Edit Workout Log - Splitify">
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Edit Workout Log</h1>
            <a href="{{ route('progress.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-full text-sm font-semibold text-gray-700 hover:bg-gray-300 transition-all duration-300 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Progress
            </a>
        </div>
        <p class="mt-1 text-sm text-gray-500">Update your workout log details and performance.</p>
    </div>

    <form action="{{ route('progress.update', $workoutLog) }}" method="POST" id="editWorkoutForm">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
            <!-- Workout Details -->
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Workout Details</h2>
                
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="workout_plan_id" class="block text-sm font-medium text-gray-700 mb-1">Workout Plan <span class="text-red-500">*</span></label>
                        <select name="workout_plan_id" id="workout_plan_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50" required>
                            <option value="">-- Select a workout plan --</option>
                            @foreach($workoutPlans as $plan)
                                <option value="{{ $plan->id }}" {{ (old('workout_plan_id', $workoutLog->workout_plan_id) == $plan->id) ? 'selected' : '' }}>{{ $plan->title }}</option>
                            @endforeach
                        </select>
                        @error('workout_plan_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date <span class="text-red-500">*</span></label>
                        <input type="date" name="date" id="date" value="{{ old('date', $workoutLog->date->format('Y-m-d')) }}" max="{{ now()->format('Y-m-d') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50" required>
                        @error('date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                        <textarea name="notes" id="notes" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50">{{ old('notes', $workoutLog->notes) }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <div class="flex items-center">
                            <input type="checkbox" name="completed" id="completed" value="1" {{ old('completed', $workoutLog->completed) ? 'checked' : '' }} class="h-4 w-4 text-splitify-teal border-gray-300 rounded focus:ring-splitify-teal">
                            <label for="completed" class="ml-2 block text-sm text-gray-700">
                                Mark this workout as completed 
                                <span class="text-xs text-gray-500">(Only completed workouts will appear on the dashboard)</span>
                            </label>
                        </div>
                        @error('completed')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Exercises Section -->
            <div class="p-6" x-data="{ 
                exercises: [], 
                availableExercises: [],
                init() {
                    this.availableExercises = JSON.parse(document.getElementById('availableExercises').textContent);
                    this.exercises = JSON.parse(document.getElementById('logExercises').textContent);
                },
                addExercise() {
                    const select = document.getElementById('exerciseSelect');
                    const exerciseId = select.value;
                    
                    if (!exerciseId) return;
                    
                    const exercise = this.availableExercises.find(e => e.id == exerciseId);
                    
                    this.exercises.push({
                        id: exercise.id,
                        name: exercise.name,
                        muscle_group: exercise.muscle_group,
                        sets: 3,
                        reps: 10,
                        weight: 0,
                        notes: ''
                    });
                    
                    // Reset the select
                    select.value = '';
                },
                removeExercise(index) {
                    this.exercises.splice(index, 1);
                }
            }">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Exercises</h2>
                
                <!-- Available exercises data -->
                <div id="availableExercises" class="hidden">{{ json_encode($exercises) }}</div>
                
                <!-- Log exercises data -->
                <div id="logExercises" class="hidden">
                    @php
                        $exercisesData = $logExercises->map(function($exercise) {
                            return [
                                'id' => $exercise->id,
                                'name' => $exercise->name,
                                'muscle_group' => $exercise->muscle_group,
                                'sets' => $exercise->pivot->sets,
                                'reps' => $exercise->pivot->reps,
                                'weight' => $exercise->pivot->weight,
                                'notes' => $exercise->pivot->notes ?? ''
                            ];
                        });
                    @endphp
                    {{ json_encode($exercisesData) }}
                </div>
                
                <!-- Exercise selection -->
                <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="exerciseSelect" class="block text-sm font-medium text-gray-700 mb-1">Select Exercise</label>
                            <select id="exerciseSelect" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50">
                                <option value="">-- Select an exercise --</option>
                                <template x-for="exercise in availableExercises" :key="exercise.id">
                                    <option :value="exercise.id" x-text="exercise.name + ' (' + exercise.muscle_group + ')'"></option>
                                </template>
                            </select>
                        </div>
                        
                        <div class="flex items-end">
                            <button type="button" @click="addExercise()" class="w-full inline-flex justify-center items-center px-4 py-2 bg-splitify-teal border border-transparent rounded-md text-sm font-semibold text-white shadow-sm hover:bg-splitify-navy focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-splitify-teal">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Add Exercise
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Selected exercises list -->
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Exercise</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sets</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reps</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Weight (lbs)</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <template x-if="exercises.length === 0">
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                            No exercises added yet. Add exercises to log your workout.
                                        </td>
                                    </tr>
                                </template>
                                <template x-for="(exercise, index) in exercises" :key="index">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900" x-text="exercise.name"></div>
                                            <div class="text-xs text-gray-500" x-text="exercise.muscle_group"></div>
                                            <input type="hidden" :name="'exercises[]'" :value="exercise.id">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="number" :name="'sets[]'" x-model="exercise.sets" min="1" max="10" class="w-16 rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="number" :name="'reps[]'" x-model="exercise.reps" min="1" max="100" class="w-16 rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="number" :name="'weight[]'" x-model="exercise.weight" min="0" step="0.5" class="w-20 rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="text" :name="'exercise_notes[]'" x-model="exercise.notes" placeholder="Optional" class="w-32 rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <button type="button" @click="removeExercise(index)" class="text-red-500 hover:text-red-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                @error('exercises')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 text-right space-x-3">
                <a href="{{ route('progress.index') }}" class="inline-flex justify-center py-2 px-6 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-splitify-teal">
                    Cancel
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-splitify-teal hover:bg-splitify-navy focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-splitify-teal">
                    Update Workout
                </button>
            </div>
        </div>
    </form>
</x-splitify-layout> 