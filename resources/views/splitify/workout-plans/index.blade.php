<x-splitify-layout>
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Workout Plans') }}</h1>
            <a href="{{ route('workout-plans.create') }}" class="inline-flex items-center px-4 py-2 bg-splitify-teal border border-transparent rounded-full text-sm font-semibold text-white shadow-sm hover:bg-splitify-navy transition-all duration-300 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('New Plan') }}
            </a>
        </div>
        <p class="mt-1 text-sm text-gray-500">{{ __('Create and manage your workout routines') }}</p>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
            <div class="flex-1">
                <label for="difficulty" class="block text-xs font-medium text-gray-500 mb-1">{{ __('Difficulty') }}</label>
                <select id="difficulty" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50 text-sm">
                    <option value="all">{{ __('All Difficulties') }}</option>
                    <option value="beginner">{{ __('Beginner') }}</option>
                    <option value="intermediate">{{ __('Intermediate') }}</option>
                    <option value="advanced">{{ __('Advanced') }}</option>
                </select>
            </div>
            <div class="flex-1">
                <label for="duration" class="block text-xs font-medium text-gray-500 mb-1">{{ __('Duration') }}</label>
                <select id="duration" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50 text-sm">
                    <option value="all">{{ __('All Durations') }}</option>
                    <option value="1-4">{{ __('1-4 weeks') }}</option>
                    <option value="5-8">{{ __('5-8 weeks') }}</option>
                    <option value="9-12">{{ __('9-12 weeks') }}</option>
                    <option value="13+">{{ __('13+ weeks') }}</option>
                </select>
            </div>
            <div class="flex-1 md:flex-2">
                <label for="search" class="block text-xs font-medium text-gray-500 mb-1">{{ __('Search') }}</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="search" class="block w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50 text-sm" placeholder="{{ __('Search plans...') }}">
                </div>
            </div>
        </div>
    </div>

    <!-- Workout Plans Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($workoutPlans as $plan)
            <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300">
                <div class="p-5">
                    <div class="flex justify-between items-start">
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $plan->title }}</h3>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $plan->difficulty === 'beginner' ? 'bg-green-100 text-green-800' : ($plan->difficulty === 'intermediate' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($plan->difficulty) }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 line-clamp-2 mb-3">{{ $plan->description }}</p>
                    <div class="flex items-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-xs text-gray-500">{{ $plan->duration }} {{ Str::plural('week', $plan->duration) }}</span>
                        <span class="mx-2 text-gray-300">•</span>
                        <span class="text-xs text-gray-500">{{ $plan->exercises->count() }} {{ Str::plural('exercise', $plan->exercises->count()) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <a href="{{ route('workout-plans.show', $plan) }}" class="text-sm font-medium text-splitify-teal hover:text-splitify-navy">
                            {{ __('View Details') }}
                        </a>
                        <div class="flex space-x-2">
                            <a href="{{ route('workout-plans.edit', $plan) }}" class="text-gray-400 hover:text-splitify-teal">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <button onclick="confirmDelete('{{ $plan->id }}')" class="text-gray-400 hover:text-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-lg shadow-sm p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-1">{{ __('No workout plans yet') }}</h3>
                <p class="text-sm text-gray-500 mb-4">{{ __('Create your first workout plan to get started with your fitness journey.') }}</p>
                <a href="{{ route('workout-plans.create') }}" class="inline-flex items-center px-4 py-2 bg-splitify-teal border border-transparent rounded-full text-sm font-semibold text-white shadow-sm hover:bg-splitify-navy transition-all duration-300 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    {{ __('Create Your First Plan') }}
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $workoutPlans->links() }}
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-data="{ open: false, planId: null }" x-show="open" x-cloak class="fixed inset-0 z-50 overflow-y-auto" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true" x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">{{ __('Delete Workout Plan') }}</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">{{ __('Are you sure you want to delete this workout plan? All of your data associated with this plan will be permanently removed. This action cannot be undone.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form id="deleteForm" method="POST" x-bind:action="'/workout-plans/' + planId">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">{{ __('Delete') }}</button>
                    </form>
                    <button @click="open = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">{{ __('Cancel') }}</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(planId) {
            Alpine.store('deleteModal').planId = planId;
            Alpine.store('deleteModal').open = true;
        }

        document.addEventListener('alpine:init', () => {
            Alpine.store('deleteModal', {
                open: false,
                planId: null
            });
        });
    </script>
</x-splitify-layout> 