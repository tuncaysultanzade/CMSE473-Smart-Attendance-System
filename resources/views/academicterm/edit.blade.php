<x-app-layout>
    <x-slot name="header">
        <h2>Edit Academic Term</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <form action="{{ route('academicterm.update', $academicterm) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('academicterm._form')
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
