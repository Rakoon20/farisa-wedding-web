@extends('layouts.app')

@section('title', 'Farisa Wedding Organizer - Solusi Pernikahan Impian Anda')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-cover bg-center h-screen" style="background-image: url('{{ asset('images/home1.jpg') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative container mx-auto px-4 h-full flex flex-col justify-center items-center text-center text-white">
            <h1 class="text-4xl md:text-6xl font-bold mb-4 animate-fade-in">
                Wujudkan <span class="text-pink-400">Hari Bahagia</span> Anda
            </h1>
            <p class="text-lg md:text-xl mb-8 max-w-2xl">
                Farisa Wedding Organizer siap membantu Anda merencanakan pernikahan impian dengan pelayanan terbaik dan dekorasi yang memukau.
            </p>
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="{{ url('/packages') }}" class="bg-pink-500 text-white px-8 py-3 rounded-full hover:bg-pink-600 transition duration-300 font-semibold">
                    Lihat Paket Wedding
                </a>
                <a href="{{ url('/contact') }}" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-full hover:bg-white hover:text-pink-500 transition duration-300 font-semibold">
                    Konsultasi Gratis
                </a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Tentang <span class="text-pink-500">Farisa WO</span></h2>
                <div class="w-20 h-1 bg-pink-500 mx-auto"></div>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Kami hadir untuk memberikan pengalaman pernikahan yang tak terlupakan</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <img src="{{ asset('images/home2.jpg') }}" alt="Wedding Decoration" class="rounded-lg shadow-lg w-full">
                </div>
                <div>
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Pengalaman Lebih dari 10 Tahun</h3>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        Farisa Wedding Organizer telah dipercaya oleh ratusan pasangan untuk mewujudkan pernikahan impian mereka. 
                        Dengan tim profesional dan pengalaman yang matang, kami siap memberikan pelayanan terbaik untuk hari spesial Anda.
                    </p>
                    <div class="grid grid-cols-2 gap-4 mt-6">
                        <div class="text-center">
                            <i class="fas fa-smile text-pink-500 text-3xl mb-2"></i>
                            <p class="text-2xl font-bold text-gray-800">500+</p>
                            <p class="text-gray-500">Pasangan Bahagia</p>
                        </div>
                        <div class="text-center">
                            <i class="fas fa-calendar-check text-pink-500 text-3xl mb-2"></i>
                            <p class="text-2xl font-bold text-gray-800">1000+</p>
                            <p class="text-gray-500">Acara Sukses</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Kenapa Memilih <span class="text-pink-500">Kami?</span></h2>
                <div class="w-20 h-1 bg-pink-500 mx-auto"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition">
                    <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-palette text-pink-500 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-xl mb-2">Dekorasi Eksklusif</h3>
                    <p class="text-gray-600">Desain dekorasi yang elegan dan sesuai dengan tema pernikahan impian Anda.</p>
                </div>
                <div class="text-center p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition">
                    <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clock text-pink-500 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-xl mb-2">Tepat Waktu</h3>
                    <p class="text-gray-600">Komitmen tinggi terhadap jadwal dan waktu pelaksanaan acara.</p>
                </div>
                <div class="text-center p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition">
                    <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-pink-500 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-xl mb-2">Konsultasi 24/7</h3>
                    <p class="text-gray-600">Tim kami siap membantu Anda kapan saja selama proses persiapan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-pink-500">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Siap Memulai Perjalanan Pernikahan Anda?</h2>
            <p class="text-white text-lg mb-8 max-w-2xl mx-auto">Hubungi kami sekarang dan dapatkan konsultasi gratis untuk paket wedding impian Anda.</p>
            <a href="{{ url('/contact') }}" class="bg-white text-pink-500 px-8 py-3 rounded-full hover:bg-gray-100 transition duration-300 font-semibold">
                Hubungi Kami Sekarang
            </a>
        </div>
    </section>
@endsection

@push('styles')
<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-fade-in {
        animation: fade-in 1s ease-out;
    }
</style>
@endpush