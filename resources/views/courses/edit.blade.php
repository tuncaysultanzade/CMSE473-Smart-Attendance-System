<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ders Düzenle') }} — {{ $course->course_code }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8">
        {{-- Başarı veya hata mesajları --}}
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                {{ session('error') }}
            </div>
        @endif

        {{-- 🔹 Ders Bilgilerini Güncelle --}}
        <div class="bg-white p-6 shadow rounded-lg mb-8">
            <form action="{{ route('courses.update', $course) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <x-input-label for="department_id" :value="__('Department')" />
                    <select name="department_id" id="department_id"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" @selected($dept->id == $course->department_id)>
                                {{ $dept->department_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="course_code" :value="__('Course Code')" />
                    <x-text-input id="course_code" name="course_code" type="text"
                                  value="{{ $course->course_code }}"
                                  class="block w-full mt-1" />
                </div>

                <div>
                    <x-input-label for="course_name" :value="__('Course Name')" />
                    <x-text-input id="course_name" name="course_name" type="text"
                                  value="{{ $course->course_name }}"
                                  class="block w-full mt-1" />
                </div>

                <div class="flex justify-end">
                    <x-primary-button>Update</x-primary-button>
                </div>
            </form>
        </div>

        {{-- 🔹 Grup Ekleme Alanı --}}
        <div class="bg-white p-6 shadow rounded-lg mb-8">
            <h3 class="text-lg font-semibold mb-4">Add new group</h3>

<div class="bg-white shadow rounded-lg p-6 mb-6">
    <h3 class="text-lg font-semibold mb-4">Add new group</h3>
    <form action="{{ route('courses.addGroup', $course) }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
        @csrf

        {{-- Grup Numarası --}}
        <div class="flex flex-col">
            <x-input-label for="group_number" :value="__('Group No')" class="mb-1" />
            <x-text-input id="group_number" name="group_number" type="number" placeholder="1" class="block w-full" required />
        </div>

        {{-- Dönem Seçimi --}}
        <div class="flex flex-col">
            <x-input-label for="academic_term_id" :value="__('Term')" class="mb-1" />
            <select id="academic_term_id" name="academic_term_id" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                <option value="">Select...</option>
                @foreach($terms as $term)
                    <option value="{{ $term->id }}">{{ $term->term }}</option>
                @endforeach
            </select>
        </div>

        {{-- Submit Butonu --}}
        <div class="flex justify-start md:justify-end">
            <x-primary-button class="w-full md:w-auto">Add group</x-primary-button>
        </div>
    </form>
</div>

        </div>

        {{-- 🔹 Mevcut Gruplar Listesi --}}
<div class="bg-white p-6 shadow rounded-lg">
    <h4 class="text-md font-semibold mb-4">Active Groups</h4>

    <ul class="divide-y divide-gray-200">
        @forelse($course->groups as $group)
            <li class="py-2 flex justify-between items-center">
                <div>
                    <span class="font-medium text-gray-800">Group {{ $group->group_number }}</span>
                    <span class="text-gray-500">— {{ $group->academicTerm->term ?? 'No term' }}</span>
                </div>
                <div class="flex gap-2">
                    {{-- Düzenle butonu --}}
                    <a href="{{ route('groups.edit', $group) }}" class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700">Edit</a>

                    {{-- Sil butonu --}}
                    <form action="{{ route('courses.deleteGroup', [$course, $group]) }}" method="POST" onsubmit="return confirm('You are deleting the group, are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
                    </form>
                </div>
            </li>
        @empty
            <li class="py-2 text-gray-500">No groups added.</li>
        @endforelse
    </ul>
</div>
    </div>
</x-app-layout>
