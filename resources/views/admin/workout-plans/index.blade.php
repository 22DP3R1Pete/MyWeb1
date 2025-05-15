<x-layouts.admin>
    <x-slot name="header">Manage Workout Plans</x-slot>

    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="p-6 text-gray-900">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created By</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Difficulty</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($plans as $plan)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $plan->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $plan->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $plan->creator->name ?? 'Unknown' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $plan->difficulty }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $plan->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('workout-plans.show', $plan) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                    <a href="{{ route('admin.workout-plans.edit', $plan) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                    <form class="inline" method="POST" action="{{ route('admin.workout-plans.destroy', $plan) }}" onsubmit="return confirm('Are you sure you want to delete this workout plan?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $plans->links() }}
            </div>
        </div>
    </div>
</x-layouts.admin> 