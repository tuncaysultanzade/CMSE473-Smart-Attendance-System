<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl  leading-tight">
            Yeni Session Oluştur
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div class="mb-4 text-green-600 font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('teacher.sessions.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="course_group_id" value="Ders / Course Group" />
                        <select id="course_group_id" name="course_group_id"
                                class="block mt-1 w-full border-gray-300 rounded-md" required>
                            <option value="">Bir ders seçin...</option>
                            @foreach($courseGroups as $group)
                                <option value="{{ $group->id }}">
                                    {{ $group->course->course_name }} 
                                    ({{ $group->course->course_code }}) 
                                    - Grup {{ $group->group_number }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('course_group_id')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="session_type" value="Session Type" />
                        <select id="session_type" name="session_type" class="block mt-1 w-full border-gray-300 rounded-md">
                            <option value="theoretical">Theoretical</option>
                            <option value="lab">Lab</option>
                            <option value="tutorial">Tutorial</option>
                        </select>
                        <x-input-error :messages="$errors->get('session_type')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="session_date" value="Tarih" />
                        <x-text-input id="session_date" name="session_date" type="date"
                                      class="block mt-1 w-full" required />
                        <x-input-error :messages="$errors->get('session_date')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="start_time" value="Başlangıç Saati" />
                            <x-text-input id="start_time" name="start_time" type="time"
                                          class="block mt-1 w-full" required />
                            <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="end_time" value="Bitiş Saati" />
                            <x-text-input id="end_time" name="end_time" type="time"
                                          class="block mt-1 w-full" required />
                            <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-6">
                        <x-primary-button>Session Oluştur</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
