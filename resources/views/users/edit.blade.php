<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">Edit User</h2>
    </x-slot>

    <div class="py-10 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6">

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('users.update', $user) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="user_id" class="block font-medium text-sm text-gray-700">User ID</label>
                    <input type="text" id="user_id" name="user_id" value="{{ old('user_id', $user->user_id) }}" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" />
                </div>

                <div class="mb-4">
                    <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" />
                </div>

                <div class="mb-4">
                    <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" />
                </div>

                <div class="mb-4">
                    <label for="surname" class="block font-medium text-sm text-gray-700">Surname</label>
                    <input type="text" id="surname" name="surname" value="{{ old('surname', $user->surname) }}" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" />
                </div>

                <div class="mb-4">
                    <label for="user_role" class="block font-medium text-sm text-gray-700">Role</label>
                    <select id="user_role" name="user_role" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        <option value="student" {{ old('user_role', $user->user_role) == 'student' ? 'selected' : '' }}>Student</option>
                        <option value="teacher" {{ old('user_role', $user->user_role) == 'teacher' ? 'selected' : '' }}>Teacher</option>
                        <option value="admin" {{ old('user_role', $user->user_role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="user_department_id" class="block font-medium text-sm text-gray-700">Department</label>
                    <select id="user_department_id" name="user_department_id" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}"
                                {{ old('user_department_id', $user->user_department_id) == $department->id ? 'selected' : '' }}>
                                {{ $department->department_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="password" class="block font-medium text-sm text-gray-700">Password (leave blank to keep current)</label>
                    <input type="password" id="password" name="password"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" />
                </div>

                <div class="mb-4">
                    <label for="is_active" class="inline-flex items-center">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }} class="rounded">
                        <span class="ml-2 text-gray-700">Active</span>
                    </label>
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 transition">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Update User</button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
