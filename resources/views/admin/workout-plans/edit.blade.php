<x-layouts.admin>
    <x-slot name="header">Edit Workout Plan</x-slot>

    <div class="max-w-4xl mx-auto py-6">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form method="POST" action="{{ route('admin.workout-plans.update', $workoutPlan) }}">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Title -->
                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $workoutPlan->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" name="description" rows="4" required>{{ old('description', $workoutPlan->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Difficulty Level -->
                            <div>
                                <x-input-label for="difficulty_level" :value="__('Difficulty Level')" />
                                <select id="difficulty_level" name="difficulty_level" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="beginner" {{ old('difficulty_level', $workoutPlan->difficulty_level) === 'beginner' ? 'selected' : '' }}>Beginner</option>
                                    <option value="intermediate" {{ old('difficulty_level', $workoutPlan->difficulty_level) === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    <option value="advanced" {{ old('difficulty_level', $workoutPlan->difficulty_level) === 'advanced' ? 'selected' : '' }}>Advanced</option>
                                </select>
                                <x-input-error :messages="$errors->get('difficulty_level')" class="mt-2" />
                            </div>

                            <!-- Duration Weeks -->
                            <div>
                                <x-input-label for="duration_weeks" :value="__('Duration (weeks)')" />
                                <x-text-input id="duration_weeks" class="block mt-1 w-full" type="number" name="duration_weeks" :value="old('duration_weeks', $workoutPlan->duration_weeks)" min="1" max="52" required />
                                <x-input-error :messages="$errors->get('duration_weeks')" class="mt-2" />
                            </div>

                            <!-- Sessions Per Week -->
                            <div>
                                <x-input-label for="sessions_per_week" :value="__('Sessions Per Week')" />
                                <x-text-input id="sessions_per_week" class="block mt-1 w-full" type="number" name="sessions_per_week" :value="old('sessions_per_week', $workoutPlan->sessions_per_week)" min="1" max="7" required />
                                <x-input-error :messages="$errors->get('sessions_per_week')" class="mt-2" />
                            </div>

                            <!-- Visibility Options -->
                            <div class="space-y-2">
                                <div class="flex items-center space-x-2">
                                    <input id="is_public" name="is_public" type="checkbox" value="1" {{ old('is_public', $workoutPlan->is_public) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <label for="is_public" class="font-medium text-sm text-gray-700">Make Public</label>
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    <input id="is_template" name="is_template" type="checkbox" value="1" {{ old('is_template', $workoutPlan->is_template) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <label for="is_template" class="font-medium text-sm text-gray-700">Use as Template</label>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.workout-plans') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                            <x-primary-button>
                                {{ __('Update Workout Plan') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin> 