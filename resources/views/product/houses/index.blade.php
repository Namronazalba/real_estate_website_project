@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 px-4">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4 sm:gap-0">
        <h1 class="text-2xl sm:text-3xl font-bold">Available Houses</h1>
        <a href="{{ route('houses.create') }}" 
           class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm sm:text-base w-full sm:w-auto text-center">
            + Add New House
        </a>
    </div>

    @if($houses->count() > 0)
        {{-- Houses Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
            @foreach ($houses as $house)
                <div class="border rounded-xl shadow p-4 flex flex-col">
                    @if($house->image)
                        <img src="{{ asset('storage/' . $house->image) }}"
                             alt="{{ $house->title }}" 
                             class="rounded-lg mb-4 w-full h-48 sm:h-56 md:h-64 object-cover">
                    @else
                        <img src="{{ asset('images/no-image.png') }}" 
                             alt="No Image" 
                             class="rounded-lg mb-4 w-full h-48 sm:h-56 md:h-64 object-cover">
                    @endif

                    <h2 class="text-xl font-semibold">{{ $house->title }}</h2>
                    <p class="text-gray-600">{{ $house->location }}</p>
                    <p class="text-blue-600 font-bold mt-2">₱{{ number_format($house->price, 2) }}</p>

                    <div class="mt-3 flex flex-col sm:flex-row sm:gap-2">
                        <a href="{{ route('house_features.index', $house->id) }}" 
                           class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 text-center">
                            View
                        </a>
                        @auth
                        <a href="{{ route('houses.edit', $house->id) }}" 
                           class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 text-center mt-2 sm:mt-0">
                            Edit
                        </a>
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $houses->links() }}
        </div>

    @else
        <p class="text-gray-500 text-center mt-10">No houses available right now.</p>
    @endif
</div>
@endsection
