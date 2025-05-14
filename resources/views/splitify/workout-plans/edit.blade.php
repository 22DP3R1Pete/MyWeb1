<x-splitify-layout>
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Edit Workout Plan') }}</h1>
            <div class="flex space-x-2">
                <a href="{{ route('workout-plans.show', $workoutPlan) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-full text-sm font-semibold text-gray-700 hover:bg-gray-300 transition-all duration-300 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    {{ __('View Plan') }}
                </a>
                <a href="{{ route('workout-plans.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-full text-sm font-semibold text-gray-700 hover:bg-gray-300 transition-all duration-300 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Back to Plans') }}
                </a>
            </div>
        </div>
        <p class="mt-1 text-sm text-gray-500">{{ __('Update your workout plan details and exercises') }}</p>
    </div>

    <form action="{{ route('workout-plans.update', $workoutPlan) }}" method="POST" id="editWorkoutForm" @submit="if(exercises.length === 0) { event.preventDefault(); alert('Please add at least one exercise to your workout plan.'); return false; }">
        @csrf
        @method('PUT')
        
        @if ($errors->has('error'))
        <div class="bg-red-50 text-red-700 p-4 mb-6 rounded-lg">
            {{ $errors->first('error') }}
        </div>
        @endif
        
        <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
            <!-- Plan Details -->
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Plan Details') }}</h2>
                
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Title') }} <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title', $workoutPlan->title) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50" required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="md:flex md:space-x-4">
                        <div class="flex-1 mb-4 md:mb-0">
                            <label for="difficulty_level" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Difficulty') }} <span class="text-red-500">*</span></label>
                            <select name="difficulty_level" id="difficulty_level" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50" required>
                                <option value="beginner" {{ (old('difficulty_level', $workoutPlan->difficulty_level) == 'beginner') ? 'selected' : '' }}>{{ __('Beginner') }}</option>
                                <option value="intermediate" {{ (old('difficulty_level', $workoutPlan->difficulty_level) == 'intermediate') ? 'selected' : '' }}>{{ __('Intermediate') }}</option>
                                <option value="advanced" {{ (old('difficulty_level', $workoutPlan->difficulty_level) == 'advanced') ? 'selected' : '' }}>{{ __('Advanced') }}</option>
                            </select>
                            @error('difficulty_level')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex-1">
                            <label for="duration_weeks" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Duration (weeks)') }} <span class="text-red-500">*</span></label>
                            <input type="number" name="duration_weeks" id="duration_weeks" value="{{ old('duration_weeks', $workoutPlan->duration_weeks) }}" min="1" max="52" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50" required>
                            @error('duration_weeks')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Description') }} <span class="text-red-500">*</span></label>
                        <textarea name="description" id="description" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50" required>{{ old('description', $workoutPlan->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Exercises Section -->
            <div class="p-6" x-data="{ 
                exercises: [], 
                availableExercises: [],
                selectedDay: 1,
                days: [...Array(7).keys()].map(i => i + 1),
                init() {
                    this.availableExercises = JSON.parse(document.getElementById('availableExercises').textContent);
                    const planExercises = JSON.parse(document.getElementById('planExercises').textContent);
                    
                    this.exercises = planExercises.map(pe => ({
                        id: pe.id,
                        name: pe.name,
                        muscle_group: pe.muscle_group,
                        day: pe.pivot.day,
                        sets: pe.pivot.sets,
                        reps: pe.pivot.reps,
                        rest: pe.pivot.rest
                    }));
                    
                    this.updateExercisesValidation();
                },
                addExercise() {
                    const select = document.getElementById('exerciseSelect');
                    const exerciseId = select.value;
                    const exercise = this.availableExercises.find(e => e.id == exerciseId);
                    
                    if (!exercise) return;
                    
                    this.exercises.push({
                        id: exercise.id,
                        name: exercise.name,
                        muscle_group: exercise.muscle_group,
                        day: this.selectedDay,
                        sets: 3,
                        reps: 10,
                        rest: 60
                    });
                    
                    this.updateExercisesValidation();
                },
                removeExercise(index) {
                    this.exercises.splice(index, 1);
                    this.updateExercisesValidation();
                },
                updateExercisesValidation() {
                    // Check if element exists before setting its value
                    const validationInput = document.getElementById('exercisesValidation');
                    if (validationInput) {
                        validationInput.value = this.exercises.length > 0 ? 'valid' : '';
                    }
                }
            }">
                <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Exercises') }}</h2>
                
                <!-- Available exercises data -->
                <div id="availableExercises" class="hidden">{{ json_encode($exercises) }}</div>
                
                <!-- Current plan exercises data -->
                <div id="planExercises" class="hidden">{{ json_encode($planExercises) }}</div>
                
                <!-- Exercise selection -->
                <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="exerciseSelect" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Select Exercise') }}</label>
                            <select id="exerciseSelect" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50">
                                <option value="">{{ __('-- Select an exercise --') }}</option>
                                <template x-for="exercise in availableExercises" :key="exercise.id">
                                    <option :value="exercise.id" x-text="exercise.name + ' (' + exercise.muscle_group + ')'"></option>
                                </template>
                            </select>
                        </div>
                        
                        <div>
                            <label for="daySelect" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Day') }}</label>
                            <select id="daySelect" x-model="selectedDay" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50">
                                <template x-for="day in days" :key="day">
                                    <option :value="day" x-text="'Day ' + day"></option>
                                </template>
                            </select>
                        </div>
                        
                        <div class="flex items-end">
                            <button type="button" @click="addExercise()" class="w-full inline-flex justify-center items-center px-4 py-2 bg-splitify-teal border border-transparent rounded-md text-sm font-semibold text-white shadow-sm hover:bg-splitify-navy focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-splitify-teal">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                {{ __('Add Exercise') }}
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
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Day') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Exercise') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Sets') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Reps') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Rest (sec)') }}</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <template x-if="exercises.length === 0">
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                            {{ __('No exercises added yet. Add exercises to your workout plan.') }}
                                        </td>
                                    </tr>
                                </template>
                                <template x-for="(exercise, index) in exercises" :key="index">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" x-text="'Day ' + exercise.day"></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900" x-text="exercise.name"></div>
                                            <div class="text-xs text-gray-500" x-text="exercise.muscle_group"></div>
                                            <input type="hidden" :name="'exercises[' + index + ']'" :value="exercise.id">
                                            <input type="hidden" :name="'day[' + index + ']'" :value="exercise.day">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="number" :name="'sets[' + index + ']'" x-model="exercise.sets" min="1" max="10" class="w-16 rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="number" :name="'reps[' + index + ']'" x-model="exercise.reps" min="1" max="100" class="w-16 rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="number" :name="'rest[' + index + ']'" x-model="exercise.rest" min="0" max="300" class="w-16 rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50">
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
                
                @error('exercises_validation')
                    <p class="mt-2 text-sm text-red-600">{{ __('You must add at least one exercise to your workout plan.') }}</p>
                @enderror
            </div>
            
            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 text-right space-x-2">
                <a href="{{ route('workout-plans.show', $workoutPlan) }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-splitify-teal">
                    {{ __('Cancel') }}
                </a>
                <input type="hidden" id="exercisesValidation" name="exercises_validation" value="" required>
                <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-splitify-teal hover:bg-splitify-navy focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-splitify-teal">
                    {{ __('Save Changes') }}
                </button>
            </div>
        </div>
    </form>
</x-splitify-layout> 