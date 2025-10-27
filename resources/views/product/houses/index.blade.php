@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Available Houses</h1>
        <a href="{{ route('houses.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
            + Add New House
        </a>
    </div>

    @if($houses->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($houses as $house)
                <div class="border rounded-xl shadow p-4">
                    @if($house->image)
                        <img src="{{ asset('storage/' . $house->image) }}"
                        alt="{{ $house->title }}" 
                        class="rounded-lg mb-4 w-full h-64 object-cover">
                    @else
                        <img src="{{ asset('images/no-image.png') }}" alt="No Image" class="rounded-lg mb-4">
                    @endif

                    <h2 class="text-xl font-semibold">{{ $house->title }}</h2>
                    <p class="text-gray-600">{{ $house->location }}</p>
                    <p class="text-blue-600 font-bold mt-2">₱{{ number_format($house->price, 2) }}</p>

                    <a href="{{ route('house_features.index', $house->id) }}" class="inline-block mt-3 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        View
                    </a>
                    @auth
                        <a href="{{ route('houses.edit', $house->id) }}" class="inline-block mt-3 px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                            Edit
                        </a>
                    @endauth
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $houses->links() }}
        </div>
    @else
        <p class="text-gray-500">No houses available right now.</p>
    @endif
</div>
@endsection
