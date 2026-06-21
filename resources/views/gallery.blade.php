@extends('layouts.app')

@section('title', 'Galeri - Farisa Wedding Organizer')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-cover bg-center py-20" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=1600');">
        <div class="container mx-auto px-4 text-center text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Galeri <span class="text-pink-400">Pernikahan</span></h1>
            <div class="w-20 h-1 bg-pink-400 mx-auto mb-4"></div>
            <p class="text-lg max-w-2xl mx-auto">Inspirasi dekorasi dan momen bahagia dari klien-klien kami</p>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="py-8 bg-white sticky top-16 z-20 shadow-sm">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-center gap-3">
                {{-- Tombol "Semua" tanpa kelas warna bawaan --}}
                <button data-filter="all" class="filter-btn active px-6 py-2 rounded-full transition duration-300">Semua</button>
                @foreach($categories as $key => $label)
                    <button data-filter="{{ $key }}" class="filter-btn px-6 py-2 rounded-full transition duration-300">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            @if($galleries->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 gallery-grid">
                    @foreach($galleries as $gallery)
                        <div class="gallery-item" data-category="{{ $gallery->category }}">
                            <div class="group relative overflow-hidden rounded-xl shadow-lg cursor-pointer" onclick="openLightbox({{ $loop->index }})">
                                <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition duration-300 flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white text-3xl opacity-0 group-hover:opacity-100 transition duration-300"></i>
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4 opacity-0 group-hover:opacity-100 transition duration-300">
                                    <p class="text-white font-semibold">{{ $gallery->title }}</p>
                                    <p class="text-gray-300 text-sm">{{ $gallery->subtitle }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <i class="fas fa-images text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg">Belum ada foto gallery. Silakan cek kembali nanti.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Lightbox Modal -->
    <div id="lightbox" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden items-center justify-center" onclick="closeLightbox()">
        <div class="relative max-w-5xl mx-auto p-4" onclick="event.stopPropagation()">
            <button onclick="closeLightbox()" class="absolute -top-12 right-0 text-white text-3xl hover:text-pink-400 transition">
                <i class="fas fa-times-circle"></i>
            </button>
            <button id="prevBtn" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-30 hover:bg-opacity-50 text-white p-3 rounded-full transition">
                <i class="fas fa-chevron-left text-2xl"></i>
            </button>
            <img id="lightbox-img" src="" alt="" class="max-w-full max-h-[80vh] mx-auto rounded-lg shadow-2xl">
            <button id="nextBtn" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-30 hover:bg-opacity-50 text-white p-3 rounded-full transition">
                <i class="fas fa-chevron-right text-2xl"></i>
            </button>
            <div id="lightbox-caption" class="text-center text-white mt-4 text-lg"></div>
        </div>
    </div>

    <!-- CTA Section -->
    <section class="py-16 bg-pink-500">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Ingin Dekorasi Seperti di Galeri?</h2>
            <p class="text-white text-lg mb-8 max-w-2xl mx-auto">Konsultasikan pernikahan impian Anda dengan tim profesional kami.</p>
            <a href="{{ url('/contact') }}" class="bg-white text-pink-500 px-8 py-3 rounded-full hover:bg-gray-100 transition duration-300 font-semibold">
                Konsultasi Sekarang
            </a>
        </div>
    </section>
@endsection

@push('styles')
<style>
    /* Default tombol filter (abu-abu) */
    .filter-btn {
        background-color: #e5e7eb; /* gray-200 */
        color: #374151; /* gray-700 */
    }
    /* Tombol aktif (pink) */
    .filter-btn.active {
        background-color: #ec489a !important; /* pink-500 */
        color: white !important;
    }
    /* Efek hover untuk semua tombol */
    .filter-btn:hover {
        background-color: #ec489a;
        color: white;
    }

    .gallery-item {
        transition: all 0.3s ease;
    }
    .gallery-item.hide {
        display: none;
    }
</style>
@endpush

@push('scripts')
<script>
    // Data gallery dari server
    const galleryData = @json($galleries);
    let currentImages = [];
    let currentIndex = 0;

    // Prepare gallery data untuk lightbox
    galleryData.forEach((item, index) => {
        currentImages.push({
            src: "{{ asset('storage') }}/" + item.image,
            caption: item.title + (item.subtitle ? ' - ' + item.subtitle : '')
        });
    });

    // ======= FILTER GALLERY =======
    document.addEventListener('DOMContentLoaded', function () {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const galleryItems = document.querySelectorAll('.gallery-item');

        filterButtons.forEach(button => {
            button.addEventListener('click', function () {
                // 1. Hapus kelas 'active' dari semua tombol
                filterButtons.forEach(btn => btn.classList.remove('active'));
                // 2. Tambahkan 'active' ke tombol yang diklik
                this.classList.add('active');

                const filterValue = this.getAttribute('data-filter');

                // 3. Tampilkan/sembunyikan item galeri
                galleryItems.forEach(item => {
                    if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                        item.classList.remove('hide');
                    } else {
                        item.classList.add('hide');
                    }
                });
            });
        });
    });

    // ======= LIGHTBOX =======
    function openLightbox(index) {
        if (!currentImages.length) return;
        currentIndex = index;
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightbox-img');
        const lightboxCaption = document.getElementById('lightbox-caption');
        
        lightboxImg.src = currentImages[currentIndex].src;
        lightboxCaption.innerText = currentImages[currentIndex].caption;
        lightbox.classList.remove('hidden');
        lightbox.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        const lightbox = document.getElementById('lightbox');
        lightbox.classList.add('hidden');
        lightbox.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    function nextImage() {
        if (!currentImages.length) return;
        currentIndex = (currentIndex + 1) % currentImages.length;
        const lightboxImg = document.getElementById('lightbox-img');
        const lightboxCaption = document.getElementById('lightbox-caption');
        lightboxImg.src = currentImages[currentIndex].src;
        lightboxCaption.innerText = currentImages[currentIndex].caption;
    }

    function prevImage() {
        if (!currentImages.length) return;
        currentIndex = (currentIndex - 1 + currentImages.length) % currentImages.length;
        const lightboxImg = document.getElementById('lightbox-img');
        const lightboxCaption = document.getElementById('lightbox-caption');
        lightboxImg.src = currentImages[currentIndex].src;
        lightboxCaption.innerText = currentImages[currentIndex].caption;
    }

    // Event listener untuk tombol prev/next
    document.getElementById('prevBtn')?.addEventListener('click', (e) => {
        e.stopPropagation();
        prevImage();
    });
    
    document.getElementById('nextBtn')?.addEventListener('click', (e) => {
        e.stopPropagation();
        nextImage();
    });

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        const lightbox = document.getElementById('lightbox');
        if (lightbox.classList.contains('flex')) {
            if (e.key === 'ArrowLeft') prevImage();
            else if (e.key === 'ArrowRight') nextImage();
            else if (e.key === 'Escape') closeLightbox();
        }
    });
</script>
@endpush