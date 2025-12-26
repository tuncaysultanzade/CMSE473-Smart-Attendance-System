
<x-app-layout>
    <x-slot name="header">
        <h2>Create Academic Term</h2>
    </x-slot>

    <div class="py-8">

                @if ($errors->any())
    <div class="mb-4 text-red-600">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <form action="{{ route('academicterm.store') }}" method="POST">
                    @csrf
                    @include('academicterm._form')
                </form>
            </div>
        </div>
    </div>
</x-app-layout>



