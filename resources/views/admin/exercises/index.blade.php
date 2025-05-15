<x-layouts.admin>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Manage Exercises</h2>
            <a href="{{ route('admin.exercises.create') }}" class="px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition">Create Exercise</a>
        </div>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="p-6 text-gray-900">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Muscle Group</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Equipment</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($exercises as $exercise)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $exercise->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $exercise->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $exercise->muscle_group }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $exercise->equipment_needed }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('exercises.show', $exercise) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                    <a href="{{ route('admin.exercises.edit', $exercise) }}" class="text-teal-600 hover:text-teal-900 mr-3">Edit</a>
                                    <form action="{{ route('admin.exercises.destroy', $exercise) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this exercise?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $exercises->links() }}
            </div>
        </div>
    </div>
</x-layouts.admin> 