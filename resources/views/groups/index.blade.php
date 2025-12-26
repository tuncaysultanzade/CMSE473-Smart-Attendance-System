<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">Groups</h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow rounded-lg">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Group NO</th>
                        <th class="px-4 py-2 text-left">Course</th>
                        <th class="px-4 py-2 text-center">Student Number</th>
                        <th class="px-4 py-2 text-center">Teacher Number</th>
                        <th class="px-4 py-2 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($groups as $group)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $group->group_number }}</td>
                            <td class="px-4 py-2">{{ $group->course->course_name ?? '-' }}</td>
                            <td class="px-4 py-2 text-center">{{ $group->assigned_students_count }}</td>
                            <td class="px-4 py-2 text-center">{{ $group->assigned_teachers_count }}</td>
                            <td class="px-4 py-2 text-right">
                                <a href="{{ route('groups.edit', $group) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
