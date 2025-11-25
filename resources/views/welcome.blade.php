<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- 🔥 IMPORTANT for mobile -->
    <title>Real Estate Marketplace</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

<header class="bg-white shadow mb-6">
    <div class="container mx-auto flex justify-between items-center p-4">
        <h1 class="text-xl md:text-2xl font-bold text-blue-600">
            House and Lot For Sale
        </h1>
    </div>
</header>

<main class="container mx-auto px-4 py-8">
    <h2 class="text-2xl md:text-3xl font-bold text-center mb-8">Available Houses</h2>

    @if($houses->count())
        <!-- 1 col on mobile, 2 on tablets, 3 on desktop -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 md:gap-8">
            
            @foreach ($houses as $house)
                <div class="bg-white rounded-2xl shadow hover:shadow-lg transition p-4">

                @php
                    $imageSrc = $house->image 
                        ? asset('storage/' . $house->image) 
                        : asset('images/no-image.png');
                    $imageAlt = $house->image ? $house->title : 'No Image';
                @endphp

                <!-- Responsive image -->
                <img 
                    src="{{ $imageSrc }}" 
                    alt="{{ $imageAlt }}" 
                    onclick="openModal('{{ $imageSrc }}')" 
                    class="rounded-lg mb-4 w-full h-52 sm:h-60 md:h-64 object-cover cursor-zoom-in"
                />

                <h3 class="text-lg md:text-xl font-semibold mb-1">{{ $house->title }}</h3>
                <p class="text-gray-600 mb-1 text-sm md:text-base">{{ $house->location }}</p>
                <p class="text-blue-600 font-bold mb-3 text-lg">
                    ₱{{ number_format($house->price, 2) }}
                </p>

                <a href="{{ route('visitor.house_features', $house->id) }}" 
                class="block text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition text-sm md:text-base">
                    View Details
                </a>

                </div>
            @endforeach

        </div>
    @else
        <p class="text-center text-gray-500">No houses available right now.</p>
    @endif

    <!-- 🔍 IMAGE MODAL (Mobile-optimized) -->
    <div id="imageModal" 
        class="fixed inset-0 bg-black bg-opacity-80 hidden justify-center items-center z-50">
        
        <div class="relative inline-block">
            
            <!-- Close button (TOP RIGHT on image) -->
            <button 
                onclick="closeModal()"
                class="absolute top-2 right-2 text-white text-3xl font-bold z-50 
                      hover:text-red-400 transition px-2">
                &times;
            </button>

            <!-- Image -->
            <img id="modalImage"
                class="max-h-[90vh] max-w-[90vw] rounded-lg shadow-lg"
                alt="House Image">

            <!-- Magnifier -->
            <div id="magnifier"
                class="hidden absolute w-40 h-40 border-2 border-white rounded-full pointer-events-none"
                style="background-repeat:no-repeat; background-size:200%;">
            </div>

        </div>
    </div>


</main>

<footer class="bg-gray-800 text-white text-center py-4 mt-10 text-sm md:text-base">
    © {{ date('Y') }} Real Estate Marketplace. All rights reserved.
</footer>

<!-- SCRIPT -->
<script>
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const magnifier = document.getElementById('magnifier');
    let zoom = 2;

    // Detect mobile device
    const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

    function openModal(src) {
        modalImage.src = src;
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Disable magnifier on mobile
        if (isMobile) {
            magnifier.style.display = "none";
            return;
        }

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

    // Desktop magnifier only
    if (!isMobile) {
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
    }
</script>

</body>
</html>
