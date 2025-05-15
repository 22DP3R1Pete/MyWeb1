<x-layouts.admin>
    <x-slot name="header">System Statistics</x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- User Growth Chart -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
            <div class="p-6">
                <h2 class="text-lg font-semibold mb-4 text-splitify-navy">User Growth</h2>
                <div class="h-64 overflow-hidden">
                    <canvas id="userGrowthChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>

        <!-- Workout Plan Creation Chart -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
            <div class="p-6">
                <h2 class="text-lg font-semibold mb-4 text-splitify-navy">Workout Plan Creation</h2>
                <div class="h-64 overflow-hidden">
                    <canvas id="planCreationChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Most Active Users -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200 mt-6">
        <div class="p-6">
            <h2 class="text-lg font-semibold mb-4 text-splitify-navy">Most Active Users</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Workout Logs</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($mostActiveUsers as $user)
                            <tr class="hover:bg-splitify-gray transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->workout_logs_count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Format data for charts
        const userGrowthData = {
            labels: @json($userGrowth->pluck('month')),
            datasets: [{
                label: 'New Users',
                data: @json($userGrowth->pluck('count')),
                backgroundColor: 'rgba(0, 178, 169, 0.4)', // Splitify teal with transparency
                borderColor: '#00B2A9', // Splitify teal
                borderWidth: 2
            }]
        };

        const planCreationData = {
            labels: @json($planCreation->pluck('month')),
            datasets: [{
                label: 'New Workout Plans',
                data: @json($planCreation->pluck('count')),
                backgroundColor: 'rgba(26, 43, 99, 0.4)', // Splitify navy with transparency
                borderColor: '#1A2B63', // Splitify navy
                borderWidth: 2
            }]
        };

        // Create charts
        document.addEventListener('DOMContentLoaded', function() {
            // User Growth Chart
            const userCtx = document.getElementById('userGrowthChart').getContext('2d');
            new Chart(userCtx, {
                type: 'bar',
                data: userGrowthData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                boxWidth: 12,
                                font: {
                                    family: "'Instrument Sans', sans-serif"
                                }
                            }
                        }
                    }
                }
            });

            // Plan Creation Chart
            const planCtx = document.getElementById('planCreationChart').getContext('2d');
            new Chart(planCtx, {
                type: 'bar',
                data: planCreationData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                boxWidth: 12,
                                font: {
                                    family: "'Instrument Sans', sans-serif"
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-layouts.admin> 