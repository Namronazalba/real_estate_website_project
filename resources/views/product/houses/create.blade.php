@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 px-4 max-w-full sm:max-w-xl md:max-w-2xl">

    <h1 class="text-2xl sm:text-3xl font-bold mb-6 text-center sm:text-left">Add New House</h1>

    {{-- Display Validation Errors --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm sm:text-base">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('houses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block font-medium text-sm sm:text-base mb-1">Title</label>
            <input type="text" name="title" class="w-full border rounded-lg p-2 sm:p-3" value="{{ old('title') }}" required>
        </div>

        <div>
            <label class="block font-medium text-sm sm:text-base mb-1">Description</label>
            <textarea name="description" rows="4" class="w-full border rounded-lg p-2 sm:p-3" required>{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block font-medium text-sm sm:text-base mb-1">Price (₱)</label>
            <input type="number" name="price" class="w-full border rounded-lg p-2 sm:p-3" value="{{ old('price') }}" required>
        </div>

        <div>
            <label class="block font-medium text-sm sm:text-base mb-1">Location</label>
            <input type="text" name="location" class="w-full border rounded-lg p-2 sm:p-3" value="{{ old('location') }}" required>
        </div>

        <div>
            <label class="block font-medium text-sm sm:text-base mb-1">Image</label>
            <input type="file" name="image" class="w-full border rounded-lg p-2 sm:p-3">
        </div>

        <div class="flex justify-center sm:justify-start">
            <button type="submit" 
                    class="bg-blue-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg hover:bg-blue-700 w-full sm:w-auto text-sm sm:text-base transition">
                Save House
            </button>
        </div>
    </form>
</div>
@endsection
