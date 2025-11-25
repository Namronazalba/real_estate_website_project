<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- essential for mobile -->
    <title>{{ $house->title }} – Inside Features</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<div class="container mx-auto py-6 px-4">

    <a href="{{ route('houses.index') }}" class="text-blue-600 hover:underline mb-4 inline-block text-sm sm:text-base">
        ← Back to Home
    </a>

    <h1 class="text-2xl sm:text-3xl font-bold mb-6 text-center sm:text-left">
        {{ $house->title }} – Inside Features
    </h1>

    {{-- Upload form (for logged-in users only) --}}
    @auth
    <form action="{{ route('house_features.store', $house->id) }}" 
          method="POST" 
          enctype="multipart/form-data" 
          class="mb-6 bg-white p-4 sm:p-6 rounded-lg shadow space-y-4">
        @csrf
        <label class="block font-semibold text-sm sm:text-base">Upload New Inner View Image</label>

        <input type="file" name="feature" required class="border rounded p-2 w-full">

        <input type="text" name="caption" placeholder="Caption (optional)" class="border rounded p-2 w-full">

        <button type="submit" 
                class="bg-green-600 text-white px-4 sm:px-6 py-2 rounded hover:bg-green-700 transition w-full sm:w-auto text-sm sm:text-base">
            Upload
        </button>
    </form>
    @endauth

    {{-- Display all existing features --}}
    @if($features->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
            @foreach($features as $feature)
                <div class="bg-white rounded-lg shadow p-2">
                    <img src="{{ asset('storage/' . $feature->image) }}" 
                         alt="{{ $feature->caption ?? 'House Feature' }}" 
                         class="rounded-lg w-full h-48 sm:h-56 md:h-60 object-cover mb-2">
                    @if($feature->caption)
                        <p class="text-gray-600 text-sm sm:text-base mt-2 text-center">{{ $feature->caption }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500 text-center mt-10 text-sm sm:text-base">No inner view images available yet.</p>
    @endif

</div>

</body>
</html>
