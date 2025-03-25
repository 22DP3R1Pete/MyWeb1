<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-lg mb-4">{{ __('Welcome to Your Fitness Dashboard') }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg shadow">
                            <h4 class="font-medium text-gray-700">{{ __('Your Stats') }}</h4>
                            <div class="mt-2 space-y-1">
                                @if(auth()->user()->height)
                                    <p><span class="font-medium">{{ __('Height') }}:</span> {{ auth()->user()->height }} cm</p>
                                @endif
                                
                                @if(auth()->user()->weight)
                                    <p><span class="font-medium">{{ __('Weight') }}:</span> {{ auth()->user()->weight }} kg</p>
                                @endif
                                
                                @if(auth()->user()->birth_year)
                                    <p><span class="font-medium">{{ __('Age') }}:</span> {{ auth()->user()->age }} years</p>
                                @endif
                            </div>
                            
                            @if(!auth()->user()->height && !auth()->user()->weight && !auth()->user()->birth_year)
                                <p class="mt-2 text-sm text-gray-500">{{ __('Complete your fitness profile to see your stats here.') }}</p>
                                <a href="{{ route('profile.edit') }}" class="mt-2 inline-block text-sm text-indigo-600 hover:text-indigo-500">{{ __('Update Profile') }}</a>
                            @endif
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg shadow">
                            <h4 class="font-medium text-gray-700">{{ __('Fitness Goals') }}</h4>
                            <div class="mt-2">
                                @if(auth()->user()->fitness_goals)
                                    <p class="text-sm">{{ auth()->user()->fitness_goals }}</p>
                                @else
                                    <p class="text-sm text-gray-500">{{ __('No fitness goals set yet.') }}</p>
                                    <a href="{{ route('profile.edit') }}" class="mt-2 inline-block text-sm text-indigo-600 hover:text-indigo-500">{{ __('Set Goals') }}</a>
                                @endif
                            </div>
                        </div>
                        
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
