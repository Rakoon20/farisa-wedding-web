@extends('layouts.app')
@section('title', 'Koleksi Baju Pernikahan')

@section('content')
<div class="bg-linear-to-b from-pink-50 to-white py-12">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-2">Koleksi<span class="text-pink-500"> Farisa</span></h1>
            <div class="w-24 h-1 bg-pink-500 mx-auto mb-4"></div>
            <p class="text-gray-600 max-w-2xl mx-auto">Inspirasi model Pakaian untuk hari spesial Anda</p>
        </div>
<!-- Filter Kategori -->
<div class="flex flex-wrap justify-center gap-3 mb-10">
    <button onclick="filterCategory('all')" 
        class="category-btn active px-5 py-2 rounded-full bg-pink-500 text-white hover:bg-pink-600 transition">
        Semua
    </button>

    @foreach($clothes->pluck('category')->unique()->filter() as $category)
        <button onclick="filterCategory('{{ strtolower($category) }}')" 
            class="category-btn px-5 py-2 rounded-full bg-white text-gray-700 shadow hover:bg-pink-500 hover:text-white transition">
            {{ ucfirst($category) }}
        </button>
    @endforeach
</div>
        <!-- Grid Koleksi Baju -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($clothes as $cloth)
                <div class="cloth-item group bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 cursor-pointer"
                    data-category="{{ strtolower($cloth->category ?? '') }}"
                    onclick="openModal('{{ Storage::url($cloth->image) }}', '{{ $cloth->name }}', '{{ $cloth->category ?? '' }}')">
                    <div class="relative overflow-hidden h-64">
                        <img src="{{ Storage::url($cloth->image) }}" 
                             alt="{{ $cloth->name }}"
                             class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition duration-300 flex items-center justify-center">
                            <i class="fas fa-search-plus text-white text-3xl opacity-0 group-hover:opacity-100 transition duration-300"></i>
                        </div>
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="font-semibold text-gray-800 text-lg">{{ $cloth->name }}</h3>
                        @if($cloth->category)
                            <p class="text-pink-500 text-sm mt-1">{{ ucfirst($cloth->category) }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <i class="fas fa-tshirt text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg">Belum ada koleksi baju. Silakan cek kembali nanti.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Modal Lightbox (diperbaiki ukurannya) -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-90 hidden items-center justify-center z-50 transition-all duration-300" onclick="closeModal()">
    <div class="relative max-w-lg w-full mx-4" onclick="event.stopPropagation()">
        <button onclick="closeModal()" class="absolute -top-10 right-0 text-white text-3xl hover:text-pink-400 transition">&times;</button>
        <img id="modalImage" src="" alt="" class="w-full max-h-[80vh] object-contain rounded-lg shadow-2xl">
        <div class="text-center mt-4">
            <h3 id="modalName" class="text-white text-xl font-semibold"></h3>
            <p id="modalCategory" class="text-pink-300 text-sm mt-1"></p>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    #imageModal {
        backdrop-filter: blur(5px);
    }
</style>
@endpush

@push('scripts')
<script>
    function filterCategory(category) {

    const items = document.querySelectorAll('.cloth-item');
    const buttons = document.querySelectorAll('.category-btn');

    buttons.forEach(btn => {
        btn.classList.remove(
            'bg-pink-500',
            'text-white'
        );

        btn.classList.add(
            'bg-white',
            'text-gray-700'
        );
    });


    event.target.classList.remove(
        'bg-white',
        'text-gray-700'
    );

    event.target.classList.add(
        'bg-pink-500',
        'text-white'
    );


    items.forEach(item => {

        const itemCategory = item.dataset.category;


        if(category === 'all' || itemCategory === category){

            item.style.display = "block";

        }else{

            item.style.display = "none";

        }

    });

}
    function openModal(imageUrl, name, category) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const modalName = document.getElementById('modalName');
        const modalCategory = document.getElementById('modalCategory');
        
        modalImage.src = imageUrl;
        modalName.innerText = name;
        modalCategory.innerText = category ? category.charAt(0).toUpperCase() + category.slice(1) : '';
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    
    function closeModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }
    
    // Menutup modal dengan tombol ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('imageModal');
            if (modal && !modal.classList.contains('hidden')) {
                closeModal();
            }
        }
    });
</script>
@endpush