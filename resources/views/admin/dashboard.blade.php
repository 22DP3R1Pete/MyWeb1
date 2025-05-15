<x-layouts.admin>
    <x-slot name="header">Admin Dashboard</x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- User count card -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
            <div class="p-6">
                <h2 class="text-lg font-semibold mb-2 text-gray-700">Users</h2>
                <p class="text-3xl font-bold text-splitify-navy">{{ $userCount }}</p>
                <a href="{{ route('admin.users') }}" class="mt-4 inline-flex items-center text-splitify-teal hover:text-splitify-navy transition-colors">
                    View all users
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Workout Plans count card -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
            <div class="p-6">
                <h2 class="text-lg font-semibold mb-2 text-gray-700">Workout Plans</h2>
                <p class="text-3xl font-bold text-splitify-navy">{{ $workoutPlansCount }}</p>
                <a href="{{ route('admin.workout-plans') }}" class="mt-4 inline-flex items-center text-splitify-teal hover:text-splitify-navy transition-colors">
                    View all plans
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Exercises count card -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
            <div class="p-6">
                <h2 class="text-lg font-semibold mb-2 text-gray-700">Exercises</h2>
                <p class="text-3xl font-bold text-splitify-navy">{{ $exerciseCount }}</p>
                <a href="{{ route('admin.exercises') }}" class="mt-4 inline-flex items-center text-splitify-teal hover:text-splitify-navy transition-colors">
                    View all exercises
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Workout Logs count card -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
            <div class="p-6">
                <h2 class="text-lg font-semibold mb-2 text-gray-700">Workout Logs</h2>
                <p class="text-3xl font-bold text-splitify-navy">{{ $workoutLogsCount }}</p>
                <a href="{{ route('admin.statistics') }}" class="mt-4 inline-flex items-center text-splitify-teal hover:text-splitify-navy transition-colors">
                    View statistics
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <!-- Recent Users -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
            <div class="p-6">
                <h2 class="text-lg font-semibold mb-4 text-splitify-navy">Recent Users</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($recentUsers as $user)
                                <tr class="hover:bg-splitify-gray transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.users') }}" class="inline-flex items-center px-4 py-2 bg-splitify-teal text-white rounded-md hover:bg-splitify-navy transition-colors text-sm">
                        View all users
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Popular Workout Plans -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
            <div class="p-6">
                <h2 class="text-lg font-semibold mb-4 text-splitify-navy">Popular Workout Plans</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Creator</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subscribers</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($popularPlans as $plan)
                                <tr class="hover:bg-splitify-gray transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $plan->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $plan->creator->name ?? 'Unknown' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $plan->subscribers_count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.workout-plans') }}" class="inline-flex items-center px-4 py-2 bg-splitify-teal text-white rounded-md hover:bg-splitify-navy transition-colors text-sm">
                        View all plans
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin> 