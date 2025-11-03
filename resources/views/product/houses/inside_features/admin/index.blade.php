<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $house->title }} – Inside Features</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <div class="container mx-auto py-10">
        <a href="{{ route('houses.index') }}" class="text-blue-600 hover:underline mb-4 inline-block">← Back to Home</a>

        <h1 class="text-3xl font-bold mb-4">{{ $house->title }} – Inside Features</h1>

        {{-- Upload form (for logged-in users only) --}}
        @auth
        <form action="{{ route('house_features.store', $house->id) }}" 
            method="POST" 
            enctype="multipart/form-data" 
            class="mb-6 bg-white p-4 rounded-lg shadow">
            @csrf
            <label class="block mb-2 font-semibold">Upload New Inner View Image</label>

            <input type="file" name="feature" required class="border rounded p-2 w-full mb-4">

            <input type="text" name="caption" placeholder="Caption (optional)" class="border rounded p-2 w-full mb-4">

            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                Upload
            </button>
        </form>
        @endauth


        {{-- Display all existing features --}}
        @if($features->count())
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($features as $feature)
                    <div class="bg-white rounded-lg shadow p-2">
                        <img src="{{ asset('storage/' . $feature->image) }}" 
                             alt="{{ $feature->caption ?? 'House Feature' }}" 
                             class="rounded-lg w-full h-56 object-cover">
                        @if($feature->caption)
                            <p class="text-gray-600 text-sm mt-2 text-center">{{ $feature->caption }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center mt-10">No inner view images available yet.</p>
        @endif
    </div>

</body>
</html>
