<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Tüm Oturumlar
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="{{ route('teacher.sessions.create') }}" class="inline-block mb-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">Create a Session</a>
                @if($sessions->count() == 0)
                    <p class="text-gray-600">Henüz bir oturum oluşturulmamış.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-2 text-left">Ders</th>
                                <th class="px-4 py-2 text-left">Tarih</th>
                                <th class="px-4 py-2 text-left">Saat</th>
                                <th class="px-4 py-2 text-left">Self Attendance</th>
                                <th class="px-4 py-2 text-left">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($sessions as $session)
                                <tr>
                                    <td class="px-4 py-2">{{ $session->courseGroup->course->course_name }}</td>
                                    <td class="px-4 py-2">{{ $session->session_date }}</td>
                                    <td class="px-4 py-2">{{ $session->start_time }} - {{ $session->end_time }}</td>
                                    <td class="px-4 py-2">
                                        @if($session->is_attendance_active)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Açık</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Kapalı</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 space-x-2">
                                        <form action="{{ route('teacher.sessions.toggle', $session->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            
                                            <button class="bg-blue-500 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs">
                                                {{ $session->is_attendance_active ? 'Kapat' : 'Aç' }}
                                            </button>
                                        </form>
                                        <a href="{{ route('teacher.sessions.viewScanner', $session->id) }}" class="bg-gray-500 hover:bg-gray-700 text-white px-2 py-1 rounded text-xs">ReverseQR</a>
                                        <a href="{{ route('teacher.sessions.edit', $session->id) }}" class="bg-gray-500 hover:bg-gray-700 text-white px-2 py-1 rounded text-xs">Düzenle</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
