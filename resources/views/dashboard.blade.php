<x-app-layout>
    <x-slot name="header" >
        <div class="flex items-center justify-between ">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    
    <div class="py-12 bg-gray-800">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 rounded-lg shadow-sm flex items-center">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 flex items-center">
                        <i class="fas fa-rocket text-indigo-600 mr-3"></i>
                        Quick Actions
                    </h3>

                    <!-- Admin Dashboard -->
                    @if(auth()->user()->user_role === 'admin')
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            <a href="{{ route('users.index') }}" class="group bg-gradient-to-br from-purple-600 to-purple-700 text-white rounded-xl p-6 shadow-lg hover:shadow-2xl hover:scale-105 transform transition-all duration-300">
                                <i class="fas fa-users-cog text-4xl mb-4 opacity-90"></i>
                                <h4 class="text-lg font-semibold">Manage Users</h4>
                                <p class="text-sm opacity-90 mt-1">Admins, Teachers & Students</p>
                            </a>

                            <a href="{{ route('departments.index') }}" class="group bg-gradient-to-br from-blue-600 to-blue-700 text-white rounded-xl p-6 shadow-lg hover:shadow-2xl hover:scale-105 transform transition-all duration-300">
                                <i class="fas fa-home text-4xl mb-4 opacity-90"></i>
                                <h4 class="text-lg font-semibold">Departments</h4>
                                <p class="text-sm opacity-90 mt-1">Create & manage Departments</p>
                            </a>
                            <a href="{{ route('academicterm.index') }}" class="group bg-gradient-to-br from-blue-600 to-blue-700 text-white rounded-xl p-6 shadow-lg hover:shadow-2xl hover:scale-105 transform transition-all duration-300">
                                <i class="fas fa-clock text-4xl mb-4 opacity-90"></i>
                                <h4 class="text-lg font-semibold">Academic Terms</h4>
                                <p class="text-sm opacity-90 mt-1">Create & manage Academic Terms</p>
                            </a>

                            <a href="{{ route('courses.index') }}" class="group bg-gradient-to-br from-green-600 to-emerald-700 text-white rounded-xl p-6 shadow-lg hover:shadow-2xl hover:scale-105 transform transition-all duration-300">
                                <i class="fas fa-user-graduate text-4xl mb-4 opacity-90"></i>
                                <h4 class="text-lg font-semibold">Courses</h4>
                                <p class="text-sm opacity-90 mt-1">Create & manage Courses</p>
                            </a>

                            <a href="{{ route('groups.index') }}" class="group bg-gradient-to-br from-orange-600 to-red-600 text-white rounded-xl p-6 shadow-lg hover:shadow-2xl hover:scale-105 transform transition-all duration-300">
                                <i class="fas fa-edit text-4xl mb-4 opacity-90"></i>
                                <h4 class="text-lg font-semibold">Course Groups</h4>
                                <p class="text-sm opacity-90 mt-1">Create & manage Course Groups</p>
                            </a>
                        </div>
                    @endif

                    <!-- Teacher Dashboard -->
                    @if(auth()->user()->user_role === 'teacher')
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            <!-- <a href="{{ route('groups.index') }}" class="group bg-gradient-to-br from-indigo-600 to-indigo-700 text-white rounded-xl p-6 shadow-lg hover:shadow-2xl hover:scale-105 transform transition-all duration-300">
                                <i class="fas fa-chalkboard text-4xl mb-4 opacity-90"></i>
                                <h4 class="text-lg font-semibold">My Classes</h4>
                                <p class="text-sm opacity-90 mt-1">View assigned classes</p>
                            </a>

                            <a href="{{ route('groups.index') }}" class="group bg-gradient-to-br from-teal-600 to-cyan-700 text-white rounded-xl p-6 shadow-lg hover:shadow-2xl hover:scale-105 transform transition-all duration-300">
                                <i class="fas fa-users text-4xl mb-4 opacity-90"></i>
                                <h4 class="text-lg font-semibold">Students</h4>
                                <p class="text-sm opacity-90 mt-1">View class rosters</p>
                            </a>
                            -->

                            <a href="{{ route('teacher.sessions') }}" class="group bg-gradient-to-br from-emerald-600 to-green-700 text-white rounded-xl p-6 shadow-lg hover:shadow-2xl hover:scale-105 transform transition-all duration-300 relative overflow-hidden">
                                <i class="fas fa-clipboard-check text-4xl mb-4 opacity-90"></i>
                                <h4 class="text-lg font-semibold">Take Attendance</h4>
                                <p class="text-sm opacity-90 mt-1">Mark present/absent</p>
                                <span class="absolute top-2 right-2 bg-white/20 px-2 py-1 rounded text-xs font-bold">LIVE</span>
                            </a>

                            <a href="" class="group bg-gradient-to-br from-amber-600 to-orange-600 text-white rounded-xl p-6 shadow-lg hover:shadow-2xl hover:scale-100 transform transition-all duration-300">
                                <i class="fas fa-chart-bar text-4xl mb-4 opacity-90"></i>
                                <h4 class="text-lg font-semibold">Reports</h4>
                                <p class="text-sm opacity-90 mt-1">View attendance stats</p>
                                <span class="absolute top-2 opacity-50 right-2 bg-white/20 px-2 py-1 rounded text-xs font-bold">DISABLED</span>
                            </a>
                        </div>
                    @endif

                    <!-- Student Dashboard -->
                    @if(auth()->user()->user_role === 'student')
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-4xl">
                            <a href="/student/self-attendance">
                            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 text-white rounded-xl p-8 shadow-lg hover:shadow-2xl hover:scale-105 transform transition-all duration-300">
                                <div class="flex items-center justify-between mb-6">
                                    <div>
                                        <h4 class="text-xl font-bold">Today's Status</h4>
                                        <p class="text-sm opacity-90 mt-1">Monday, {{ now()->format('d M Y') }}</p>
                                    </div>
                                    <i class="fas fa-calendar-day text-4xl opacity-80"></i>
                                </div>
                                <div class="text-4xl font-bold">
                                    @if($todayAttendance ?? false) <!-- change this logic-->
                                        <span class="text-green-300">Present</span>
                                    @else
                                        <span class="text-yellow-300">Not Marked</span>
                                    @endif
                                </div>
                            </div>
                            </a>

                            <a href="{{ route('student.attendance_summary') }}" class="group bg-gradient-to-br from-purple-600 to-pink-600 text-white rounded-xl p-8 shadow-lg hover:shadow-2xl hover:scale-105 transform transition-all duration-300">
                                <i class="fas fa-history text-4xl mb-4 opacity-90"></i>
                                <h4 class="text-xl font-semibold">Attendance History</h4>
                                <p class="text-sm opacity-90 mt-2">View all records</p>
                            </a>

                            <a href="/student/qrcode" class="group bg-gradient-to-br from-emerald-600 to-teal-700 text-white rounded-xl p-8 shadow-lg hover:shadow-2xl hover:scale-105 transform transition-all duration-300">
                                <i class="fas fa-qrcode text-4xl mb-4 opacity-90"></i>
                                <h4 class="text-xl font-semibold">My QR Code</h4>
                                <p class="text-sm opacity-90 mt-2">Show to teacher</p>
                            </a>
                        </div>
                    @endif

                    <!-- Fallback if no role matches -->
                    @if(!in_array(auth()->user()->user_role, ['admin', 'teacher', 'student']))
                        <div class="text-center py-12">
                            <i class="fas fa-exclamation-triangle text-6xl text-yellow-500 mb-4"></i>
                            <p class="text-xl text-gray-600 dark:text-gray-400">Role not configured properly.</p>
                            <p class="text-sm text-gray-500 mt-2">Contact administrator.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Optional Stats Row (for Teacher & Admin) -->
            @if(in_array(auth()->user()->user_role, ['teacher', 'admin']))
                <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Stats Cards -->
                    @foreach([
                        ['icon' => 'chalkboard-teacher', 'label' => 'Total Classes', 'value' => '12', 'bgColor' => 'bg-indigo-100 dark:bg-indigo-900', 'textColor' => 'text-indigo-600 dark:text-indigo-400'],
                        ['icon' => 'users', 'label' => 'Total Students', 'value' => '248', 'bgColor' => 'bg-green-100 dark:bg-green-900', 'textColor' => 'text-green-600 dark:text-green-400'],
                        ['icon' => 'clipboard-list', 'label' => 'Today Present', 'value' => '236', 'bgColor' => 'bg-blue-100 dark:bg-blue-900', 'textColor' => 'text-blue-600 dark:text-blue-400'],
                        ['icon' => 'chart-line', 'label' => 'Avg. Attendance', 'value' => '95.2%', 'bgColor' => 'bg-yellow-100 dark:bg-yellow-900', 'textColor' => 'text-yellow-600 dark:text-yellow-400']
                    ] as $stat)
                        <div class="bg-gray-700 p-6 rounded-lg shadow">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full {{ $stat['bgColor'] }} {{ $stat['textColor'] }}">
                                    <i class="fas fa-{{ $stat['icon'] }} text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $stat['label'] }}</p>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stat['value'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
