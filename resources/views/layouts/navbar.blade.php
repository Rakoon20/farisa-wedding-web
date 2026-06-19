<nav x-data="{ mobileMenuOpen: false }" class="bg-white shadow-md fixed w-full top-0 z-50">
    <div class="container mx-auto px-4 py-3">
        <div class="flex justify-between items-center">

                        <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center space-x-3">
                <img src="{{ asset('images/Farisa Wedding Logo.svg') }}" 
                    alt="Logo Farisa Wedding" 
                    class="h-10 w-auto">

                <span class="font-bold text-xl text-gray-800">
                    Farisa <span class="text-pink-500">Wedding</span>
                </span>
            </a>
            <!-- Desktop Menu dengan Dropdown -->
            <div class="hidden md:flex space-x-6 items-center">
                <a href="{{ url('/') }}" class="text-gray-700 hover:text-pink-500 transition {{ request()->is('/') ? 'text-pink-500 border-b-2 border-pink-500' : '' }}">Beranda</a>

                <!-- Dropdown Pesan -->
                <div class="relative group">
                    <a href="#" class="text-gray-700 hover:text-pink-500 transition flex items-center gap-1">
                        Pesan <i class="fas fa-chevron-down text-xs"></i>
                    </a>
                    <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-10">
                        <a href="{{ url('/packages') }}" class="block px-4 py-2 text-gray-700 hover:bg-pink-50">Lihat Paket</a>
                        <a href="{{ url('/order') }}" class="block px-4 py-2 text-gray-700 hover:bg-pink-50">Pesan Sekarang</a>
                    </div>
                </div>

                <a href="{{ url('/gallery') }}" class="text-gray-700 hover:text-pink-500 transition {{ request()->is('gallery*') ? 'text-pink-500 border-b-2 border-pink-500' : '' }}">Galeri</a>

                <!-- Menu langsung Koleksi Baju -->
                <a href="{{ route('clothes.index') }}" class="text-gray-700 hover:text-pink-500 transition {{ request()->is('clothes*') ? 'text-pink-500 border-b-2 border-pink-500' : '' }}">
                    Koleksi Baju
                </a>

                <!-- Dropdown Info -->
                <div class="relative group">
                    <a href="#" class="text-gray-700 hover:text-pink-500 transition flex items-center gap-1">
                        Info <i class="fas fa-chevron-down text-xs"></i>
                    </a>
                    <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-10">
                        <a href="{{ url('/about') }}" class="block px-4 py-2 text-gray-700 hover:bg-pink-50">Tentang Kami</a>
                        <a href="{{ url('/contact') }}" class="block px-4 py-2 text-gray-700 hover:bg-pink-50">Kontak</a>
                        <a href="{{ url('/tracking') }}" class="block px-4 py-2 text-gray-700 hover:bg-pink-50">Cek Pesanan</a>
                    </div>
                </div>
            </div>

            <!-- Desktop Buttons -->
            <div class="hidden md:flex space-x-3 items-center">
                <!-- Tombol Admin (statis, selalu muncul) -->
                <a href="{{ url('/admin') }}" class="text-gray-700 hover:text-pink-500 transition flex items-center gap-1">
                    <i class="fas fa-user-shield"></i> Admin
                </a>
                <a href="{{ url('/order') }}" class="bg-green-500 text-white px-5 py-2 rounded-full hover:bg-green-600 transition">
                    <i class="fas fa-shopping-cart mr-2"></i>Pesan
                </a>
                <a href="{{ url('/contact') }}" class="bg-pink-500 text-white px-5 py-2 rounded-full hover:bg-pink-600 transition">
                    <i class="fas fa-phone-alt mr-2"></i>Hubungi
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-gray-700 focus:outline-none">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-transition.duration.300ms class="md:hidden mt-4 pb-4 space-y-3">
            <a href="{{ url('/') }}" class="block text-gray-700 hover:text-pink-500 py-2">Beranda</a>
            <a href="{{ url('/packages') }}" class="block text-gray-700 hover:text-pink-500 py-2">Paket Wedding</a>
            <a href="{{ url('/order') }}" class="block text-gray-700 hover:text-pink-500 py-2">Pesan Sekarang</a>
            <a href="{{ url('/gallery') }}" class="block text-gray-700 hover:text-pink-500 py-2">Galeri</a>
            <a href="{{ route('clothes.index') }}" class="block text-gray-700 hover:text-pink-500 py-2">Koleksi Baju</a>
            <a href="{{ url('/about') }}" class="block text-gray-700 hover:text-pink-500 py-2">Tentang Kami</a>
            <a href="{{ url('/contact') }}" class="block text-gray-700 hover:text-pink-500 py-2">Kontak</a>
            <a href="{{ url('/tracking') }}" class="block text-gray-700 hover:text-pink-500 py-2">Cek Pesanan</a>
            <!-- Tombol Admin di mobile -->
            <a href="{{ url('/admin') }}" class="block text-gray-700 hover:text-pink-500 py-2">
                <i class="fas fa-user-shield mr-1"></i> Admin
            </a>
            <a href="{{ url('/order') }}" class="block bg-green-500 text-white px-5 py-2 rounded-full text-center hover:bg-green-600">Pesan Sekarang</a>
            <a href="{{ url('/contact') }}" class="block bg-pink-500 text-white px-5 py-2 rounded-full text-center hover:bg-pink-600">Hubungi Kami</a>
        </div>
    </div>
</nav>