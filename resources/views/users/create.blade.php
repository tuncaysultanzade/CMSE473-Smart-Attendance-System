<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl  leading-tight">Add User</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('users.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700">User ID</label>
                        <input type="text" name="user_id" id="user_id" value="{{ old('user_id') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    </div>

                    <div>
                        <label for="user_email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('user_email') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    </div>

                    <div>
                        <label for="user_name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('user_name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    </div>

                    <div>
                        <label for="user_surname" class="block text-sm font-medium text-gray-700">Surname</label>
                        <input type="text" name="surname" id="surname" value="{{ old('user_surname') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    </div>

                    <div>
                        <label for="user_password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" id="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    </div>

                    <div>
                        <label for="user_role" class="block text-sm font-medium text-gray-700">Role</label>
                        <select name="user_role" id="user_role" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select role</option>
                            <option value="student" {{ old('user_role') == 'student' ? 'selected' : '' }}>Student</option>
                            <option value="teacher" {{ old('user_role') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                            <option value="admin" {{ old('user_role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <div>
                        <label for="user_department_id" class="block text-sm font-medium text-gray-700">Department ID</label>
                        <input type="number" name="user_department_id" id="user_department_id" value="{{ old('user_department_id') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    </div>

                    <div>
                        <label for="is_active" class="block text-sm font-medium text-gray-700">Is Active?</label>
                        <select name="is_active" id="is_active" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <div class="flex justify-between items-center">
                        <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-900">Back to Dashboard</a>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-white bg-indigo-600 rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Add User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
