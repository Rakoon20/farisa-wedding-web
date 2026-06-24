<footer class="bg-gray-900 text-white pt-12 pb-6">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div>
                <div class="flex items-center space-x-2 mb-4">
                    <span class="font-bold text-xl">Farisa <span class="text-pink-400">Wedding</span></span>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Wedding Organizer profesional yang siap mewujudkan hari bahagia Anda dengan pelayanan terbaik dan dekorasi memukau.
                </p>
                <div class="flex space-x-4 mt-4">
                    <a href="https://www.instagram.com/farisa_weddingdecoration?igsh=eXFoM2NncjlyajE=" class="text-gray-400 hover:text-pink-400 transition"><i class="fab fa-instagram text-xl"></i></a>
                    <a href="#" class="text-gray-400 hover:text-pink-400 transition"><i class="fab fa-facebook text-xl"></i></a>
                    <a href="#" class="text-gray-400 hover:text-pink-400 transition"><i class="fab fa-tiktok text-xl"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="font-semibold text-lg mb-4">Tautan Cepat</h4>
                <ul class="space-y-2">
                    <li><a href="{{ url('/') }}" class="text-gray-400 hover:text-pink-400 transition">Beranda</a></li>
                    <li><a href="{{ url('/packages') }}" class="text-gray-400 hover:text-pink-400 transition">Paket Wedding</a></li>
                    <li><a href="{{ url('/gallery') }}" class="text-gray-400 hover:text-pink-400 transition">Galeri</a></li>
                    <li><a href="{{ url('/about') }}" class="text-gray-400 hover:text-pink-400 transition">Tentang Kami</a></li>
                    <li><a href="{{ url('/contact') }}" class="text-gray-400 hover:text-pink-400 transition">Kontak</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div>
                <h4 class="font-semibold text-lg mb-4">Layanan Kami</h4>
                <ul class="space-y-2">
                    <li class="text-gray-400">Dekorasi Wedding</li>
                    <li class="text-gray-400">Rias Pengantin</li>
                    <li class="text-gray-400">Dokumentasi & Video</li>
                    <li class="text-gray-400">Katering & Prasmanan</li>
                    <li class="text-gray-400">Entertainment & MC</li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="font-semibold text-lg mb-4">Kontak Kami</h4>
                <ul class="space-y-3">
                    <li class="flex items-start space-x-3">
                        <i class="fas fa-map-marker-alt text-pink-400 mt-1"></i>
                        <span class="text-gray-400 text-sm">Gg. R Jambu No.165, Gerem, Kec. Gerogol, Kota Cilegon, Banten 42438</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i class="fas fa-phone-alt text-pink-400"></i>
                        <span class="text-gray-400">+62 812 3456 7890</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i class="fas fa-envelope text-pink-400"></i>
                        <span class="text-gray-400">adminfarisa@gmail.com</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i class="fas fa-clock text-pink-400"></i>
                        <span class="text-gray-400">Senin - Sabtu: 09:00 - 18:00</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-gray-800 mt-8 pt-6 text-center">
            <p class="text-gray-500 text-sm">
                &copy; {{ date('Y') }} Farisa Wedding Organizer. All rights reserved.
            </p>
        </div>
    </div>
</footer>