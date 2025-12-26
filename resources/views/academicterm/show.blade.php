<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Academic Term Details
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <table class="table-auto w-full border-collapse">
                    <tbody class="divide-y divide-gray-200">
                        <tr>
                            <th class="text-left py-2 px-4 font-medium">Term</th>
                            <td class="py-2 px-4">{{ $academicterm->term }}</td>
                        </tr>
                        <tr>
                            <th class="text-left py-2 px-4 font-medium">Year</th>
                            <td class="py-2 px-4">{{ $academicterm->year }}</td>
                        </tr>
                        <tr>
                            <th class="text-left py-2 px-4 font-medium">Start Date</th>
                            <td class="py-2 px-4">{{ \Carbon\Carbon::parse($academicterm->term_start)->format('Y-m-d') }}</td>
                        </tr>
                        <tr>
                            <th class="text-left py-2 px-4 font-medium">End Date</th>
                            <td class="py-2 px-4">{{ \Carbon\Carbon::parse($academicterm->term_end)->format('Y-m-d') }}</td>
                        </tr>
                        <tr>
                            <th class="text-left py-2 px-4 font-medium">Status</th>
                            <td class="py-2 px-4">
                                @if($academicterm->is_active)
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Active</span>
                                @else
                                    <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-sm">Inactive</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="mt-6 flex space-x-2">
                    <a href="{{ route('academicterm.edit', $academicterm) }}"
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">Edit</a>
                    <a href="{{ route('academicterm.index') }}"
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Back</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
