<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">Add Department</h2>
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

                <form method="POST" action="{{ route('departments.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="department_code" class="block text-sm font-medium text-gray-700">Department Code</label>
                        <input type="text" name="department_code" id="department_code" value="{{ old('department_code') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    </div>

                    <div>
                        <label for="department_name" class="block text-sm font-medium text-gray-700">Department Name</label>
                        <input type="text" name="department_name" id="department_name" value="{{ old('department_name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    </div>

                    <div>
                        <label for="department_coordinates" class="block text-sm font-medium text-gray-700">Department Coordinates</label>
                        <input type="text" name="department_coordinates" id="department_coordinates" value="{{ old('department_coordinates') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    </div>

                    <div>
                        <label for="department_radius_in_meters" class="block text-sm font-medium text-gray-700">Department Radius (meters)</label>
                        <input type="number" name="department_radius_in_meters" id="department_radius_in_meters" value="{{ old('department_radius_in_meters', 100) }}" min="0" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    </div>

                    <div class="flex justify-between items-center">
                        <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-900">Back to Dashboard</a>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-white bg-green-600 rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            Add Department
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
