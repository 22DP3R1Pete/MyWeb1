<x-splitify-layout>
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Log Workout') }}</h1>
            <a href="{{ route('workout-logs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-full text-sm font-semibold text-gray-700 hover:bg-gray-300 transition-all duration-300 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Back to Workout Logs') }}
            </a>
        </div>
        <p class="mt-1 text-sm text-gray-500">{{ __('Track your workout progress by logging your exercise performance') }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <form action="{{ route('workout-logs.store') }}" method="POST" class="p-6" x-data="{ 
            selectedPlan: '',
            workoutPlans: [],
            planExercises: {},
            selectedExercises: [],
            init() {
                this.workoutPlans = JSON.parse(document.getElementById('workout-plans-data').textContent);
                this.fetchExercisesForPlan();
            },
            fetchExercisesForPlan() {
                if (this.selectedPlan) {
                    const plan = this.workoutPlans.find(p => p.id == this.selectedPlan);
                    if (plan && plan.exercises) {
                        this.selectedExercises = plan.exercises.map(e => ({
                            id: e.id,
                            name: e.name,
                            muscle_group: e.muscle_group,
                            sets: e.pivot.sets,
                            reps: e.pivot.reps,
                            weight: '',
                            completed: true
                        }));
                    } else {
                        this.selectedExercises = [];
                    }
                } else {
                    this.selectedExercises = [];
                }
            }
        }">
            @csrf
            
            <!-- Workout Plans Data -->
            <div id="workout-plans-data" class="hidden">{{ json_encode($workoutPlans) }}</div>
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Workout Date -->
                <div>
                    <label for="workout_date" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Date') }} <span class="text-red-500">*</span></label>
                    <input type="date" name="workout_date" id="workout_date" value="{{ old('workout_date', date('Y-m-d')) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50" required>
                    @error('workout_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Workout Plan (Optional) -->
                <div>
                    <label for="workout_plan_id" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Workout Plan') }}</label>
                    <select name="workout_plan_id" id="workout_plan_id" x-model="selectedPlan" @change="fetchExercisesForPlan()" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50">
                        <option value="">{{ __('-- Select Workout Plan (Optional) --') }}</option>
                        <template x-for="plan in workoutPlans" :key="plan.id">
                            <option :value="plan.id" x-text="plan.title"></option>
                        </template>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">{{ __('Selecting a plan will pre-fill exercises from that plan') }}</p>
                    @error('workout_plan_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Duration -->
                <div>
                    <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Duration (minutes)') }} <span class="text-red-500">*</span></label>
                    <input type="number" name="duration" id="duration" value="{{ old('duration', 60) }}" min="1" max="300" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50" required>
                    @error('duration')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Intensity/Difficulty -->
                <div>
                    <label for="intensity" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Intensity') }}</label>
                    <select name="intensity" id="intensity" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50">
                        <option value="low" {{ old('intensity') == 'low' ? 'selected' : '' }}>{{ __('Low') }}</option>
                        <option value="medium" {{ old('intensity') == 'medium' ? 'selected' : '' }}>{{ __('Medium') }}</option>
                        <option value="high" {{ old('intensity', 'high') == 'high' ? 'selected' : '' }}>{{ __('High') }}</option>
                    </select>
                    @error('intensity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Notes -->
                <div class="md:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Notes') }}</label>
                    <textarea name="notes" id="notes" rows="2" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Exercises Section -->
            <div class="mt-8">
                <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Exercises') }}</h2>
                
                <div x-show="selectedExercises.length === 0" class="bg-gray-50 rounded-lg p-6 text-center">
                    <p class="text-gray-500">{{ __('No exercises selected. Choose a workout plan to pre-fill exercises or add them manually.') }}</p>
                    <div class="mt-4">
                        <a href="{{ route('exercises.index') }}" class="inline-flex items-center text-sm text-splitify-teal hover:text-splitify-navy">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            {{ __('Add from Exercise Library') }}
                        </a>
                    </div>
                </div>
                
                <div x-show="selectedExercises.length > 0" class="space-y-4">
                    <p class="text-sm text-gray-500 mb-4">{{ __('Log your performance for each exercise') }}</p>
                    
                    <template x-for="(exercise, index) in selectedExercises" :key="index">
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="flex flex-wrap items-start justify-between">
                                <div class="w-full md:w-1/4 mb-3 md:mb-0">
                                    <div class="flex items-center">
                                        <input type="checkbox" :id="'completed_' + index" x-model="exercise.completed" class="h-4 w-4 text-splitify-teal focus:ring-splitify-teal border-gray-300 rounded mr-2">
                                        <label :for="'completed_' + index" class="text-sm font-medium text-gray-700">
                                            <span x-text="exercise.name"></span>
                                            <input type="hidden" :name="'exercises[' + index + '][exercise_id]'" :value="exercise.id">
                                            <input type="hidden" :name="'exercises[' + index + '][completed]'" :value="exercise.completed ? 1 : 0">
                                            <p class="text-xs text-gray-500" x-text="exercise.muscle_group"></p>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="w-full md:w-3/4 grid grid-cols-3 gap-3">
                                    <div>
                                        <label :for="'sets_' + index" class="block text-xs font-medium text-gray-500 mb-1">{{ __('Sets') }}</label>
                                        <input type="number" :id="'sets_' + index" :name="'exercises[' + index + '][sets]'" x-model="exercise.sets" min="1" max="10" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50 text-sm">
                                    </div>
                                    
                                    <div>
                                        <label :for="'reps_' + index" class="block text-xs font-medium text-gray-500 mb-1">{{ __('Reps') }}</label>
                                        <input type="number" :id="'reps_' + index" :name="'exercises[' + index + '][reps]'" x-model="exercise.reps" min="1" max="100" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50 text-sm">
                                    </div>
                                    
                                    <div>
                                        <label :for="'weight_' + index" class="block text-xs font-medium text-gray-500 mb-1">{{ __('Weight (kg)') }}</label>
                                        <input type="number" :id="'weight_' + index" :name="'exercises[' + index + '][weight]'" x-model="exercise.weight" min="0" max="1000" step="0.5" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50 text-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    
                    <div class="mt-4">
                        <button type="button" @click="selectedExercises.push({id: 0, name: '{{ __('Custom Exercise') }}', muscle_group: '{{ __('Other') }}', sets: 3, reps: 10, weight: '', completed: true})" class="inline-flex items-center text-sm text-splitify-teal hover:text-splitify-navy">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            {{ __('Add Custom Exercise') }}
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('workout-logs.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-splitify-teal">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-splitify-teal hover:bg-splitify-navy focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-splitify-teal">
                    {{ __('Save Workout Log') }}
                </button>
            </div>
        </form>
    </div>
</x-splitify-layout> 