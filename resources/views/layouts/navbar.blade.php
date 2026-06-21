<nav x-data="{ mobileMenuOpen: false }" 
     class="fixed top-0 z-50 w-full bg-white/80 backdrop-blur-lg border-b border-pink-100 shadow-sm">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <div class="flex justify-between items-center">

            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center space-x-3 group">
                <img src="{{ asset('images/Farisa Wedding Logo.svg') }}" 
                    alt="Logo Farisa Wedding" 
                    class="h-10 w-auto transition-transform duration-300 group-hover:scale-105">
                <span class="font-bold text-xl text-gray-800">
                    Farisa <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-rose-400">Wedding</span>
                </span>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8 text-sm font-medium">
                <a href="{{ url('/') }}" 
                   class="relative inline-block text-gray-700 hover:text-pink-600 transition-colors duration-200 after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:scale-x-0 after:bg-gradient-to-r after:from-pink-400 after:to-rose-400 after:transition-transform after:duration-300 after:origin-left hover:after:scale-x-100 {{ request()->is('/') ? 'text-pink-500 after:scale-x-100' : '' }}">
                    Beranda
                </a>

                <!-- Dropdown Pesan -->
                <div class="relative group">
                    <a href="#" 
                       class="relative inline-flex items-center gap-1 text-gray-700 hover:text-pink-600 transition-colors duration-200">
                        Pesan <i class="fas fa-chevron-down text-xs transition-transform duration-200 group-hover:rotate-180"></i>
                    </a>
                    <div class="absolute left-0 mt-3 w-56 bg-white rounded-xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform -translate-y-1 group-hover:translate-y-0 z-20 py-2">
                        <a href="{{ url('/packages') }}" 
                           class="block mx-2 px-4 py-2.5 text-gray-700 rounded-lg hover:bg-pink-50 hover:text-pink-600 transition-colors duration-150">
                            <i class="fas fa-box-open mr-2 text-pink-400 w-5"></i>Lihat Paket
                        </a>
                        <a href="{{ url('/order') }}" 
                           class="block mx-2 px-4 py-2.5 text-gray-700 rounded-lg hover:bg-pink-50 hover:text-pink-600 transition-colors duration-150">
                            <i class="fas fa-shopping-cart mr-2 text-pink-400 w-5"></i>Pesan Sekarang
                        </a>
                    </div>
                </div>

                <a href="{{ url('/gallery') }}" 
                   class="relative inline-block text-gray-700 hover:text-pink-600 transition-colors duration-200 after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:scale-x-0 after:bg-gradient-to-r after:from-pink-400 after:to-rose-400 after:transition-transform after:duration-300 after:origin-left hover:after:scale-x-100 {{ request()->is('gallery*') ? 'text-pink-500 after:scale-x-100' : '' }}">
                    Galeri
                </a>

                <a href="{{ route('clothes.index') }}" 
                   class="relative inline-block text-gray-700 hover:text-pink-600 transition-colors duration-200 after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:scale-x-0 after:bg-gradient-to-r after:from-pink-400 after:to-rose-400 after:transition-transform after:duration-300 after:origin-left hover:after:scale-x-100 {{ request()->is('clothes*') ? 'text-pink-500 after:scale-x-100' : '' }}">
                    Koleksi Baju
                </a>

                <!-- Dropdown Info -->
                <div class="relative group">
                    <a href="#" 
                       class="relative inline-flex items-center gap-1 text-gray-700 hover:text-pink-600 transition-colors duration-200">
                        Info <i class="fas fa-chevron-down text-xs transition-transform duration-200 group-hover:rotate-180"></i>
                    </a>
                    <div class="absolute left-0 mt-3 w-56 bg-white rounded-xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform -translate-y-1 group-hover:translate-y-0 z-20 py-2">
                        <a href="{{ url('/about') }}" 
                           class="block mx-2 px-4 py-2.5 text-gray-700 rounded-lg hover:bg-pink-50 hover:text-pink-600 transition-colors duration-150">
                            <i class="fas fa-info-circle mr-2 text-pink-400 w-5"></i>Tentang Kami
                        </a>
                        <a href="{{ url('/contact') }}" 
                           class="block mx-2 px-4 py-2.5 text-gray-700 rounded-lg hover:bg-pink-50 hover:text-pink-600 transition-colors duration-150">
                            <i class="fas fa-envelope mr-2 text-pink-400 w-5"></i>Kontak
                        </a>
                        <a href="{{ url('/tracking') }}" 
                           class="block mx-2 px-4 py-2.5 text-gray-700 rounded-lg hover:bg-pink-50 hover:text-pink-600 transition-colors duration-150">
                            <i class="fas fa-search-location mr-2 text-pink-400 w-5"></i>Cek Pesanan
                        </a>
                    </div>
                </div>
            </div>

            <!-- Desktop Buttons -->
            <div class="hidden md:flex items-center space-x-4">
                <a href="{{ url('/admin') }}" 
                   class="text-gray-500 hover:text-pink-500 transition-colors duration-200 p-2 rounded-full hover:bg-pink-50" 
                   title="Admin Panel">
                    <i class="fas fa-user-shield text-lg"></i>
                </a>
                <a href="{{ url('/order') }}" 
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-green-400 to-emerald-500 text-white px-6 py-2.5 rounded-full font-medium shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200">
                    <i class="fas fa-shopping-cart"></i> Pesan
                </a>
                <a href="{{ url('/contact') }}" 
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-pink-500 to-rose-500 text-white px-6 py-2.5 rounded-full font-medium shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200">
                    <i class="fas fa-phone-alt"></i> Hubungi
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" 
                    class="md:hidden text-gray-700 hover:text-pink-500 focus:outline-none transition-colors duration-200">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-300" 
             x-transition:enter-start="opacity-0 -translate-y-2" 
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden mt-4 pb-4 space-y-1 bg-white rounded-2xl shadow-2xl p-4 border border-gray-100">
            <a href="{{ url('/') }}" class="block px-4 py-3 text-gray-700 rounded-xl hover:bg-pink-50 hover:text-pink-600 transition-colors duration-200">Beranda</a>
            <a href="{{ url('/packages') }}" class="block px-4 py-3 text-gray-700 rounded-xl hover:bg-pink-50 hover:text-pink-600 transition-colors duration-200">Paket Wedding</a>
            <a href="{{ url('/order') }}" class="block px-4 py-3 text-gray-700 rounded-xl hover:bg-pink-50 hover:text-pink-600 transition-colors duration-200">Pesan Sekarang</a>
            <a href="{{ url('/gallery') }}" class="block px-4 py-3 text-gray-700 rounded-xl hover:bg-pink-50 hover:text-pink-600 transition-colors duration-200">Galeri</a>
            <a href="{{ route('clothes.index') }}" class="block px-4 py-3 text-gray-700 rounded-xl hover:bg-pink-50 hover:text-pink-600 transition-colors duration-200">Koleksi Baju</a>
            <a href="{{ url('/about') }}" class="block px-4 py-3 text-gray-700 rounded-xl hover:bg-pink-50 hover:text-pink-600 transition-colors duration-200">Tentang Kami</a>
            <a href="{{ url('/contact') }}" class="block px-4 py-3 text-gray-700 rounded-xl hover:bg-pink-50 hover:text-pink-600 transition-colors duration-200">Kontak</a>
            <a href="{{ url('/tracking') }}" class="block px-4 py-3 text-gray-700 rounded-xl hover:bg-pink-50 hover:text-pink-600 transition-colors duration-200">Cek Pesanan</a>
            <a href="{{ url('/admin') }}" class="block px-4 py-3 text-gray-700 rounded-xl hover:bg-pink-50 hover:text-pink-600 transition-colors duration-200">
                <i class="fas fa-user-shield mr-2"></i>Admin Panel
            </a>
            <div class="pt-2 space-y-2">
                <a href="{{ url('/order') }}" class="block w-full text-center bg-gradient-to-r from-green-400 to-emerald-500 text-white px-6 py-3 rounded-full font-medium shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200">
                    <i class="fas fa-shopping-cart mr-2"></i>Pesan Sekarang
                </a>
                <a href="{{ url('/contact') }}" class="block w-full text-center bg-gradient-to-r from-pink-500 to-rose-500 text-white px-6 py-3 rounded-full font-medium shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200">
                    <i class="fas fa-phone-alt mr-2"></i>Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</nav>