<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl  leading-tight">
            Course Attendance Summary
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-800">
        <div class="max-w-full sm:max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-700 shadow-lg sm:rounded-lg p-6 sm:p-8">
                @if(count($summary) === 0)
                    <p class="text-lg">No Course Session to Summarize.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($summary as $courseName => $data)
                            @php
                                $attendedSessions = $data['attended'];
                                $totalSessions = $data['total'];
                                $attendancePercentage = $totalSessions > 0 ? ($attendedSessions / $totalSessions) * 100 : 0;
                                $attendanceClass = $attendancePercentage < 50 ? 'bg-yellow-400' : 'bg-green-500';
                            @endphp

                            <div class="bg-gray-100 shadow-md rounded-lg p-6 flex flex-col space-y-4">
                                <h3 class="text-xl font-semibold text-blue-600 hover:text-blue-800 hover:underline cursor-pointer transition-all duration-200 ease-in-out">
                                    {{ $courseName }}
                                </h3>

                                <div class="flex items-center space-x-4">
                                    <div class="w-full bg-gray-200 rounded-full h-3">
                                        <div class="h-3 rounded-full {{ $attendanceClass }}" style="width: {{ $attendancePercentage }}%"></div>
                                    </div>
                                    <span class="font-medium text-gray-700">{{ number_format($attendancePercentage, 2) }}%</span>
                                </div>

                                @if($attendancePercentage < 50)
                                    <p class="text-sm text-yellow-600 mt-2">Warning: Your attendance is below %50!</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
