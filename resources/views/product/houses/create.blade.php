@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8 max-w-2xl">
        <h1 class="text-3xl font-bold mb-6">Add New House</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
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
                <label class="block font-medium">Title</label>
                <input type="text" name="title" class="w-full border rounded-lg p-2" value="{{ old('title') }}" required>
            </div>

            <div>
                <label class="block font-medium">Description</label>
                <textarea name="description" rows="4" class="w-full border rounded-lg p-2" required>{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block font-medium">Price (₱)</label>
                <input type="number" name="price" class="w-full border rounded-lg p-2" value="{{ old('price') }}" required>
            </div>

            <div>
                <label class="block font-medium">Location</label>
                <input type="text" name="location" class="w-full border rounded-lg p-2" value="{{ old('location') }}" required>
            </div>

            <div>
                <label class="block font-medium">Image</label>
                <input type="file" name="image" class="w-full border rounded-lg p-2">
            </div>

            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Save House
                </button>
            </div>
        </form>
    </div>
@endsection
