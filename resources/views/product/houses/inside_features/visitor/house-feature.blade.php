<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- mobile scaling -->
    <title>{{ $house->title }} – Inside Features</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<header class="bg-white shadow mb-6">
    <div class="container mx-auto flex flex-col sm:flex-row justify-between items-center p-4 gap-2 sm:gap-0">
        <h1 class="text-xl sm:text-2xl font-bold text-blue-600">Other Photos</h1>
        <a href="{{ route('welcome') }}" class="text-blue-600 hover:underline text-sm sm:text-base">← Back to Houses</a>
    </div>
</header>

<main class="container mx-auto px-4 py-8">
    <h2 class="text-2xl sm:text-3xl font-bold text-center mb-8">{{ $house->title }}</h2>
    <p class="text-gray-600 text-center mb-4 text-sm sm:text-base">{{ $house->location }}</p>
    <p class="text-blue-600 text-center text-lg sm:text-xl font-bold mb-8">₱{{ number_format($house->price, 2) }}</p>

    @if($house->description)
        <div class="bg-white shadow rounded-lg p-6 mb-10 max-w-3xl mx-auto">
            <h3 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-3 text-center">Description</h3>
            <p class="text-gray-700 leading-relaxed text-center text-sm sm:text-base">
                {{ $house->description }}
            </p>
        </div>
    @endif

    {{-- Inside Features --}}
    @if($features->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
            @foreach($features as $feature)
                <div class="bg-white rounded-lg shadow p-2">
                    <img 
                        src="{{ asset('storage/' . $feature->image) }}" 
                        alt="{{ $feature->caption ?? 'House Feature' }}" 
                        class="rounded-lg w-full h-48 sm:h-56 md:h-60 object-cover mb-2 cursor-pointer"
                        onclick="openModal('{{ asset('storage/'.$feature->image) }}')"
                    >
                    @if($feature->caption)
                        <p class="text-gray-700 text-center font-semibold text-sm sm:text-base">{{ $feature->caption }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-gray-500 mt-10 text-sm sm:text-base">No inside photos available for this house yet.</p>
    @endif

    {{-- Contact Form --}}
    <section class="mt-16 max-w-3xl mx-auto bg-white shadow rounded-lg p-6 sm:p-8">
        <h3 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-4 text-center">Interested in this Property?</h3>
        <p class="text-gray-600 text-center mb-6 text-sm sm:text-base">Fill out the form below and our team will contact you shortly.</p>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('visitor.contact', $house->id) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-700 mb-1 font-medium text-sm sm:text-base">Full Name</label>
                <input type="text" name="name" required 
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
            </div>
            <div>
                <label class="block text-gray-700 mb-1 font-medium text-sm sm:text-base">Email Address</label>
                <input type="email" name="email" required 
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
            </div>
            <div>
                <label class="block text-gray-700 mb-1 font-medium text-sm sm:text-base">Mobile Number</label>
                <input type="text" name="mobile" required 
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
            </div>
            <div>
                <label class="block text-gray-700 mb-1 font-medium text-sm sm:text-base">Message</label>
                <textarea name="message" rows="4" required 
                          class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"></textarea>
            </div>
            <div class="text-center">
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 sm:px-6 py-2 rounded-lg transition text-sm sm:text-base">
                    Send Message
                </button>
            </div>
        </form>
    </section>

</main>

<footer class="bg-gray-800 text-white text-center py-4 mt-10 text-sm sm:text-base">
    © {{ date('Y') }} Real Estate Marketplace. All rights reserved.
</footer>

{{-- IMAGE MODAL --}}
<div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 p-4">
    <div class="relative inline-block max-w-full max-h-full">
        <button 
            onclick="closeModal()"
            class="absolute top-2 right-2 text-white text-3xl font-bold z-50 hover:text-red-400 px-2">
            &times;
        </button>
        <img id="modalImage" class="max-w-[90vw] max-h-[75vh] rounded-lg shadow-lg object-contain">
        <div id="magnifier" class="hidden absolute w-32 h-32 md:w-40 md:h-40 border-2 border-white rounded-full pointer-events-none" style="background-repeat:no-repeat;"></div>
    </div>
</div>

{{-- Magnifier Script --}}
<script>
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const magnifier = document.getElementById('magnifier');
    let zoom = 2;
    const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

    function openModal(src) {
        modalImage.src = src;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        if (isMobile) { magnifier.style.display = "none"; return; }
        modalImage.onload = () => {
            magnifier.style.backgroundImage = `url('${src}')`;
            magnifier.style.backgroundSize = `${modalImage.width * zoom}px ${modalImage.height * zoom}px`;
        };
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    modal.addEventListener('click', e => { if(e.target===modal) closeModal(); });

    if(!isMobile) {
        modalImage.addEventListener('mousemove', e => {
            const rect = modalImage.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const bgX = (x / rect.width) * 100;
            const bgY = (y / rect.height) * 100;
            magnifier.style.left = (x - magnifier.offsetWidth/2) + 'px';
            magnifier.style.top = (y - magnifier.offsetHeight/2) + 'px';
            magnifier.style.backgroundPosition = `${bgX}% ${bgY}%`;
            magnifier.classList.remove('hidden');
        });
        modalImage.addEventListener('mouseleave', () => magnifier.classList.add('hidden'));
    }
</script>

</body>
</html>
