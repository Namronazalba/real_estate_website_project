<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit House – {{ $house->title }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <form action="{{ route('houses.update', $house->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-semibold">Title</label>
                    <input type="text" name="title" value="{{ old('title', $house->title) }}" 
                           class="w-full border rounded-lg p-2" required>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-semibold">Description</label>
                    <textarea name="description" rows="4" class="w-full border rounded-lg p-2" required>{{ old('description', $house->description) }}</textarea>
                </div>

                <!-- Price -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-semibold">Price</label>
                    <input type="number" name="price" value="{{ old('price', $house->price) }}" 
                           class="w-full border rounded-lg p-2" required>
                </div>

                <!-- Location -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-semibold">Location</label>
                    <input type="text" name="location" value="{{ old('location', $house->location) }}" 
                           class="w-full border rounded-lg p-2" required>
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-semibold">Status</label>
                    <select name="status" class="w-full border rounded-lg p-2" required>
                        <option value="available" {{ $house->status === 'available' ? 'selected' : '' }}>Available</option>
                        <option value="pending" {{ $house->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="sold" {{ $house->status === 'sold' ? 'selected' : '' }}>Sold</option>
                    </select>
                </div>

                <!-- Image -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-semibold">Image</label>
                    @if($house->image)
                        <img src="{{ asset('storage/' . $house->image) }}" class="h-48 w-auto rounded mb-3">
                    @endif
                    <input type="file" name="image" class="w-full border rounded-lg p-2">
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('houses.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
