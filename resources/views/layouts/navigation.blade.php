<nav x-data="{ open: false }" class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                        <x-application-logo class="block h-10 w-auto fill-current text-indigo-600 dark:text-indigo-400 group-hover:scale-105 transition-transform duration-200" />
                        <span class="text-xl font-bold text-gray-800 dark:text-white tracking-tight">AttendAI</span>
                    </a>
                </div>

                <!-- Navigation Links - Role-Based & Matches Your Dashboard Exactly -->
                <div class="hidden sm:flex sm:items-center sm:space-x-8 sm:ms-10">

                    <!-- Always show Dashboard -->
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                        class="text-sm font-medium text-gray-300 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                        <i class="fas fa-tachometer-alt mr-2"></i> {{ __('Dashboard') }}
                    </x-nav-link>

                    <!-- ADMIN ONLY -->
                    @if(auth()->user()->user_role === 'admin' || auth()->user()->role === 'admin')
                        <x-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.index')"
                            class="text-sm font-medium text-gray-300 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                            <i class="fas fa-users-cog mr-2"></i> {{ __('Users') }}
                        </x-nav-link>

                        <x-nav-link href="{{ route('departments.index') }}" :active="request()->routeIs('departments.index')"
                            class="text-sm font-medium text-gray-300 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                            <i class="fas fa-building mr-2"></i> {{ __('Departments') }}
                        </x-nav-link>

                        <x-nav-link href="{{ route('academicterm.index') }}" :active="request()->routeIs('academicterm.index')"
                            class="text-sm font-medium text-gray-300 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                            <i class="fas fa-calendar-alt mr-2"></i> {{ __('Academic Term') }}
                        </x-nav-link>

                        <x-nav-link href="{{ route('courses.index') }}" :active="request()->routeIs('courses.index')"
                            class="text-sm font-medium text-gray-300 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                            <i class="fas fa-book-open mr-2"></i> {{ __('Courses') }}
                        </x-nav-link>

                        <x-nav-link href="{{ route('groups.index') }}" :active="request()->routeIs('groups.index')"
                            class="text-sm font-medium text-gray-300 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                            <i class="fas fa-user-friends mr-2"></i> {{ __('Groups') }}
                        </x-nav-link>
                    @endif

                    <!-- TEACHER ONLY -->
                    @if(auth()->user()->user_role === 'teacher' || auth()->user()->role === 'teacher')
                        <x-nav-link href="{{ route('teacher.sessions') }}" :active="request()->routeIs('teacher.sessions')"
                            class="text-sm font-medium text-gray-300 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                            <i class="fas fa-chalkboard-teacher mr-2"></i> {{ __('My Sessions') }}
                        </x-nav-link>
                    @endif

                    <!-- STUDENT ONLY -->
                    @if(auth()->user()->user_role === 'student' || auth()->user()->role === 'student')
                        <x-nav-link href="{{ route('student.self_attendance') }}" :active="request()->routeIs('student.self_attendance')"
                            class="text-sm font-medium text-gray-300 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                            <i class="fas fa-clipboard-list mr-2"></i> {{ __('My Attendance') }}
                        </x-nav-link>

                        <x-nav-link href="{{ route('student.qrcode') }}" :active="request()->routeIs('student.qrcode')"
                            class="text-sm font-medium text-gray-300 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                            <i class="fas fa-qrcode mr-2"></i> {{ __('My QR Code') }}
                        </x-nav-link>

                        <x-nav-link href="{{ route('student.attendance_summary') }}" :active="request()->routeIs('student.attendance_summary')"
                            class="text-sm font-medium text-gray-300 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                            <i class="fas fa-chart-line mr-2"></i> {{ __('Summary') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Right Side: User Menu -->
            <div class="hidden sm:flex sm:items-center sm:space-x-4">
                <!-- Notification Bell -->
                <button class="relative p-2 text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition rounded-full hover:bg-gray-100 dark:hover:bg-gray-800">
                    <i class="fas fa-bell text-lg"></i>
                    <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500 ring-2 ring-white dark:ring-gray-900"></span>
                </button>

                <!-- User Dropdown -->
                <x-dropdown align="right" width="64">
                    <x-slot name="trigger">
                        <button class="flex items-center space-x-3 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @if(Auth::user()->avatar)
                                <img class="h-9 w-9 rounded-full object-cover ring-2 ring-gray-300 dark:ring-gray-600" src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}">
                            @else
                                <div class="h-9 w-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm ring-2 ring-white dark:ring-gray-800">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </div>
                            @endif
                            <div class="hidden lg:block text-left">
                                <div class="text-sm font-semibold">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ ucfirst(Auth::user()->role ?? Auth::user()->user_role) }}
                                </div>
                            </div>
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                            <div class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                            <div class="mt-1 text-xs font-semibold text-indigo-600 dark:text-indigo-400">
                                {{ ucfirst(Auth::user()->role ?? Auth::user()->user_role) }}
                            </div>
                        </div>

                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fas fa-user-circle mr-3"></i> {{ __('Profile') }}
                        </x-dropdown-link>

                        <div class="border-t border-gray-200 dark:border-gray-700"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt mr-3 text-red-600"></i> {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Hamburger -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open" class="p-2 rounded-lg text-gray-600 hover:text-indigo-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-block': !open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-block': open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="sm:hidden bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <i class="fas fa-tachometer-alt mr-3"></i> {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(auth()->user()->user_role === 'admin' || auth()->user()->role === 'admin')
                <x-responsive-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.*')">
                    <i class="fas fa-users-cog mr-3"></i> {{ __('Users') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('departments.index') }}">Departments</x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('academicterm.index') }}">Academic Term</x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('courses.index') }}">Courses</x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('groups.index') }}">Groups</x-responsive-nav-link>
            @endif

            @if(auth()->user()->user_role === 'teacher' || auth()->user()->role === 'teacher')
                <x-responsive-nav-link href="{{ route('teacher.sessions') }}">My Sessions</x-responsive-nav-link>
            @endif

            @if(auth()->user()->user_role === 'student' || auth()->user()->role === 'student')
                <x-responsive-nav-link href="{{ route('student.self_attendance') }}">My Attendance</x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('student.qrcode') }}">My QR Code</x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('student.attendance_summary') }}">Summary</x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center px-5">
                <div class="flex-shrink-0">
                    @if(Auth::user()->avatar)
                        <img class="h-10 w-10 rounded-full" src="{{ Auth::user()->avatar }}" alt="">
                    @else
                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                    @endif
                </div>
                <div class="ml-3">
                    <div class="text-base font-medium text-gray-800 dark:text-white">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        {{ ucfirst(Auth::user()->role ?? Auth::user()->user_role) }}
                    </div>
                </div>
            </div>

            <div class="mt-3 space-y-1 px-2">
                <x-responsive-nav-link :href="route('profile.edit')">
                    <i class="fas fa-user mr-3"></i> {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="fas fa-sign-out-alt mr-3 text-red-600"></i> {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Add Font Awesome once in your main layout -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">