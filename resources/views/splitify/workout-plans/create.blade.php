<x-splitify-layout>
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Create Workout Plan') }}</h1>
            <a href="{{ route('workout-plans.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-full text-sm font-semibold text-gray-700 hover:bg-gray-300 transition-all duration-300 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Back to Plans') }}
            </a>
        </div>
        <p class="mt-1 text-sm text-gray-500">{{ __('Create a new workout routine with exercises, sets, and reps') }}</p>
    </div>

    <form action="{{ route('workout-plans.store') }}" method="POST" id="createWorkoutForm" @submit="prepareExercisesForSubmission(); submitForm() && $event.target.submit()">
        @csrf
        
        <div x-data="{ 
            step: 1, 
            exercises: [], 
            availableExercises: [],
            activeDay: 1,
            days: [...Array(7).keys()].map(i => i + 1),
            planTitle: '',
            planDescription: '',
            planDuration: 8,
            selectedMuscleGroup: null,
            muscleGroups: [
                {name: 'Chest', key: 'chest', image: 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8Y2hlc3QlMjB3b3Jrb3V0fGVufDB8fDB8fHww&auto=format&fit=crop&w=500&q=60'},
                {name: 'Back', key: 'back', image: 'https://images.unsplash.com/photo-1603287681836-b174ce5074c2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8YmFjayUyMHdvcmtvdXR8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=500&q=60'},
                {name: 'Shoulders', key: 'shoulders', image: 'https://images.unsplash.com/photo-1585152968992-d2b9444408cc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8c2hvdWxkZXIlMjB3b3Jrb3V0fGVufDB8fDB8fHww&auto=format&fit=crop&w=500&q=60'},
                {name: 'Arms', key: 'arms', image: 'https://images.unsplash.com/photo-1590507621108-433608c97823?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8YXJtcyUyMHdvcmtvdXR8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=500&q=60'},
                {name: 'Legs', key: 'legs', image: 'https://images.unsplash.com/photo-1434682881908-b43d0467b798?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8bGVnJTIwd29ya291dHxlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=500&q=60'},
                {name: 'Core', key: 'core', image: 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8YWJzJTIwd29ya291dHxlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=500&q=60'},
                {name: 'Full Body', key: 'full_body', image: 'https://images.unsplash.com/photo-1549060279-7e168fcee0c2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8ZnVsbCUyMGJvZHklMjB3b3Jrb3V0fGVufDB8fDB8fHww&auto=format&fit=crop&w=500&q=60'},
                {name: 'Cardio', key: 'cardio', image: 'https://images.unsplash.com/photo-1538805060514-97d9cc17730c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OXx8Y2FyZGlvfGVufDB8fDB8fHww&auto=format&fit=crop&w=500&q=60'}
            ],
            popularPlans: [
                {name: 'Push/Pull/Legs (PPL)', description: '3-day split focusing on pushing muscles, pulling muscles, and legs'},
                {name: 'Upper/Lower Split', description: '4-day split alternating between upper body and lower body workouts'},
                {name: 'Full Body', description: 'Total body workout performed 3 times per week'},
                {name: 'Bro Split', description: '5-day split with each day focusing on a different body part'},
                {name: 'Custom Plan', description: 'Create your own custom workout plan'}
            ],
            selectedTemplate: null,
            filteredExercises: [],
            dayNames: ['Push Day', 'Pull Day', 'Leg Day', 'Upper Body', 'Lower Body', 'Rest Day', 'Full Body'],
            dayName: '',
            exercisesByDay: {},
            allExercises: [],
            init() {
                this.availableExercises = JSON.parse(document.getElementById('availableExercises').textContent);
                this.exercises = [];
                this.exercisesByDay = {};
                this.allExercises = [];
                for (let i = 1; i <= 7; i++) {
                    this.exercisesByDay[i] = [];
                }
                this.filteredExercises = this.availableExercises;
            },
            nextStep() {
                if (this.step === 1) {
                    if (!this.planTitle || !this.planDescription) {
                        alert('Please fill in all required fields');
                        return;
                    }
                } else if (this.step === 3) {
                    let hasExercises = false;
                    for (const day in this.exercisesByDay) {
                        if (this.exercisesByDay[day].length > 0) {
                            hasExercises = true;
                            break;
                        }
                    }
                    if (!hasExercises) {
                        alert('Please add at least one exercise to your workout plan');
                        return;
                    }
                    // Add validation field when submitting
                    document.getElementById('exercisesValidation').value = 'has-exercises';
                    
                    // Prepare all exercises for submission
                    this.prepareExercisesForSubmission();
                }
                this.step++;
            },
            prevStep() {
                this.step--;
            },
            prepareExercisesForSubmission() {
                // Clear previous data
                this.allExercises = [];
                
                // For each day in the exercisesByDay object
                for (const day in this.exercisesByDay) {
                    // For each exercise in that day
                    this.exercisesByDay[day].forEach(exercise => {
                        // Add to allExercises with the day value
                        this.allExercises.push({
                            id: exercise.id,
                            day: parseInt(day),
                            sets: exercise.sets,
                            reps: exercise.reps,
                            rest: exercise.rest
                        });
                    });
                }
            },
            submitForm() {
                // Make sure exercises_validation is set
                if (this.step === 4) {
                    // Double check validation is set
                    let hasExercises = false;
                    for (const day in this.exercisesByDay) {
                        if (this.exercisesByDay[day].length > 0) {
                            hasExercises = true;
                            break;
                        }
                    }
                    
                    if (hasExercises) {
                        // Set the hidden fields before submission
                        document.getElementById('exercisesValidation').value = 'has-exercises';
                        
                        // Prepare all exercises again to make sure we have the latest data
                        this.prepareExercisesForSubmission();
                        
                        console.log('Form submission allowed');
                        return true; // Allow form submission
                    } else {
                        alert('Please add at least one exercise to your workout plan');
                        this.step = 3; // Go back to exercises step
                        return false; // Prevent form submission
                    }
                }
                return false; // Only allow submission in step 4
            },
            selectMuscleGroup(group) {
                this.selectedMuscleGroup = group;
                this.filteredExercises = this.availableExercises.filter(e => e.muscle_group.toLowerCase().includes(group.key.toLowerCase()));
            },
            addExercise(exercise) {
                this.exercisesByDay[this.activeDay].push({
                    id: exercise.id,
                    name: exercise.name,
                    muscle_group: exercise.muscle_group,
                    day: this.activeDay, // Store day directly with exercise
                    sets: 3,
                    reps: 10,
                    rest: 60
                });
            },
            removeExercise(dayIndex, exerciseIndex) {
                this.exercisesByDay[dayIndex].splice(exerciseIndex, 1);
            },
            moveExerciseUp(dayIndex, exerciseIndex) {
                if (exerciseIndex > 0) {
                    const exercise = this.exercisesByDay[dayIndex][exerciseIndex];
                    this.exercisesByDay[dayIndex].splice(exerciseIndex, 1);
                    this.exercisesByDay[dayIndex].splice(exerciseIndex - 1, 0, exercise);
                }
            },
            moveExerciseDown(dayIndex, exerciseIndex) {
                if (exerciseIndex < this.exercisesByDay[dayIndex].length - 1) {
                    const exercise = this.exercisesByDay[dayIndex][exerciseIndex];
                    this.exercisesByDay[dayIndex].splice(exerciseIndex, 1);
                    this.exercisesByDay[dayIndex].splice(exerciseIndex + 1, 0, exercise);
                }
            },
            setDayName(day, name) {
                this.dayName = name;
            },
            clearExercises() {
                this.exercisesByDay[this.activeDay] = [];
            },
            getDayName(day) {
                return this.dayNames[day % 7];
            },
            selectTemplate(template) {
                this.selectedTemplate = template;
                if (template.name === 'Push/Pull/Legs (PPL)') {
                    this.planTitle = 'Push/Pull/Legs Split';
                    this.planDescription = 'A 6-day split targeting push muscles (chest, shoulders, triceps), pull muscles (back, biceps), and legs.';
                    this.planDuration = 8;
                } else if (template.name === 'Upper/Lower Split') {
                    this.planTitle = 'Upper/Lower Split';
                    this.planDescription = 'A 4-day split alternating between upper body and lower body workouts.';
                    this.planDuration = 8;
                } else if (template.name === 'Full Body') {
                    this.planTitle = 'Full Body Workout';
                    this.planDescription = 'A full body workout performed 3 times per week.';
                    this.planDuration = 8;
                } else if (template.name === 'Bro Split') {
                    this.planTitle = 'Bro Split';
                    this.planDescription = 'A 5-day split with each day focusing on a different muscle group.';
                    this.planDuration = 8;
                }
            }
        }" class="space-y-6" id="workoutForm">
            <!-- Hidden validation field for exercises -->
            <input type="hidden" id="exercisesValidation" name="exercises_validation" value="">
            
            <!-- Available exercises data -->
            <div id="availableExercises" class="hidden">{{ json_encode($exercises) }}</div>
            
            <!-- Progress Bar -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex justify-between mb-2">
                    <div class="text-sm font-medium" :class="{'text-teal-600': step >= 1, 'text-gray-500': step < 1}">Plan Details</div>
                    <div class="text-sm font-medium" :class="{'text-teal-600': step >= 2, 'text-gray-500': step < 2}">Select Template</div>
                    <div class="text-sm font-medium" :class="{'text-teal-600': step >= 3, 'text-gray-500': step < 3}">Add Exercises</div>
                    <div class="text-sm font-medium" :class="{'text-teal-600': step >= 4, 'text-gray-500': step < 4}">Review</div>
                </div>
                <div class="splitify-progress">
                    <div class="splitify-progress-bar" :style="`width: ${step * 25}%`"></div>
                </div>
            </div>
            
            <!-- Step 1: Plan Details -->
            <div x-show="step === 1" class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Plan Details') }}</h2>
                
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Title') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" x-model="planTitle" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50" required>
                        @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Duration (weeks)') }} <span class="text-red-500">*</span></label>
                            <input type="number" name="duration" id="duration" x-model="planDuration" min="1" max="52" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50" required>
                            @error('duration')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Description') }} <span class="text-red-500">*</span></label>
                            <textarea name="description" id="description" x-model="planDescription" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50" required></textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
                <div class="px-6 py-4 bg-gray-50 text-right">
                    <button type="button" @click="nextStep()" class="splitify-btn splitify-btn-primary">
                        {{ __('Next: Choose Template') }} &rarr;
                    </button>
                </div>
            </div>
            
            <!-- Step 2: Select Template -->
            <div x-show="step === 2" class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Choose a Template') }}</h2>
                    <p class="text-sm text-gray-500 mb-6">{{ __('Start with a popular template or create your own custom workout plan.') }}</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <template x-for="(template, index) in popularPlans" :key="index">
                            <div @click="selectTemplate(template)" class="p-4 border rounded-lg cursor-pointer transition-all duration-300 hover:shadow-md" :class="selectedTemplate && selectedTemplate.name === template.name ? 'border-teal-500 bg-teal-50' : 'border-gray-200'">
                                <h3 class="font-medium" x-text="template.name"></h3>
                                <p class="text-sm text-gray-500 mt-1" x-text="template.description"></p>
                            </div>
                        </template>
                    </div>
                </div>
                
                <div class="px-6 py-4 bg-gray-50 flex justify-between">
                    <button type="button" @click="prevStep()" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-full text-sm font-semibold text-gray-700 hover:bg-gray-300 transition-all duration-300 ease-in-out">
                        &larr; {{ __('Back') }}
                    </button>
                    <button type="button" @click="nextStep()" class="splitify-btn splitify-btn-primary">
                        {{ __('Next: Add Exercises') }} &rarr;
                    </button>
                </div>
                        </div>
                        
            <!-- Step 3: Add Exercises -->
            <div x-show="step === 3" class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-medium text-gray-900">{{ __('Add Exercises') }}</h2>
                        <div class="flex space-x-2">
                            <select x-model="activeDay" class="rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50">
                                <template x-for="day in days" :key="day">
                                    <option :value="day" x-text="'Day ' + day"></option>
                                </template>
                            </select>
                            <button type="button" @click="clearExercises()" class="px-3 py-1 text-xs bg-red-100 text-red-600 rounded-full hover:bg-red-200">
                                {{ __('Clear Day') }}
                            </button>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Left: Muscle Group Selection -->
                        <div class="flex flex-col space-y-4">
                            <h3 class="font-medium text-sm uppercase text-gray-500">{{ __('Filter by Muscle Group') }}</h3>
                            <div class="grid grid-cols-2 gap-3">
                                <template x-for="group in muscleGroups" :key="group.key">
                                    <button type="button" @click="selectMuscleGroup(group)" class="cursor-pointer rounded-lg overflow-hidden transition-all duration-300 block p-0 m-0 w-full text-left" :class="selectedMuscleGroup && selectedMuscleGroup.key === group.key ? 'ring-2 ring-teal-500' : ''">
                                        <div class="h-20 bg-cover bg-center" :style="`background-image: url('${group.image}')`"></div>
                                        <div class="p-2 text-center bg-gray-100 text-sm font-medium" x-text="group.name"></div>
                                    </button>
                                </template>
                            </div>
                            <button type="button" @click="selectedMuscleGroup = null; filteredExercises = availableExercises" class="text-sm text-teal-600 mt-2 hover:underline">
                                {{ __('Show All Exercises') }}
                            </button>
                        </div>
                        
                        <!-- Middle: Exercise List -->
                        <div class="border rounded-lg p-4 h-96 overflow-y-auto">
                            <h3 class="font-medium text-sm uppercase text-gray-500 mb-3">{{ __('Available Exercises') }}</h3>
                            
                            <div class="divide-y">
                                <template x-for="(exercise, index) in filteredExercises" :key="exercise.id">
                                    <div class="py-3 flex justify-between items-center">
                                        <div>
                                            <p class="font-medium text-sm" x-text="exercise.name"></p>
                                            <p class="text-xs text-gray-500" x-text="exercise.muscle_group"></p>
                                        </div>
                                        <button type="button" @click="addExercise(exercise)" class="p-1 rounded-full bg-teal-100 text-teal-600 hover:bg-teal-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                        </button>
                                    </div>
                                </template>
                                <template x-if="filteredExercises.length === 0">
                                    <div class="py-4 text-center text-gray-500">
                                        {{ __('No exercises found for this muscle group.') }}
                                    </div>
                                </template>
                            </div>
                        </div>
                        
                        <!-- Right: Selected Exercises -->
                        <div class="border rounded-lg p-4 h-96 overflow-y-auto">
                            <h3 class="font-medium text-sm uppercase text-gray-500 mb-1">
                                {{ __('Day') }} <span x-text="activeDay"></span> {{ __('Exercises') }}
                            </h3>
                            <input type="text" x-model="dayName" placeholder="Day name (e.g. Push Day)" class="w-full text-sm mb-3 p-2 border rounded">
                            
                            <div class="divide-y">
                                <template x-for="(exercise, index) in exercisesByDay[activeDay]" :key="index">
                                    <div class="py-3">
                                        <div class="flex justify-between items-center mb-2">
                                            <div>
                                                <p class="font-medium text-sm" x-text="exercise.name"></p>
                                                <p class="text-xs text-gray-500" x-text="exercise.muscle_group"></p>
                                            </div>
                                            <div class="flex space-x-1">
                                                <button @click="moveExerciseUp(activeDay, index)" type="button" class="p-1 rounded bg-gray-100 text-gray-600 hover:bg-gray-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                                    </svg>
                                                </button>
                                                <button @click="moveExerciseDown(activeDay, index)" type="button" class="p-1 rounded bg-gray-100 text-gray-600 hover:bg-gray-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </button>
                                                <button @click="removeExercise(activeDay, index)" type="button" class="p-1 rounded bg-red-100 text-red-600 hover:bg-red-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                            </button>
                                            </div>
                                        </div>
                                        
                                        <div class="grid grid-cols-3 gap-2">
                                            <div>
                                                <label class="text-xs text-gray-500">Sets</label>
                                                <input type="number" :name="`sets[]`" x-model="exercise.sets" min="1" max="10" class="w-full p-1 text-sm border rounded">
                                            </div>
                                            <div>
                                                <label class="text-xs text-gray-500">Reps</label>
                                                <input type="number" :name="`reps[]`" x-model="exercise.reps" min="1" max="100" class="w-full p-1 text-sm border rounded">
                                            </div>
                                            <div>
                                                <label class="text-xs text-gray-500">Rest (sec)</label>
                                                <input type="number" :name="`rest[]`" x-model="exercise.rest" min="0" max="300" class="w-full p-1 text-sm border rounded">
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <template x-if="exercisesByDay[activeDay].length === 0">
                                    <div class="py-4 text-center text-gray-500">
                                        {{ __('No exercises added to this day yet.') }} <br>
                                        {{ __('Select exercises from the list on the left.') }}
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="px-6 py-4 bg-gray-50 flex justify-between">
                    <button type="button" @click="prevStep()" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-full text-sm font-semibold text-gray-700 hover:bg-gray-300 transition-all duration-300 ease-in-out">
                        &larr; {{ __('Back') }}
                    </button>
                    <button type="button" @click="nextStep()" class="splitify-btn splitify-btn-primary">
                        {{ __('Next: Review Plan') }} &rarr;
                    </button>
                </div>
            </div>
            
            <!-- Step 4: Review -->
            <div x-show="step === 4" class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Review Your Workout Plan') }}</h2>
                    
                    <div class="mb-8">
                        <h3 class="font-medium text-gray-900 mb-1" x-text="planTitle"></h3>
                        <p class="text-sm text-gray-500 mb-2" x-text="planDescription"></p>
                        <div class="flex space-x-4 text-sm">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span x-text="planDuration + ' weeks'"></span>
                            </span>
                        </div>
                    </div>

                    <!-- Hidden form fields for exercises data -->
                    <div>
                        <template x-for="(exercise, index) in allExercises" :key="index">
                            <div>
                                <input type="hidden" :name="`exercises[]`" :value="exercise.id">
                                <input type="hidden" :name="`day[]`" :value="exercise.day">
                                <input type="hidden" :name="`sets[]`" :value="exercise.sets">
                                <input type="hidden" :name="`reps[]`" :value="exercise.reps">
                                <input type="hidden" :name="`rest[]`" :value="exercise.rest">
                            </div>
                        </template>
                    </div>
                    
                    <div class="space-y-6">
                        <template x-for="day in days" :key="day">
                            <template x-if="exercisesByDay[day].length > 0">
                                <div class="border rounded-lg overflow-hidden">
                                    <div class="bg-gray-50 p-3 border-b">
                                        <h3 class="font-medium">Day <span x-text="day"></span></h3>
                                    </div>
                                    <div class="p-4">
                                        <div class="divide-y">
                                            <template x-for="(exercise, index) in exercisesByDay[day]" :key="index">
                                                <div class="py-3 flex justify-between">
                                                    <div>
                                                        <p class="font-medium text-sm" x-text="exercise.name"></p>
                                                        <p class="text-xs text-gray-500">
                                                            <span x-text="exercise.muscle_group"></span> | 
                                                            <span x-text="exercise.sets + ' sets'"></span> × 
                                                            <span x-text="exercise.reps + ' reps'"></span> | 
                                                            <span x-text="exercise.rest + 's rest'"></span>
                                                        </p>
                                                    </div>
                                                    <div class="text-sm font-medium text-gray-500" x-text="index + 1"></div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                </template>
                                </template>
                    </div>
                </div>
                
                <div class="px-6 py-4 bg-gray-50 flex justify-between">
                    <button type="button" @click="prevStep()" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-full text-sm font-semibold text-gray-700 hover:bg-gray-300 transition-all duration-300 ease-in-out">
                        &larr; {{ __('Back') }}
                    </button>
                <button type="submit" class="splitify-btn splitify-btn-primary">
                    {{ __('Create Workout Plan') }}
                </button>
                </div>
            </div>
        </div>
    </form>
</x-splitify-layout> 