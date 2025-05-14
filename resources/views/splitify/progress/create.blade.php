<x-splitify-layout title="Log Workout - Splitify">
    <!-- Notification Banner -->
    <div x-data="{ 
        show: false, 
        message: '', 
        type: 'info',
        showNotification(msg, t = 'info') {
            this.message = msg;
            this.type = t;
            this.show = true;
            setTimeout(() => { this.show = false }, 5000);
        }
    }" 
    x-cloak
    @weight-limit-exceeded.window="showNotification('Weight value exceeds the maximum limit of 1000 lbs', 'error')"
    @validation-error.window="showNotification($event.detail.message, 'error')"
    id="notification-container">
        <div 
            x-show="show" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            class="fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-md"
            :class="{
                'bg-red-100 text-red-800 border border-red-200': type === 'error',
                'bg-green-100 text-green-800 border border-green-200': type === 'success',
                'bg-blue-100 text-blue-800 border border-blue-200': type === 'info'
            }"
        >
            <div class="flex items-center">
                <svg x-show="type === 'error'" class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <svg x-show="type === 'success'" class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <svg x-show="type === 'info'" class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zm-1 9a1 1 0 01-2 0v-4a1 1 0 112 0v4z" clip-rule="evenodd"></path>
                </svg>
                <p x-text="message"></p>
            </div>
            <button @click="show = false" class="absolute top-1 right-1 text-gray-500 hover:text-gray-800">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <div class="mb-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Log Workout</h1>
            <a href="{{ route('progress.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-full text-sm font-semibold text-gray-700 hover:bg-gray-300 transition-all duration-300 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Progress
            </a>
        </div>
        <p class="mt-1 text-sm text-gray-500">Record your workout performance and track your progress over time.</p>
    </div>

    <form action="{{ route('progress.store') }}" method="POST" id="logWorkoutForm">
        @csrf
        
        <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
            <!-- Workout Details -->
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Workout Details</h2>
                
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="workout_plan_id" class="block text-sm font-medium text-gray-700 mb-1">Workout Plan <span class="text-red-500">*</span></label>
                        <select name="workout_plan_id" id="workout_plan_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50" required onchange="this.form.action='{{ route('progress.create') }}'; this.form.method='GET'; this.form.submit();">
                            <option value="">-- Select a workout plan --</option>
                            @foreach($workoutPlans as $plan)
                                <option value="{{ $plan->id }}" {{ (old('workout_plan_id') == $plan->id || (isset($selectedPlanId) && $selectedPlanId == $plan->id)) ? 'selected' : '' }}>{{ $plan->title }}</option>
                            @endforeach
                        </select>
                        @error('workout_plan_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date <span class="text-red-500">*</span></label>
                        <input type="date" name="date" id="date" value="{{ old('date', now()->format('Y-m-d')) }}" max="{{ now()->format('Y-m-d') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50" required>
                        @error('date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                        <textarea name="notes" id="notes" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <div class="flex items-center">
                            <input type="checkbox" name="completed" id="completed" value="1" {{ old('completed') ? 'checked' : '' }} class="h-4 w-4 text-splitify-teal border-gray-300 rounded focus:ring-splitify-teal">
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
                    // Choose between plan exercises or all exercises
                    const planExercisesData = document.getElementById('planExercises');
                    const allExercisesData = document.getElementById('availableExercises');
                    
                    if (planExercisesData && planExercisesData.textContent.trim()) {
                        this.availableExercises = JSON.parse(planExercisesData.textContent);
                    } else {
                        this.availableExercises = JSON.parse(allExercisesData.textContent);
                    }
                    
                    this.exercises = [];
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
                
                <!-- Plan-specific exercises data -->
                @if(isset($planExercises))
                <div id="planExercises" class="hidden">{{ json_encode($planExercises) }}</div>
                @endif
                
                <!-- Exercise selection -->
                <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="exerciseSelect" class="block text-sm font-medium text-gray-700 mb-1">
                                Select Exercise
                                @if(isset($planExercises))
                                <span class="text-xs text-splitify-teal">(Showing exercises from selected workout plan)</span>
                                @endif
                            </label>
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
                                            <input type="number" :name="'weight[]'" x-model="exercise.weight" min="0" max="1000" step="0.5" class="w-20 rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50" 
                                            @input="
                                                if (parseFloat($event.target.value) > 1000) {
                                                    window.dispatchEvent(new CustomEvent('weight-limit-exceeded'));
                                                    $event.target.value = 1000;
                                                    exercise.weight = 1000;
                                                }
                                            ">
                                            <div class="text-xs text-gray-500 mt-1">Max: 1000 lbs</div>
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
            <div class="px-6 py-4 bg-gray-50 text-right">
                <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-splitify-teal hover:bg-splitify-navy focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-splitify-teal">
                    Log Workout
                </button>
            </div>
        </div>
    </form>
</x-splitify-layout> 