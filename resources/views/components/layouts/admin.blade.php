@props(['header'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Admin - {{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <!-- Admin Navigation -->
            <nav class="bg-gray-800 text-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold">Admin Panel</a>
                            </div>
                            <div class="hidden md:block">
                                <div class="ml-10 flex items-baseline space-x-4">
                                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-gray-900' : 'hover:bg-gray-700' }} px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                                    <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users*') ? 'bg-gray-900' : 'hover:bg-gray-700' }} px-3 py-2 rounded-md text-sm font-medium">Users</a>
                                    <a href="{{ route('admin.workout-plans') }}" class="{{ request()->routeIs('admin.workout-plans*') ? 'bg-gray-900' : 'hover:bg-gray-700' }} px-3 py-2 rounded-md text-sm font-medium">Workout Plans</a>
                                    <a href="{{ route('admin.exercises') }}" class="{{ request()->routeIs('admin.exercises*') ? 'bg-gray-900' : 'hover:bg-gray-700' }} px-3 py-2 rounded-md text-sm font-medium">Exercises</a>
                                    <a href="{{ route('admin.statistics') }}" class="{{ request()->routeIs('admin.statistics*') ? 'bg-gray-900' : 'hover:bg-gray-700' }} px-3 py-2 rounded-md text-sm font-medium">Statistics</a>
                                    <a href="{{ route('dashboard') }}" class="hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">Back to App</a>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="ml-3 relative">
                                <div class="text-sm">{{ Auth::user()->name }}</div>
                            </div>
                            <form method="POST" action="{{ route('logout') }}" class="ml-4">
                                @csrf
                                <button type="submit" class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-xs">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Mobile menu -->
                <div class="md:hidden bg-gray-700">
                    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-gray-900' : 'hover:bg-gray-800' }} block px-3 py-2 rounded-md text-base font-medium">Dashboard</a>
                        <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users*') ? 'bg-gray-900' : 'hover:bg-gray-800' }} block px-3 py-2 rounded-md text-base font-medium">Users</a>
                        <a href="{{ route('admin.workout-plans') }}" class="{{ request()->routeIs('admin.workout-plans*') ? 'bg-gray-900' : 'hover:bg-gray-800' }} block px-3 py-2 rounded-md text-base font-medium">Workout Plans</a>
                        <a href="{{ route('admin.exercises') }}" class="{{ request()->routeIs('admin.exercises*') ? 'bg-gray-900' : 'hover:bg-gray-800' }} block px-3 py-2 rounded-md text-base font-medium">Exercises</a>
                        <a href="{{ route('admin.statistics') }}" class="{{ request()->routeIs('admin.statistics*') ? 'bg-gray-900' : 'hover:bg-gray-800' }} block px-3 py-2 rounded-md text-base font-medium">Statistics</a>
                        <a href="{{ route('dashboard') }}" class="hover:bg-gray-800 block px-3 py-2 rounded-md text-base font-medium">Back to App</a>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <h1 class="text-2xl font-bold text-gray-800">
                        {{ $header ?? 'Admin Panel' }}
                    </h1>
                </div>
            </header>

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative max-w-7xl mx-auto mt-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative max-w-7xl mx-auto mt-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Page Content -->
            <main>
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </body>
</html> 