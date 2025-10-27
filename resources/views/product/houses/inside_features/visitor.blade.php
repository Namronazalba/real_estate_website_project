<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $house->title }} – Inside Features</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <header class="bg-white shadow mb-6">
        <div class="container mx-auto flex justify-between items-center p-4">
            <h1 class="text-2xl font-bold text-blue-600">🏠 Real Estate</h1>
            <a href="{{ route('welcome') }}" class="text-blue-600 hover:underline">← Back to Houses</a>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold text-center mb-8">{{ $house->title }}</h2>
        <p class="text-gray-600 text-center mb-4">{{ $house->location }}</p>
        <p class="text-blue-600 text-center text-xl font-bold mb-8">₱{{ number_format($house->price, 2) }}</p>
        {{-- 🏡 House Description --}}
        @if($house->description)
            <div class="bg-white shadow rounded-lg p-6 mb-10 max-w-3xl mx-auto">
                <h3 class="text-2xl font-semibold text-gray-800 mb-3 text-center">Description</h3>
                <p class="text-gray-700 leading-relaxed text-center">
                    {{ $house->description }}
                </p>
            </div>
        @endif
        {{-- Display all inside features --}}
        @if($features->count())
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($features as $feature)
                    <div class="bg-white rounded-lg shadow p-2">
                        <img src="{{ asset('storage/' . $feature->image) }}" 
                             alt="{{ $feature->caption ?? 'House Feature' }}" 
                             class="rounded-lg w-full h-56 object-cover mb-2">
                        @if($feature->caption)
                            <p class="text-gray-700 text-center font-semibold">{{ $feature->caption }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-500 mt-10">No inside photos available for this house yet.</p>
        @endif

        {{-- 📨 Contact Form --}}
        <section class="mt-16 max-w-3xl mx-auto bg-white shadow rounded-lg p-8">
            <h3 class="text-2xl font-semibold text-gray-800 mb-4 text-center">Interested in this Property?</h3>
            <p class="text-gray-600 text-center mb-6">Fill out the form below and our team will contact you shortly.</p>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4 text-center">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('visitor.contact', $house->id) }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-gray-700 mb-1 font-medium">Full Name</label>
                    <input type="text" name="name" required 
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
                </div>

                <div>
                    <label class="block text-gray-700 mb-1 font-medium">Email Address</label>
                    <input type="email" name="email" required 
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
                </div>

                <div>
                    <label class="block text-gray-700 mb-1 font-medium">Mobile Number</label>
                    <input type="text" name="mobile" required 
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
                </div>

                <div>
                    <label class="block text-gray-700 mb-1 font-medium">Message</label>
                    <textarea name="message" rows="4" required 
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"></textarea>
                </div>

                <div class="text-center">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition">
                        Send Message
                    </button>
                </div>
            </form>
        </section>

    </main>

    <footer class="bg-gray-800 text-white text-center py-4 mt-10">
        © {{ date('Y') }} Real Estate Marketplace. All rights reserved.
    </footer>

</body>
</html>
