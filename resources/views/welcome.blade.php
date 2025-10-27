<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Real Estate Marketplace</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <header class="bg-white shadow mb-6">
        <div class="container mx-auto flex justify-between items-center p-4">
            <h1 class="text-2xl font-bold text-blue-600">🏠Zechariah Real Estate</h1>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold text-center mb-8">Available Houses</h2>

        @if($houses->count())
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach ($houses as $house)
                    <div class="bg-white rounded-2xl shadow hover:shadow-lg transition p-4">
                    @php
                        $imageSrc = $house->image 
                            ? asset('storage/' . $house->image) 
                            : asset('images/no-image.png');
                        $imageAlt = $house->image ? $house->title : 'No Image';
                    @endphp

                    <img 
                        src="{{ $imageSrc }}" 
                        alt="{{ $imageAlt }}" 
                        onclick="openModal('{{ $imageSrc }}')" 
                        class="rounded-lg mb-4 w-full h-64 object-cover cursor-zoom-in"
                    />


                        <h3 class="text-xl font-semibold mb-1">{{ $house->title }}</h3>
                        <p class="text-gray-600 mb-1">{{ $house->location }}</p>
                        <p class="text-blue-600 font-bold mb-3">₱{{ number_format($house->price, 2) }}</p>

                        <a href="{{ route('visitor.house_features', $house->id) }}" 
                           class="block text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                            View Details
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                
            </div>
        @else
            <p class="text-center text-gray-500">No houses available right now.</p>
        @endif
        <div id="imageModal" 
        class="fixed inset-0 bg-black bg-opacity-80 hidden justify-center items-center z-50">
        <div class="relative">
            <button 
                onclick="closeModal()"
                class="absolute top-4 right-4 text-white text-3xl font-bold hover:text-red-400 transition">
                &times;
            </button>

            <div class="relative inline-block">
                <img id="modalImage"
                    class="max-h-[90vh] max-w-[90vw] rounded-lg shadow-lg"
                    alt="House Image">
                <div id="magnifier"
                    class="hidden absolute w-40 h-40 border-2 border-white rounded-full pointer-events-none"
                    style="background-repeat:no-repeat; background-size:200%;">
                </div>
            </div>
        </div>
</div>
<script>
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const magnifier = document.getElementById('magnifier');
    let zoom = 2; 

    function openModal(src) {
        modalImage.src = src;
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        modalImage.onload = () => {
            magnifier.style.backgroundImage = `url('${src}')`;
            magnifier.style.backgroundSize = `${modalImage.width * zoom}px ${modalImage.height * zoom}px`;
        };
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

    modalImage.addEventListener('mousemove', function(e) {
        const rect = this.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        const bgX = (x / rect.width) * 100;
        const bgY = (y / rect.height) * 100;

        magnifier.style.left = (x - magnifier.offsetWidth / 2) + 'px';
        magnifier.style.top = (y - magnifier.offsetHeight / 2) + 'px';
        magnifier.style.backgroundPosition = `${bgX}% ${bgY}%`;
        magnifier.classList.remove('hidden');
    });

    modalImage.addEventListener('mouseleave', () => {
        magnifier.classList.add('hidden');
    });
</script>
    </main>

    <footer class="bg-gray-800 text-white text-center py-4 mt-10">
        © {{ date('Y') }} Real Estate Marketplace. All rights reserved.
    </footer>
</body>
</html>
