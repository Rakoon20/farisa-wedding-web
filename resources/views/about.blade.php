@extends('layouts.app')

@section('title', 'Tentang Kami - Farisa Wedding Organizer')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-cover bg-center py-24" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1519741497674-611481863552?w=1600');">
        <div class="container mx-auto px-4 text-center text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Tentang <span class="text-pink-400">Kami</span></h1>
            <div class="w-20 h-1 bg-pink-400 mx-auto mb-4"></div>
            <p class="text-lg max-w-2xl mx-auto">Wedding Organizer profesional yang membantu perencanaan pernikahan Anda dari konsep hingga hari pelaksanaan.</p>
        </div>
    </section>

    <!-- Profil Singkat -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Profil <span class="text-pink-500">Perusahaan</span></h2>
                <div class="w-20 h-1 bg-pink-500 mx-auto mb-6"></div>
                <p class="text-gray-600 leading-relaxed">
                    Farisa Wedding Organizer didirikan pada tahun 2014 sebagai penyedia jasa perencanaan dan pelaksanaan pernikahan.
                    Kami menangani proses pemesanan paket, koordinasi dekorasi dan vendor, hingga dokumentasi acara, dengan sistem
                    pemesanan dan pelacakan pesanan yang terstruktur agar setiap tahap dapat dipantau dengan jelas oleh calon pengantin.
                </p>
            </div>
        </div>
    </section>

    <!-- Visi & Misi -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Visi & <span class="text-pink-500">Misi</span></h2>
                <div class="w-20 h-1 bg-pink-500 mx-auto"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Visi -->
                <div class="bg-white rounded-lg p-8 shadow-md text-center">
                    <div class="w-20 h-20 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-eye text-pink-500 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Visi</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Menjadi Wedding Organizer yang terpercaya dan profesional di wilayah Banten, serta mampu memberikan layanan pernikahan berkualitas dengan harga yang terjangkau.
                    </p>
                </div>

                <!-- Misi -->
                <div class="bg-white rounded-lg p-8 shadow-md text-center">
                    <div class="w-20 h-20 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bullseye text-pink-500 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Misi</h3>
                    <ul class="text-left text-gray-600 space-y-2">
                        <li><i class="fas fa-check-circle text-pink-500 mr-2"></i> Memberikan pelayanan konsultasi pernikahan secara menyeluruh kepada klien</li>
                        <li><i class="fas fa-check-circle text-pink-500 mr-2"></i> Menyediakan paket pernikahan yang variatif dan kompetitif</li>
                        <li><i class="fas fa-check-circle text-pink-500 mr-2"></i> Menjalin kerja sama dengan vendor-vendor terpercaya</li>
                        <li><i class="fas fa-check-circle text-pink-500 mr-2"></i> Melakukan pengembangan layanan secara berkelanjutan</li>
                        <li><i class="fas fa-check-circle text-pink-500 mr-2"></i> Membangun kepercayaan klien melalui profesionalisme dalam setiap proses pelayanan</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Cakupan Layanan -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Cakupan <span class="text-pink-500">Layanan</span></h2>
                <div class="w-20 h-1 bg-pink-500 mx-auto"></div>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Layanan yang kami tangani dalam setiap paket pernikahan</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg p-6 shadow-md text-center">
                    <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clipboard-list text-pink-500 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Perencanaan & Konsultasi</h3>
                    <p class="text-gray-500 text-sm">Konsultasi kebutuhan acara dan penyusunan paket sesuai anggaran.</p>
                </div>
                <div class="bg-white rounded-lg p-6 shadow-md text-center">
                    <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-palette text-pink-500 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Dekorasi</h3>
                    <p class="text-gray-500 text-sm">Penataan dekorasi indoor maupun outdoor sesuai konsep acara.</p>
                </div>
                <div class="bg-white rounded-lg p-6 shadow-md text-center">
                    <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-handshake text-pink-500 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Koordinasi Vendor</h3>
                    <p class="text-gray-500 text-sm">Pengelolaan kebutuhan tenda, kursi, katering, dan jasa pendukung lainnya.</p>
                </div>
                <div class="bg-white rounded-lg p-6 shadow-md text-center">
                    <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-camera text-pink-500 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Dokumentasi</h3>
                    <p class="text-gray-500 text-sm">Pencatatan momen acara melalui foto dan video.</p>
                </div>
            </div>
            <div class="text-center mt-10">
                <a href="{{ url('/packages') }}" class="border border-pink-500 text-pink-500 px-8 py-3 rounded-full hover:bg-pink-500 hover:text-white transition duration-300 font-semibold inline-flex items-center">
                    <i class="fas fa-box-open mr-2"></i>Lihat Paket Lengkap
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Siapkan <span class="text-pink-500">Hari Spesial</span> Anda Bersama Kami</h2>
            <p class="text-gray-600 mb-8 max-w-2xl mx-auto">Konsultasikan rencana pernikahan Anda dengan tim profesional kami secara gratis.</p>
            <a href="{{ url('/contact') }}" class="bg-pink-500 text-white px-8 py-3 rounded-full hover:bg-pink-600 transition duration-300 font-semibold inline-flex items-center">
                <i class="fas fa-calendar-alt mr-2"></i>Konsultasi Gratis
            </a>
        </div>
    </section>
@endsection