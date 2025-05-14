<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Splitify') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    
    <!-- Styles -->
    <style>
        [x-cloak] { display: none !important; }
    </style>
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-800 font-sans">
    <div class="min-h-screen flex flex-col">
        <!-- Top Navigation -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="flex-shrink-0 flex items-center">
                            <span class="text-2xl font-bold text-splitify-navy">Splitify</span>
                        </a>
                    </div>
                    
                    <!-- Navigation -->
                    <div class="flex items-center">
                        <div class="hidden md:ml-6 md:flex md:items-center md:space-x-4">
                            <a href="{{ route('workout-plans.index') }}" class="px-3 py-2 text-sm font-medium {{ request()->routeIs('workout-plans.*') ? 'text-splitify-teal' : 'text-gray-700 hover:text-gray-900' }}">{{ __('Workout Plans') }}</a>
                            <a href="{{ route('exercises.index') }}" class="px-3 py-2 text-sm font-medium {{ request()->routeIs('exercises.*') ? 'text-splitify-teal' : 'text-gray-700 hover:text-gray-900' }}">{{ __('Exercise Library') }}</a>
                            <a href="{{ route('progress.index') }}" class="px-3 py-2 text-sm font-medium {{ request()->routeIs('progress.*') ? 'text-splitify-teal' : 'text-gray-700 hover:text-gray-900' }}">{{ __('Progress') }}</a>
                        </div>
                    </div>
                    
                    <!-- User Dropdown -->
                    <div class="ml-3 relative flex items-center">
                        <div x-data="{ open: false }" @click.away="open = false" class="relative">
                            <div>
                                <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none transition duration-150 ease-in-out">
                                    <span class="mr-2">{{ Auth::user()->name }}</span>
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 rounded-md shadow-lg origin-top-right" style="display: none;">
                                <div class="py-1 rounded-md bg-white shadow-xs">
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Profile') }}</a>
                                    
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            {{ __('Log Out') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mobile menu button -->
                    <div class="flex items-center -mr-2 md:hidden">
                        <button x-data="{ open: false }" @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </header>
        
        <div class="flex flex-1">
            <!-- Sidebar -->
            <aside class="hidden md:block md:w-64 border-r border-gray-200 px-4 py-6">
                <div class="mb-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Menu') }}</h3>
                    <div class="mt-3">
                        <a href="{{ route('dashboard') }}" class="flex items-center py-3 px-4 rounded-lg mb-1 transition-all duration-300 ease-in-out text-gray-700 hover:bg-splitify-teal/10 {{ request()->routeIs('dashboard') ? 'bg-splitify-teal text-white' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span>{{ __('Dashboard') }}</span>
                        </a>
                        
                        <a href="{{ route('workout-plans.index') }}" class="flex items-center py-3 px-4 rounded-lg mb-1 transition-all duration-300 ease-in-out text-gray-700 hover:bg-splitify-teal/10 {{ request()->routeIs('workout-plans.*') ? 'bg-splitify-teal text-white' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <span>{{ __('My Workouts') }}</span>
                        </a>
                        
                        <a href="{{ route('exercises.index') }}" class="flex items-center py-3 px-4 rounded-lg mb-1 transition-all duration-300 ease-in-out text-gray-700 hover:bg-splitify-teal/10 {{ request()->routeIs('exercises.*') ? 'bg-splitify-teal text-white' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <span>{{ __('Exercise Library') }}</span>
                        </a>
                        
                        <a href="{{ route('progress.index') }}" class="flex items-center py-3 px-4 rounded-lg mb-1 transition-all duration-300 ease-in-out text-gray-700 hover:bg-splitify-teal/10 {{ request()->routeIs('progress.*') ? 'bg-splitify-teal text-white' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                            </svg>
                            <span>{{ __('Progress') }}</span>
                        </a>
                        
                        <a href="{{ route('profile.edit') }}" class="flex items-center py-3 px-4 rounded-lg mb-1 transition-all duration-300 ease-in-out text-gray-700 hover:bg-splitify-teal/10 {{ request()->routeIs('profile.*') ? 'bg-splitify-teal text-white' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>{{ __('Profile') }}</span>
                        </a>
                    </div>
                </div>
                
                <!-- Current Plan -->
                <div class="mb-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Current Plan') }}</h3>
                    <div class="mt-3 p-4 bg-white rounded-lg shadow-sm">
                        <h4 class="font-medium text-sm mb-1">{{ __('PPL Split') }}</h4>
                        <div class="h-2 bg-gray-200 rounded overflow-hidden mb-2">
                            <div class="h-full bg-gradient-primary rounded" style="width: 60%;"></div>
                        </div>
                        <p class="text-xs text-gray-500">{{ __('Week 3 of 8') }}</p>
                    </div>
                </div>
                
                <!-- Today's Workout -->
                <div>
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Today') }}</h3>
                    <div class="mt-3 p-4 bg-white rounded-lg shadow-sm">
                        <h4 class="font-medium text-sm">{{ __('Push Day') }}</h4>
                        <p class="text-xs text-gray-500 mb-3">{{ __('5 exercises') }}</p>
                        <a href="{{ route('workout-plans.index') }}" class="inline-block w-full py-2.5 px-5 rounded-full font-semibold text-center transition-all duration-300 ease-in-out bg-gradient-primary text-white shadow-md hover:shadow-lg hover:-translate-y-0.5 text-xs">{{ __('View Workout Plans') }}</a>
                    </div>
                </div>
            </aside>
            
            <!-- Main Content -->
            <main class="flex-1 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>