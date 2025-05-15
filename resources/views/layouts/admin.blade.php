<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Admin - {{ config('app.name', 'Splitify') }}</title>

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
    <body class="antialiased bg-splitify-gray text-gray-800 font-sans">
        <div class="min-h-screen flex flex-col">
            <!-- Top Navigation -->
            <header class="bg-splitify-navy shadow-md sticky top-0 z-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <!-- Logo -->
                        <div class="flex items-center">
                            <a href="{{ route('admin.dashboard') }}" class="flex-shrink-0 flex items-center">
                                <span class="text-2xl font-bold text-white">Splitify</span>
                                <span class="ml-2 px-2 py-1 text-xs font-semibold bg-splitify-teal text-white rounded-md">Admin</span>
                            </a>
                        </div>
                        
                        <!-- Navigation -->
                        <div class="flex items-center">
                            <div class="hidden md:ml-6 md:flex md:items-center md:space-x-4">
                                <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-splitify-teal text-white' : 'text-white hover:bg-splitify-navy-light hover:text-white transition-colors' }}">{{ __('Dashboard') }}</a>
                                <a href="{{ route('admin.users') }}" class="px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.users*') ? 'bg-splitify-teal text-white' : 'text-white hover:bg-splitify-navy-light hover:text-white transition-colors' }}">{{ __('Users') }}</a>
                                <a href="{{ route('admin.workout-plans') }}" class="px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.workout-plans*') ? 'bg-splitify-teal text-white' : 'text-white hover:bg-splitify-navy-light hover:text-white transition-colors' }}">{{ __('Workout Plans') }}</a>
                                <a href="{{ route('admin.exercises') }}" class="px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.exercises*') ? 'bg-splitify-teal text-white' : 'text-white hover:bg-splitify-navy-light hover:text-white transition-colors' }}">{{ __('Exercises') }}</a>
                                <a href="{{ route('admin.statistics') }}" class="px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.statistics*') ? 'bg-splitify-teal text-white' : 'text-white hover:bg-splitify-navy-light hover:text-white transition-colors' }}">{{ __('Statistics') }}</a>
                                <a href="{{ route('dashboard') }}" class="px-3 py-2 text-sm font-medium rounded-md bg-white text-splitify-navy hover:bg-gray-100 transition-colors">{{ __('Back to App') }}</a>
                            </div>
                        </div>
                        
                        <!-- User Dropdown -->
                        <div class="ml-3 relative flex items-center">
                            <div x-data="{ open: false }" @click.away="open = false" class="relative">
                                <div>
                                    <button @click="open = !open" class="flex items-center text-sm font-medium text-white hover:text-splitify-teal focus:outline-none transition duration-150 ease-in-out">
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
                            <button x-data="{ open: false }" @click="open = !open; $dispatch('toggle-mobile-menu', { isOpen: open })" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-splitify-teal hover:bg-splitify-navy-light focus:outline-none transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile menu -->
                <div x-data="{ isOpen: false }" @toggle-mobile-menu.window="isOpen = $event.detail.isOpen" x-show="isOpen" class="md:hidden bg-splitify-navy-light border-t border-splitify-navy-light" style="display: none;">
                    <div class="px-2 pt-2 pb-3 space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-splitify-teal text-white' : 'text-white hover:bg-splitify-navy-light hover:text-splitify-teal' }}">{{ __('Dashboard') }}</a>
                        <a href="{{ route('admin.users') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('admin.users*') ? 'bg-splitify-teal text-white' : 'text-white hover:bg-splitify-navy-light hover:text-splitify-teal' }}">{{ __('Users') }}</a>
                        <a href="{{ route('admin.workout-plans') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('admin.workout-plans*') ? 'bg-splitify-teal text-white' : 'text-white hover:bg-splitify-navy-light hover:text-splitify-teal' }}">{{ __('Workout Plans') }}</a>
                        <a href="{{ route('admin.exercises') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('admin.exercises*') ? 'bg-splitify-teal text-white' : 'text-white hover:bg-splitify-navy-light hover:text-splitify-teal' }}">{{ __('Exercises') }}</a>
                        <a href="{{ route('admin.statistics') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('admin.statistics*') ? 'bg-splitify-teal text-white' : 'text-white hover:bg-splitify-navy-light hover:text-splitify-teal' }}">{{ __('Statistics') }}</a>
                        <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium bg-white text-splitify-navy hover:bg-gray-100 mt-4">{{ __('Back to App') }}</a>
                    </div>
                </div>
            </header>

            <div class="flex flex-1">
                <!-- Sidebar -->
                <aside class="hidden md:block md:w-64 bg-white shadow-md px-4 py-6">
                    <div class="flex items-center mb-6 pb-4 border-b border-gray-200">
                        <div class="p-2 rounded-md bg-splitify-teal/10 mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-splitify-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                        </div>
                        <h2 class="text-lg font-bold text-splitify-navy">Admin Control</h2>
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Admin Menu') }}</h3>
                        <div class="mt-3">
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center py-3 px-4 rounded-lg mb-1 transition-all duration-300 ease-in-out {{ request()->routeIs('admin.dashboard') ? 'bg-splitify-teal text-white' : 'text-gray-700 hover:bg-splitify-teal/10' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <span>{{ __('Dashboard') }}</span>
                            </a>
                            
                            <a href="{{ route('admin.users') }}" class="flex items-center py-3 px-4 rounded-lg mb-1 transition-all duration-300 ease-in-out {{ request()->routeIs('admin.users*') ? 'bg-splitify-teal text-white' : 'text-gray-700 hover:bg-splitify-teal/10' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span>{{ __('Users') }}</span>
                            </a>
                            
                            <a href="{{ route('admin.workout-plans') }}" class="flex items-center py-3 px-4 rounded-lg mb-1 transition-all duration-300 ease-in-out {{ request()->routeIs('admin.workout-plans*') ? 'bg-splitify-teal text-white' : 'text-gray-700 hover:bg-splitify-teal/10' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                                <span>{{ __('Workout Plans') }}</span>
                            </a>
                            
                            <a href="{{ route('admin.exercises') }}" class="flex items-center py-3 px-4 rounded-lg mb-1 transition-all duration-300 ease-in-out {{ request()->routeIs('admin.exercises*') ? 'bg-splitify-teal text-white' : 'text-gray-700 hover:bg-splitify-teal/10' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <span>{{ __('Exercises') }}</span>
                            </a>
                            
                            <a href="{{ route('admin.statistics') }}" class="flex items-center py-3 px-4 rounded-lg mb-1 transition-all duration-300 ease-in-out {{ request()->routeIs('admin.statistics*') ? 'bg-splitify-teal text-white' : 'text-gray-700 hover:bg-splitify-teal/10' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                </svg>
                                <span>{{ __('Statistics') }}</span>
                            </a>
                            
                            <div class="border-t border-gray-200 my-4"></div>
                            
                            <a href="{{ route('dashboard') }}" class="flex items-center py-3 px-4 rounded-lg mb-1 transition-all duration-300 ease-in-out bg-splitify-light-teal text-splitify-navy hover:bg-splitify-light-teal/80">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                                </svg>
                                <span>{{ __('Back to App') }}</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Admin Stats -->
                    <div class="mb-6">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">{{ __('Quick Stats') }}</h3>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="p-3 bg-splitify-light-teal rounded-lg shadow-sm">
                                <h4 class="font-medium text-xs mb-1 text-splitify-navy/80">{{ __('Total Users') }}</h4>
                                <p class="text-xl font-semibold text-splitify-navy">{{ \App\Models\User::count() }}</p>
                            </div>
                            <div class="p-3 bg-splitify-light-teal rounded-lg shadow-sm">
                                <h4 class="font-medium text-xs mb-1 text-splitify-navy/80">{{ __('Workouts') }}</h4>
                                <p class="text-xl font-semibold text-splitify-navy">{{ \App\Models\WorkoutPlan::count() ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Admin Actions -->
                    <div>
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">{{ __('Quick Actions') }}</h3>
                        <div class="space-y-2">
                            <a href="{{ route('admin.users') }}" class="block w-full text-center py-2 px-4 bg-splitify-teal text-white rounded-md hover:bg-splitify-navy transition-colors text-sm">
                                {{ __('Manage Users') }}
                            </a>
                            <a href="{{ route('admin.exercises') }}" class="block w-full text-center py-2 px-4 bg-splitify-teal text-white rounded-md hover:bg-splitify-navy transition-colors text-sm">
                                {{ __('Manage Exercises') }}
                            </a>
                        </div>
                    </div>
                </aside>
                
                <!-- Main Content -->
                <main class="flex-1 p-6">
                    <!-- Admin Breadcrumb -->
                    <div class="flex items-center text-sm text-gray-500 mb-6">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-splitify-teal">Admin</a>
                        @if(!request()->routeIs('admin.dashboard'))
                            <span class="mx-2">/</span>
                            <span class="text-splitify-navy font-medium">
                                @if(request()->routeIs('admin.users*'))
                                    Users
                                @elseif(request()->routeIs('admin.workout-plans*'))
                                    Workout Plans
                                @elseif(request()->routeIs('admin.exercises*'))
                                    Exercises
                                @elseif(request()->routeIs('admin.statistics*'))
                                    Statistics
                                @endif
                            </span>
                        @endif
                    </div>

            <!-- Page Heading -->
                    <div class="mb-6 flex justify-between items-center">
                        <h1 class="text-2xl font-bold text-splitify-navy">
                        {{ $header ?? 'Admin Panel' }}
                    </h1>
                        
                        <div class="text-sm text-gray-500">
                            {{ now()->format('F j, Y') }}
                        </div>
                </div>

            <!-- Flash Messages -->
            @if (session('success'))
                        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Page Content -->
                        {{ $slot }}
                </main>
                </div>
        </div>
    </body>
</html> 