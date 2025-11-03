<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $house->title }} – Inside Features</title>
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
</head>
<body class="bg-gray-100">

    <header class="bg-white shadow mb-6">
        <div class="container mx-auto flex justify-between items-center p-4">
            <h1 class="text-2xl font-bold text-blue-600">🏠 Real Estate</h1>
            <a href="{{ route('welcome') }}" class="text-blue-600 hover:underline">← Back to Houses</a>
        </div>
    </header>

    {{-- 🔹 React Mount Point --}}
    <div id="house-features"
        data-house='@json($house)'
        data-features='@json($features)'>
    </div>

    <footer class="bg-gray-800 text-white text-center py-4 mt-10">
        © {{ date('Y') }} Real Estate Marketplace. All rights reserved.
    </footer>

</body>
</html>
