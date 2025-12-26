<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Academic Terms
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                @if (session('success'))
                    <div class="mb-4 text-green-600 font-medium">{{ session('success') }}</div>
                @endif

                <div class="flex justify-end mb-4">
                    <a href="{{ route('academicterm.create') }}"
                       class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">+ Add New Term</a>
                </div>

                <table class="min-w-full border-collapse border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Term</th>
                            <th class="px-4 py-2 text-left">Year</th>
                            <th class="px-4 py-2 text-left">Start</th>
                            <th class="px-4 py-2 text-left">End</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($academicterms as $term)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $term->term }}</td>
                            <td class="px-4 py-2">{{ $term->year }}</td>
                            <td class="px-4 py-2">{{ $term->term_start->format('Y-m-d') }}</td>
                            <td class="px-4 py-2">{{ $term->term_end->format('Y-m-d') }}</td>
                            <td class="px-4 py-2">
                                @if($term->is_active)
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Active</span>
                                @else
                                    <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-sm">Inactive</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-center space-x-1">
                                <a href="{{ route('academicterm.show', $term->id) }}" class="text-blue-600 hover:underline">View</a>
                                <a href="{{ route('academicterm.edit', $term->id) }}" class="text-yellow-600 hover:underline">Edit</a>
                                <form action="{{ route('academicterm.destroy', $term->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:underline"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">No academic terms found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $academicterms->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
