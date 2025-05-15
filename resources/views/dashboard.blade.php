<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            
            @if (Auth::check() && Auth::user()->admin == 1)
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Admin Panel') }}
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-lg mb-4">{{ __('Welcome to Your Fitness Dashboard') }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg shadow">
                            <h4 class="font-medium text-gray-700">{{ __('Quick Links') }}</h4>
                            <div class="mt-2 space-y-1">
                                <a href="{{ route('profile.edit') }}" class="block text-indigo-600 hover:text-indigo-500">{{ __('Update Profile') }}</a>
                                <!-- Add more quick links here as you build functionality -->
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-blue-800">
                        <p>{{ __('Start tracking your workouts to see progress and statistics!') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
