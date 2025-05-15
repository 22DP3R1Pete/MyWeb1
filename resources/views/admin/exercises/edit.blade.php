<x-layouts.admin>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Exercise') }}: {{ $exercise->name }}
            </h2>
            <a href="{{ route('admin.exercises') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">Back to Exercises</a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                <form action="{{ route('admin.exercises.update', $exercise) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Exercise Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Exercise Name') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $exercise->name) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Muscle Group -->
                        <div>
                            <label for="muscle_group" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Muscle Group') }} <span class="text-red-500">*</span></label>
                            <select name="muscle_group" id="muscle_group" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50" required>
                                <option value="">{{ __('-- Select Muscle Group --') }}</option>
                                <option value="Chest" {{ old('muscle_group', $exercise->muscle_group) == 'Chest' ? 'selected' : '' }}>{{ __('Chest') }}</option>
                                <option value="Back" {{ old('muscle_group', $exercise->muscle_group) == 'Back' ? 'selected' : '' }}>{{ __('Back') }}</option>
                                <option value="Shoulders" {{ old('muscle_group', $exercise->muscle_group) == 'Shoulders' ? 'selected' : '' }}>{{ __('Shoulders') }}</option>
                                <option value="Arms" {{ old('muscle_group', $exercise->muscle_group) == 'Arms' ? 'selected' : '' }}>{{ __('Arms') }}</option>
                                <option value="Legs" {{ old('muscle_group', $exercise->muscle_group) == 'Legs' ? 'selected' : '' }}>{{ __('Legs') }}</option>
                                <option value="Core" {{ old('muscle_group', $exercise->muscle_group) == 'Core' ? 'selected' : '' }}>{{ __('Core') }}</option>
                                <option value="Full Body" {{ old('muscle_group', $exercise->muscle_group) == 'Full Body' ? 'selected' : '' }}>{{ __('Full Body') }}</option>
                                <option value="Cardio" {{ old('muscle_group', $exercise->muscle_group) == 'Cardio' ? 'selected' : '' }}>{{ __('Cardio') }}</option>
                            </select>
                            @error('muscle_group')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Equipment Needed -->
                        <div>
                            <label for="equipment_needed" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Equipment Needed') }} <span class="text-red-500">*</span></label>
                            <select name="equipment_needed" id="equipment_needed" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50" required>
                                <option value="">{{ __('-- Select Equipment --') }}</option>
                                <option value="None" {{ old('equipment_needed', $exercise->equipment_needed) == 'None' ? 'selected' : '' }}>{{ __('None (Bodyweight)') }}</option>
                                <option value="Dumbbells" {{ old('equipment_needed', $exercise->equipment_needed) == 'Dumbbells' ? 'selected' : '' }}>{{ __('Dumbbells') }}</option>
                                <option value="Barbell" {{ old('equipment_needed', $exercise->equipment_needed) == 'Barbell' ? 'selected' : '' }}>{{ __('Barbell') }}</option>
                                <option value="Kettlebell" {{ old('equipment_needed', $exercise->equipment_needed) == 'Kettlebell' ? 'selected' : '' }}>{{ __('Kettlebell') }}</option>
                                <option value="Machine" {{ old('equipment_needed', $exercise->equipment_needed) == 'Machine' ? 'selected' : '' }}>{{ __('Machine') }}</option>
                                <option value="Cable" {{ old('equipment_needed', $exercise->equipment_needed) == 'Cable' ? 'selected' : '' }}>{{ __('Cable') }}</option>
                                <option value="Resistance Band" {{ old('equipment_needed', $exercise->equipment_needed) == 'Resistance Band' ? 'selected' : '' }}>{{ __('Resistance Band') }}</option>
                                <option value="Other" {{ old('equipment_needed', $exercise->equipment_needed) == 'Other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                            </select>
                            @error('equipment_needed')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Difficulty -->
                        <div>
                            <label for="difficulty_level" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Difficulty') }} <span class="text-red-500">*</span></label>
                            <select name="difficulty_level" id="difficulty_level" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50" required>
                                <option value="">{{ __('-- Select Difficulty --') }}</option>
                                <option value="Beginner" {{ old('difficulty_level', $exercise->difficulty_level) == 'Beginner' ? 'selected' : '' }}>{{ __('Beginner') }}</option>
                                <option value="Intermediate" {{ old('difficulty_level', $exercise->difficulty_level) == 'Intermediate' ? 'selected' : '' }}>{{ __('Intermediate') }}</option>
                                <option value="Advanced" {{ old('difficulty_level', $exercise->difficulty_level) == 'Advanced' ? 'selected' : '' }}>{{ __('Advanced') }}</option>
                            </select>
                            @error('difficulty_level')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Instructions -->
                        <div class="md:col-span-2">
                            <label for="instructions" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Instructions') }} <span class="text-red-500">*</span></label>
                            <textarea name="instructions" id="instructions" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50" required>{{ old('instructions', $exercise->instructions) }}</textarea>
                            @error('instructions')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Current Image -->
                        @if($exercise->media_url)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Current Image') }}</label>
                            <div class="mt-1">
                                <img src="{{ $exercise->media_url }}" alt="{{ $exercise->name }}" class="h-40 w-auto rounded-md border border-gray-300">
                            </div>
                        </div>
                        @endif
                        
                        <!-- Media Upload -->
                        <div class="md:col-span-2">
                            <label for="media" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Change Image (Optional)') }}</label>
                            <input type="file" name="media" id="media" class="block w-full text-sm text-gray-500 
                                file:mr-4 file:py-2 file:px-4 file:rounded-md
                                file:border-0 file:text-sm file:font-medium
                                file:bg-teal-50 file:text-teal-700
                                hover:file:bg-teal-100">
                            <p class="mt-1 text-xs text-gray-500">Recommended size: 600x400px. Max file size: 2MB.</p>
                            @error('media')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('admin.exercises') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                            {{ __('Update Exercise') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin> 