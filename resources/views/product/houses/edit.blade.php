<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl sm:text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit House – {{ $house->title }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-full sm:max-w-xl lg:max-w-4xl mx-auto bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow">

            <form action="{{ route('houses.update', $house->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-1">Title</label>
                    <input type="text" name="title" value="{{ old('title', $house->title) }}" 
                           class="w-full border rounded-lg p-2 sm:p-3" required>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-1">Description</label>
                    <textarea name="description" rows="4" class="w-full border rounded-lg p-2 sm:p-3" required>{{ old('description', $house->description) }}</textarea>
                </div>

                <!-- Price & Location (stack on mobile, side by side on medium screens) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-1">Price</label>
                        <input type="number" name="price" value="{{ old('price', $house->price) }}" 
                               class="w-full border rounded-lg p-2 sm:p-3" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-1">Location</label>
                        <input type="text" name="location" value="{{ old('location', $house->location) }}" 
                               class="w-full border rounded-lg p-2 sm:p-3" required>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-1">Status</label>
                    <select name="status" class="w-full border rounded-lg p-2 sm:p-3" required>
                        <option value="available" {{ $house->status === 'available' ? 'selected' : '' }}>Available</option>
                        <option value="pending" {{ $house->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="sold" {{ $house->status === 'sold' ? 'selected' : '' }}>Sold</option>
                    </select>
                </div>

                <!-- Image -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-1">Image</label>
                    @if($house->image)
                        <img src="{{ asset('storage/' . $house->image) }}" class="h-40 sm:h-48 w-auto rounded mb-3">
                    @endif
                    <input type="file" name="image" class="w-full border rounded-lg p-2 sm:p-3">
                </div>

                <!-- Buttons (stack on mobile, side by side on larger screens) -->
                <div class="flex flex-col sm:flex-row sm:justify-end gap-3 mt-2">
                    <a href="{{ route('houses.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 text-center w-full sm:w-auto">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 w-full sm:w-auto">
                        Update
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
