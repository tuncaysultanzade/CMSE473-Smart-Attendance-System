<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl leading-tight">
                Edit Attendance — {{ $session->courseGroup->course->course_name }}
            </h2>
            <div class="text-sm font-medium text-gray-500 bg-gray-100 px-4 py-2 rounded-full">
                {{ \Carbon\Carbon::parse($session->session_date)->format('d M Y, l') }}
                <span class="mx-2">•</span>
                {{ $session->courseGroup->assignedStudents->count() }} Students
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-6 py-4 rounded-xl shadow-lg flex items-center gap-3 max-w-md mx-auto">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6">
                    <h3 class="text-2xl font-bold text-white text-center">
                        Update Attendance Status
                    </h3>
                    <p class="text-indigo-100 text-center mt-2">Click on student's status to mark Present, Absent, or Excused</p>
                </div>

                <div class="p-6">
                    <form method="POST" action="{{ route('teacher.sessions.updateAttendance', $session->id) }}">
                        @csrf

                        <div class="grid gap-4 md:grid-cols-1 lg:grid-cols-1">
                            @foreach($session->courseGroup->assignedStudents as $index => $student)
                                @php
                                    $attendance = $session->attendances->where('student_id', $student->id)->first();
                                    $currentStatus = $attendance?->status;
                                @endphp

                                <div class="group bg-gray-50 hover:bg-white rounded-xl p-5 border border-gray-200 hover:border-indigo-300 hover:shadow-lg transition-all duration-300">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-md">
                                                {{ strtoupper(substr($student->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-semibold text-gray-800">{{ $student->name }}</h4>
                                                <p class="text-sm text-gray-500">Student ID: {{ $student->user_id ?? '—' }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            @foreach([
                                                'present' => ['label' => 'Present', 'short' => 'P', 'color' => 'emerald'],
                                                'absent'  => ['label' => 'Absent',  'short' => 'A', 'color' => 'red'],
                                                'excused' => ['label' => 'Excused', 'short' => 'E', 'color' => 'amber']
                                            ] as $status => $info)
                                                <label class="relative cursor-pointer">
                                                    <input
                                                        type="radio"
                                                        name="attendances[{{ $student->id }}]"
                                                        value="{{ $status }}"
                                                        class="sr-only peer"
                                                        {{ $currentStatus === $status ? 'checked' : '' }}
                                                    />
                                                    <div class="w-20 h-20 rounded-2xl border-4 border-gray-300 peer-checked:border-{{ $info['color'] }}-500 
                                                        bg-white peer-checked:bg-{{ $info['color'] }}-500 
                                                        text-gray-600 peer-checked:text-white font-bold text-2xl
                                                        flex flex-col items-center justify-center gap-1
                                                        transition-all duration-300 transform hover:scale-110 hover:shadow-xl
                                                        group-hover:border-{{ $info['color'] }}-300">
                                                        <span class="text-3xl">{{ $info['short'] }}</span>
                                                        <span class="text-xs font-medium">{{ $info['label'] }}</span>
                                                    </div>
                                                    <div class="absolute inset-0 rounded-2xl peer-checked:animate-ping bg-{{ $info['color'] }}-400 opacity-75 -z-10"></div>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-10 text-center">
                            <button type="submit" class="inline-flex items-center gap-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-bold text-lg px-10 py-5 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                                </svg>
                                Save All Attendance Updates
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-8 text-gray-500 text-sm">
                <p>QR-scanned attendance is auto-marked • Manual edits override QR records</p>
            </div>
        </div>
    </div>

</style>

</x-app-layout>

<style>
    @keyframes pulse-ring {
        0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.5); }
        70% { box-shadow: 0 0 0 12px rgba(34, 197, 94, 0); }
        100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
    }
    .peer-checked ~ .animate-ping {
        animation: pulse-ring 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
    }
</style>
