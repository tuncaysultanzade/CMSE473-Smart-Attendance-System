@if($sessions->count() == 0)
    <p class="text-gray-600">You dont have any active self attendance sessions to show!</p>
@else
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr class="bg-gray-50">
                <th class="px-4 py-2 text-left">Course</th>
                <th class="px-4 py-2 text-left">Date</th>
                <th class="px-4 py-2 text-left">Hour</th>
                <th class="px-4 py-2 text-left">Status</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($sessions as $session)
                <tr>
                    <td class="px-4 py-2 text-gray-700">{{ $session->courseGroup->course->course_name ?? $session->course_group_id }}</td>
                    <td class="px-4 py-2 text-gray-700">{{ $session->session_date }}</td>
                    <td class="px-4 py-2 text-gray-700">{{ $session->start_time }} - {{ $session->end_time }}</td>
                    <td class="px-4 py-2">
                        @php
                            $attendance = $session->attendances->where('student_id', Auth::id())->first();
                        @endphp

                        @if(!$session->is_attendance_active)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-500">
                                Attendance Disabled
                            </span>
                        @elseif($attendance)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Attendance Marked
                            </span>
                        @else
                            <x-primary-button onclick="markAttendance({{ $session->id }})">
                                Mark
                            </x-primary-button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
