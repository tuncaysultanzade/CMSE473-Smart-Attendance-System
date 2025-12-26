<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Course List') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8">
        {{-- Başarılı işlem mesajı --}}
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Yeni Ders Ekle Butonu --}}
        <div class="flex justify-end mb-4">
            <x-primary-button onclick="window.location='{{ route('courses.create') }}'">
                + Add new course
            </x-primary-button>
        </div>

        {{-- Ders Tablosu --}}
        <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-b bg-gray-50">
                        <th class="p-3 text-left">Code</th>
                        <th class="p-3 text-left">Name</th>
                        <th class="p-3 text-left">Department</th>
                        <th class="p-3 text-left">Groups</th>
                        <th class="p-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="p-3">{{ $course->course_code }}</td>
                            <td class="p-3">{{ $course->course_name }}</td>
                            <td class="p-3">{{ $course->department->department_name ?? '-' }}</td>

                            {{-- Gruplar --}}
                            <td class="p-3">
                                @forelse($course->groups as $group)
                                    <div class="text-sm text-gray-700">
                                        Group {{ $group->group_number }}
                                        ({{ $group->academicTerm->term ?? '-' }})
                                    </div>
                                @empty
                                    <span class="text-gray-400 text-sm">NO GROUP</span>
                                @endforelse
                            </td>

                            {{-- İşlem Butonları --}}
                            <td class="p-3 text-right space-x-2">
                                {{-- Düzenle --}}
                                <x-secondary-button onclick="window.location='{{ route('courses.edit', $course) }}'">
                                    Edit
                                </x-secondary-button>

                                {{-- Sil --}}
                                <form action="{{ route('courses.destroy', $course) }}"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure?')"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button type="submit">
                                        Delete
                                    </x-danger-button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500">
                                No courses.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
