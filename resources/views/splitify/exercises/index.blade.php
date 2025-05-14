<x-splitify-layout>
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Exercise Library') }}</h1>
            @can('create', App\Models\Exercise::class)
                <a href="{{ route('exercises.create') }}" class="inline-flex items-center px-4 py-2 bg-splitify-teal border border-transparent rounded-full text-sm font-semibold text-white shadow-sm hover:bg-splitify-navy transition-all duration-300 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    {{ __('Add Exercise') }}
                </a>
            @endcan
        </div>
        <p class="mt-1 text-sm text-gray-500">{{ __('Browse our collection of exercises for your workouts') }}</p>
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
        <form action="{{ route('exercises.index') }}" method="GET" class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
            <div class="flex-1">
                <label for="muscle_group" class="block text-xs font-medium text-gray-500 mb-1">{{ __('Muscle Group') }}</label>
                <select id="muscle_group" name="muscle_group" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50 text-sm">
                    <option value="all" {{ request('muscle_group', 'all') === 'all' ? 'selected' : '' }}>{{ __('All Muscle Groups') }}</option>
                    @foreach($muscleGroups as $group)
                        <option value="{{ $group }}" {{ request('muscle_group') === $group ? 'selected' : '' }}>{{ ucfirst($group) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1">
                <label for="equipment" class="block text-xs font-medium text-gray-500 mb-1">{{ __('Equipment') }}</label>
                <select id="equipment" name="equipment" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50 text-sm">
                    <option value="all" {{ request('equipment', 'all') === 'all' ? 'selected' : '' }}>{{ __('All Equipment') }}</option>
                    @foreach($equipment as $item)
                        <option value="{{ $item }}" {{ request('equipment') === $item ? 'selected' : '' }}>{{ ucfirst($item) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 md:flex-2">
                <label for="search" class="block text-xs font-medium text-gray-500 mb-1">{{ __('Search') }}</label>
                <div class="relative flex">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="search" name="search" value="{{ request('search') }}" class="block w-full pl-10 rounded-l-md border-gray-300 shadow-sm focus:border-splitify-teal focus:ring focus:ring-splitify-teal focus:ring-opacity-50 text-sm" placeholder="{{ __('Search exercises...') }}">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-splitify-teal border border-transparent rounded-r-md text-sm font-medium text-white shadow-sm hover:bg-splitify-navy focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-splitify-teal">
                        {{ __('Filter') }}
                    </button>
                </div>
            </div>
        </form>
        
        @if(request('search') || (request('muscle_group') && request('muscle_group') != 'all') || (request('equipment') && request('equipment') != 'all'))
            <div class="mt-3 flex items-center">
                <span class="text-xs text-gray-500 mr-2">
                    Filtered by: 
                    @if(request('search'))
                        Search "{{ request('search') }}"
                    @endif
                    
                    @if(request('muscle_group') && request('muscle_group') != 'all')
                        @if(request('search')) | @endif
                        Muscle group: {{ ucfirst(request('muscle_group')) }}
                    @endif
                    
                    @if(request('equipment') && request('equipment') != 'all')
                        @if(request('search') || (request('muscle_group') && request('muscle_group') != 'all')) | @endif
                        Equipment: {{ ucfirst(request('equipment')) }}
                    @endif
                </span>
                <a href="{{ route('exercises.index') }}" class="text-xs text-splitify-teal hover:text-splitify-navy">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Clear filters
                    </span>
                </a>
            </div>
        @endif
    </div>

    <!-- Exercises Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($exercises as $exercise)
            <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300">
                <div class="aspect-w-16 aspect-h-9 bg-gray-100">
                    @if ($exercise->media_url)
                        <img src="{{ $exercise->media_url }}" alt="{{ $exercise->name }}" class="object-cover">
                    @else
                        <div class="flex items-center justify-center h-full bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="p-5">
                    <div class="flex justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $exercise->name }}</h3>
                    </div>
                    <div class="flex flex-wrap gap-2 mb-3">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ ucfirst($exercise->muscle_group) }}
                        </span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            {{ ucfirst($exercise->equipment) }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 line-clamp-2 mb-3">{{ Str::limit($exercise->instructions, 100) }}</p>
                    <div class="flex justify-between items-center">
                        <a href="{{ route('exercises.show', $exercise) }}" class="text-sm font-medium text-splitify-teal hover:text-splitify-navy">
                            {{ __('View Details') }}
                        </a>
                        @can('update', $exercise)
                            <div class="flex space-x-2">
                                <a href="{{ route('exercises.edit', $exercise) }}" class="text-gray-400 hover:text-splitify-teal">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <button onclick="confirmDelete('{{ $exercise->id }}')" class="text-gray-400 hover:text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-lg shadow-sm p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-1">{{ __('No exercises found') }}</h3>
                <p class="text-sm text-gray-500 mb-4">{{ __('Try adjusting your search or filter to find what you\'re looking for.') }}</p>
                <a href="{{ route('exercises.index') }}" class="inline-flex items-center px-4 py-2 bg-splitify-teal border border-transparent rounded-full text-sm font-semibold text-white shadow-sm hover:bg-splitify-navy transition-all duration-300 ease-in-out">
                    {{ __('Clear Filters') }}
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $exercises->withQueryString()->links() }}
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-data="{ open: false, exerciseId: null }" x-show="open" x-cloak class="fixed inset-0 z-50 overflow-y-auto" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
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
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">{{ __('Delete Exercise') }}</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">{{ __('Are you sure you want to delete this exercise? It may be used in workout plans. This action cannot be undone.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form id="deleteForm" method="POST" x-bind:action="'/exercises/' + exerciseId">
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
        function confirmDelete(exerciseId) {
            Alpine.store('deleteModal').exerciseId = exerciseId;
            Alpine.store('deleteModal').open = true;
        }

        document.addEventListener('alpine:init', () => {
            Alpine.store('deleteModal', {
                open: false,
                exerciseId: null
            });
        });
        
        // Handle Enter key for search
        document.getElementById('search').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                this.form.submit();
            }
        });
    </script>
</x-splitify-layout> 