<x-splitify-layout>
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Edit Exercise') }}</h1>
            <div class="flex space-x-2">
                <a href="{{ route('exercises.show', $exercise) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-full text-sm font-semibold text-gray-700 hover:bg-gray-300 transition-all duration-300 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    {{ __('View Exercise') }}
                </a>
                
                <a href="{{ route('exercises.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-full text-sm font-semibold text-gray-700 hover:bg-gray-300 transition-all duration-300 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Back to Exercise Library') }}
                </a>
            </div>
        </div>
        <p class="mt-1 text-sm text-gray-500">{{ __('Update exercise details') }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <form action="{{ route('exercises.update', $exercise) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Exercise Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Exercise Name') }} <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $exercise->name) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Muscle Group -->
                <div>
                    <label for="muscle_group" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Muscle Group') }} <span class="text-red-500">*</span></label>
                    <select name="muscle_group" id="muscle_group" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50" required>
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
                    <label for="equipment" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Equipment Needed') }}</label>
                    <select name="equipment" id="equipment" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50">
                        <option value="">{{ __('-- Select Equipment --') }}</option>
                        <option value="None" {{ old('equipment', $exercise->equipment) == 'None' ? 'selected' : '' }}>{{ __('None (Bodyweight)') }}</option>
                        <option value="Dumbbells" {{ old('equipment', $exercise->equipment) == 'Dumbbells' ? 'selected' : '' }}>{{ __('Dumbbells') }}</option>
                        <option value="Barbell" {{ old('equipment', $exercise->equipment) == 'Barbell' ? 'selected' : '' }}>{{ __('Barbell') }}</option>
                        <option value="Kettlebell" {{ old('equipment', $exercise->equipment) == 'Kettlebell' ? 'selected' : '' }}>{{ __('Kettlebell') }}</option>
                        <option value="Machine" {{ old('equipment', $exercise->equipment) == 'Machine' ? 'selected' : '' }}>{{ __('Machine') }}</option>
                        <option value="Cable" {{ old('equipment', $exercise->equipment) == 'Cable' ? 'selected' : '' }}>{{ __('Cable') }}</option>
                        <option value="Resistance Band" {{ old('equipment', $exercise->equipment) == 'Resistance Band' ? 'selected' : '' }}>{{ __('Resistance Band') }}</option>
                        <option value="Other" {{ old('equipment', $exercise->equipment) == 'Other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                    </select>
                    @error('equipment')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Difficulty -->
                <div>
                    <label for="difficulty" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Difficulty') }}</label>
                    <select name="difficulty" id="difficulty" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50">
                        <option value="">{{ __('-- Select Difficulty --') }}</option>
                        <option value="beginner" {{ old('difficulty', $exercise->difficulty) == 'beginner' ? 'selected' : '' }}>{{ __('Beginner') }}</option>
                        <option value="intermediate" {{ old('difficulty', $exercise->difficulty) == 'intermediate' ? 'selected' : '' }}>{{ __('Intermediate') }}</option>
                        <option value="advanced" {{ old('difficulty', $exercise->difficulty) == 'advanced' ? 'selected' : '' }}>{{ __('Advanced') }}</option>
                    </select>
                    @error('difficulty')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Instructions -->
                <div class="md:col-span-2">
                    <label for="instructions" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Instructions') }}</label>
                    <textarea name="instructions" id="instructions" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50">{{ old('instructions', $exercise->instructions) }}</textarea>
                    @error('instructions')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Notes -->
                <div class="md:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Notes') }}</label>
                    <textarea name="notes" id="notes" rows="2" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50">{{ old('notes', $exercise->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('exercises.show', $exercise) }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-splitify-teal">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-splitify-teal hover:bg-splitify-navy focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-splitify-teal">
                    {{ __('Update Exercise') }}
                </button>
            </div>
        </form>
    </div>
</x-splitify-layout> 