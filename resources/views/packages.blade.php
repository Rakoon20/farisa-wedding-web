@extends('layouts.app')

@section('title', 'Paket Wedding - Farisa Wedding Organizer')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-cover bg-center py-20" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=1600');">
        <div class="container mx-auto px-4 text-center text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Paket <span class="text-pink-400">Wedding</span></h1>
            <div class="w-20 h-1 bg-pink-400 mx-auto mb-4"></div>
            <p class="text-lg max-w-2xl mx-auto">Pilih paket pernikahan yang sesuai dengan kebutuhan dan budget Anda</p>
        </div>
    </section>

    <!-- Packages Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            @if($packages->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($packages as $package)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300 flex flex-col h-full">
                            <!-- Image -->
                            <div class="h-56 overflow-hidden">
                                @if($package->image)
                                    <img src="{{ Storage::url($package->image) }}" alt="{{ $package->name }}" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                                @else
                                    <div class="w-full h-full bg-linear-to-br from-pink-200 to-pink-300 flex items-center justify-center">
                                        <i class="fas fa-image text-pink-400 text-5xl"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="p-6 flex flex-col grow">
                                <!-- Title -->
                                <h3 class="font-bold text-xl text-gray-800 mb-2 line-clamp-1">{{ $package->name }}</h3>
                                
                                <!-- Price -->
                                <div class="mb-3">
                                    <span class="text-pink-500 font-bold text-2xl">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                                </div>

                                <!-- Description (truncate) -->
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                    {{ Str::limit($package->description ?? 'Deskripsi paket belum tersedia. Silakan hubungi kami untuk informasi lebih lanjut.', 100) }}
                                </p>

                                <!-- Buttons -->
                                <div class="flex gap-3 mt-auto pt-4">
                                    <a href="{{ route('packages.show', $package->code) }}" 
                                       class="flex-1 text-center border border-pink-500 text-pink-500 py-2 rounded-full hover:bg-pink-500 hover:text-white transition duration-300">
                                        <i class="fas fa-info-circle mr-1"></i>Detail
                                    </a>
                                    <a href="{{ route('order.index', ['package' => $package->code]) }}" 
                                       class="flex-1 text-center bg-pink-500 text-white py-2 rounded-full hover:bg-pink-600 transition duration-300">
                                        <i class="fas fa-shopping-cart mr-1"></i>Pesan
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <i class="fas fa-gift text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg">Belum ada paket wedding. Silakan cek kembali nanti.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-pink-500">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Butuh Bantuan Memilih Paket?</h2>
            <p class="text-white text-lg mb-8 max-w-2xl mx-auto">Tim kami siap membantu Anda memilih paket yang sesuai dengan kebutuhan dan budget.</p>
            <a href="{{ url('/contact') }}" class="bg-white text-pink-500 px-8 py-3 rounded-full hover:bg-gray-100 transition duration-300 font-semibold">
                <i class="fas fa-headset mr-2"></i>Konsultasi Gratis
            </a>
        </div>
    </section>
@endsection

@push('styles')
<style>
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush