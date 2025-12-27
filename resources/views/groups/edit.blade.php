<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl  leading-tight">
            {{ __('Edit the group members of') }} — GR {{ $group->group_number }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto rounded-lg sm:px-6 bg-gray-200 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
        @endif

        <form action="{{ route('groups.update', $group) }}" method="POST" class="space-y-6">
            @csrf

            <div class="flex gap-2 items-center">
                <input type="text" name="search_student" value="{{ request('search_student') }}"
                       placeholder="Search Student..."
                       class="border rounded p-2 w-full" />
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Search</button>
            </div>

            <div class="bg-white p-6 shadow rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Students</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($students as $student)
                        <label class="flex items-center gap-2 p-2 border rounded hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" name="students[]" value="{{ $student->id }}"
                                   @if(in_array($student->id, $assignedStudents)) checked @endif
                                   class="form-checkbox h-5 w-5 text-indigo-600">
                            <span>{{ $student->name }} {{ $student->surname }} ({{ $student->email }})</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex gap-2 items-center">
                <input type="text" name="search_teacher" value="{{ request('search_teacher') }}"
                       placeholder="Öğretmen ara..."
                       class="border rounded p-2 w-full" />
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Search</button>
            </div>

            <div class="bg-white p-6 shadow rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Teachers</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($teachers as $teacher)
                        <label class="flex items-center gap-2 p-2 border rounded hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" name="teachers[]" value="{{ $teacher->id }}"
                                   @if(in_array($teacher->id, $assignedTeachers)) checked @endif
                                   class="form-checkbox h-5 w-5 text-indigo-600">
                            <span>{{ $teacher->name }} {{ $teacher->surname }} ({{ $teacher->email }})</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end">
                <x-primary-button>Update</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
