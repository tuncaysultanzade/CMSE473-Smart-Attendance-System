<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Add new Course') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('courses.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="department_id" :value="__('Department')" />
                        <select name="department_id" id="department_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Select...</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->department_name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="course_code" :value="__('Course Code')" />
                        <x-text-input id="course_code" name="course_code" type="text" maxlength="10"
                                      class="block w-full mt-1" required />
                        <x-input-error :messages="$errors->get('course_code')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="course_name" :value="__('Course Name')" />
                        <x-text-input id="course_name" name="course_name" type="text"
                                      class="block w-full mt-1" required />
                        <x-input-error :messages="$errors->get('course_name')" class="mt-2" />
                    </div>

                    <hr class="my-6 border-gray-300">

                    <div>
                        <h3 class="text-lg font-semibold mb-2">Groups</h3>
                        <div id="group-wrapper">
                            <div class="group-item p-4 mb-4 border rounded-md bg-gray-50">
                                <x-input-label :value="__('Group No')" />
                                <x-text-input name="groups[0][group_number]" type="number" class="block w-full mt-1 mb-3" required />

                                <x-input-label :value="__('Term')" />
                                <select name="groups[0][academic_term_id]" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Select...</option>
                                    @foreach($terms as $term)
                                        <option value="{{ $term->id }}">{{ $term->year }} {{ $term->term }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <x-secondary-button type="button" id="add-group" class="mt-2">
                            + Add Group
                        </x-secondary-button>
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button>
                            {{ __('Save') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let groupIndex = 1;
        document.getElementById('add-group').addEventListener('click', function() {
            const wrapper = document.getElementById('group-wrapper');
            const newGroup = document.createElement('div');
            newGroup.classList.add('group-item', 'p-4', 'mb-4', 'border', 'rounded-md', 'bg-gray-50');

            newGroup.innerHTML = `
                <x-input-label :value="'Grup Numarası'" />
                <input type="number" name="groups[${groupIndex}][group_number]" class="block w-full mt-1 mb-3 border-gray-300 rounded-md shadow-sm" required>

                <x-input-label :value="'Dönem'" />
                <select name="groups[${groupIndex}][academic_term_id]" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                    <option value="">Seçiniz...</option>
                    @foreach($terms as $term)
                        <option value="{{ $term->id }}">{{ $term->year }} {{ $term->term }}</option>
                    @endforeach
                </select>
            `;

            wrapper.appendChild(newGroup);
            groupIndex++;
        });
    </script>
</x-app-layout>
