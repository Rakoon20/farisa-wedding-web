@extends('layouts.app')

@section('title', 'Kontak Kami - Farisa Wedding Organizer')

@section('content')
    <!-- Flash Messages (dipindahkan ke sini) -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 container mx-auto mt-6">
        
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('warning'))
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg mb-6 container mx-auto mt-6">
            <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('warning') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 container mx-auto mt-6">
            <i class="fas fa-times-circle mr-2"></i> {{ session('error') }}
        </div>
    @endif

    <!-- Hero Section -->
    <section class="relative bg-cover bg-center py-20" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=1600');">
        <div class="container mx-auto px-4 text-center text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Hubungi <span class="text-pink-400">Kami</span></h1>
            <div class="w-20 h-1 bg-pink-400 mx-auto mb-4"></div>
            <p class="text-lg max-w-2xl mx-auto">Siap membantu mewujudkan pernikahan impian Anda. Konsultasi gratis 24/7</p>
        </div>
    </section>

    <!-- Contact Info Cards -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 -mt-20 relative z-10">
                <!-- Card 1: Alamat -->
                <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-map-marker-alt text-pink-500 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-xl text-gray-800 mb-2">Alamat Kami</h3>
                    <p class="text-gray-600">Gg. R Jambu No.165, Gerem, Kec. Gerogol, Kota Cilegon, Banten 42438</p>
                    <a href="https://maps.app.goo.gl/mLypGumyL2jD4DVd6" target="_blank" class="text-pink-500 text-sm mt-3 inline-block hover:underline">
                        <i class="fas fa-external-link-alt mr-1"></i>Lihat di Maps
                    </a>
                </div>

                <!-- Card 2: Telepon -->
                <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-phone-alt text-pink-500 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-xl text-gray-800 mb-2">Telepon & WhatsApp</h3>
                    <p class="text-gray-600">087871181069</p>
                    <p class="text-gray-600">081212044982</p>
                    <a href="https://wa.me/087871181069" target="_blank" class="bg-green-500 text-white px-4 py-2 rounded-full text-sm mt-3 inline-block hover:bg-green-600 transition">
                        <i class="fab fa-whatsapp mr-1"></i>Chat WhatsApp
                    </a>
                </div>

                <!-- Card 3: Email -->
                <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope text-pink-500 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-xl text-gray-800 mb-2">Email</h3>
                    <p class="text-gray-600">adminfarisa@gmail.com</p>
                    <a href="https://mail.google.com/mail/?view=cm&fs=1&to=adminfarisa@gmail.com"
                    target="_blank"
                    class="text-pink-500 text-sm mt-3 inline-block hover:underline">
                        <i class="fas fa-paper-plane mr-1"></i>Kirim Email
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Google Maps Full Width -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d835954.293454471!2d104.852851846875!3d-5.975800599999992!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e41918f7b1a1aef%3A0xefb97a26de295c68!2sRias%20Pengantin%20FARISA!5e1!3m2!1sid!2sid!4v1781203461783!5m2!1sid!2sid"
                    height="500" 
                    width="100%" 
                    style="border:0; display:block;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>

    <!-- Jam Operasional Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Jam <span class="text-pink-500">Operasional</span></h2>
                <div class="w-20 h-1 bg-pink-500 mx-auto"></div>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Kami siap melayani Anda di jam-jam berikut</p>
            </div>
            <div class="max-w-2xl mx-auto bg-gray-50 rounded-lg p-8">
                <div class="space-y-4">
                    <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                        <div>
                            <i class="fas fa-calendar-day text-pink-500 mr-3"></i>
                            <span class="font-semibold text-gray-700">Senin - Jumat</span>
                        </div>
                        <span class="text-gray-600">09:00 - 18:00</span>
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                        <div>
                            <i class="fas fa-calendar-week text-pink-500 mr-3"></i>
                            <span class="font-semibold text-gray-700">Sabtu</span>
                        </div>
                        <span class="text-gray-600">10:00 - 16:00</span>
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                        <div>
                            <i class="fas fa-calendar-week text-pink-500 mr-3"></i>
                            <span class="font-semibold text-gray-700">Minggu</span>
                        </div>
                        <span class="text-gray-600">Libur (konsultasi online via WA)</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <i class="fas fa-headset text-pink-500 mr-3"></i>
                            <span class="font-semibold text-gray-700">Layanan Darurat</span>
                        </div>
                        <span class="text-gray-600">24 Jam (via telepon)</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Media Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Ikuti <span class="text-pink-500">Kami</span></h2>
            <div class="w-20 h-1 bg-pink-500 mx-auto mb-8"></div>
            <p class="text-gray-600 mb-8 max-w-2xl mx-auto">Dapatkan inspirasi pernikahan dan promo terbaru dari media sosial kami</p>
            <div class="flex justify-center space-x-6">
                <a href="https://www.instagram.com/farisa_weddingdecoration?igsh=eXFoM2NncjlyajE=" class="w-14 h-14 bg-pink-500 rounded-full flex items-center justify-center text-white text-2xl hover:bg-pink-600 transition duration-300 transform hover:scale-110">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://www.facebook.com/share/1972srVRtb/" class="w-14 h-14 bg-pink-500 rounded-full flex items-center justify-center text-white text-2xl hover:bg-pink-600 transition duration-300 transform hover:scale-110">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://www.tiktok.com/@fanesaecaa?_r=1&_t=ZS-97V19vqdJXZ" class="w-14 h-14 bg-pink-500 rounded-full flex items-center justify-center text-white text-2xl hover:bg-pink-600 transition duration-300 transform hover:scale-110">
                    <i class="fab fa-tiktok"></i>
                </a>

            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Pertanyaan <span class="text-pink-500">Umum</span></h2>
                <div class="w-20 h-1 bg-pink-500 mx-auto"></div>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Hal-hal yang sering ditanyakan oleh customer kami</p>
            </div>
            <div class="max-w-3xl mx-auto space-y-4" x-data="{ open: null }">
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button @click="open = open === 1 ? null : 1" class="w-full flex justify-between items-center p-5 text-left bg-gray-50 hover:bg-gray-100 transition">
                        <span class="font-semibold text-gray-800">Apakah bisa konsultasi sebelum booking?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform" :class="{ 'rotate-180': open === 1 }"></i>
                    </button>
                    <div x-show="open === 1" x-collapse class="p-5 text-gray-600 border-t border-gray-200">
                        Tentu saja! Kami menyediakan konsultasi GRATIS baik secara langsung di galeri kami maupun via WhatsApp/Video Call. Tim kami akan dengan senang hati membantu Anda merencanakan pernikahan impian.
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button @click="open = open === 2 ? null : 2" class="w-full flex justify-between items-center p-5 text-left bg-gray-50 hover:bg-gray-100 transition">
                        <span class="font-semibold text-gray-800">Berapa lama waktu maksimal booking H-7 acara?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform" :class="{ 'rotate-180': open === 2 }"></i>
                    </button>
                    <div x-show="open === 2" x-collapse class="p-5 text-gray-600 border-t border-gray-200">
                        Kami menyarankan booking minimal 3-6 bulan sebelum acara untuk persiapan yang matang. Namun untuk kondisi tertentu, kami masih bisa melayani booking H-30 dengan ketersediaan jadwal dan tim.
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button @click="open = open === 3 ? null : 3" class="w-full flex justify-between items-center p-5 text-left bg-gray-50 hover:bg-gray-100 transition">
                        <span class="font-semibold text-gray-800">Apakah bisa custom paket sesuai keinginan?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform" :class="{ 'rotate-180': open === 3 }"></i>
                    </button>
                    <div x-show="open === 3" x-collapse class="p-5 text-gray-600 border-t border-gray-200">
                        Bisa! Kami menyediakan layanan custom paket sesuai dengan kebutuhan dan budget Anda. Silakan konsultasikan keinginan Anda dengan tim kami.
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button @click="open = open === 4 ? null : 4" class="w-full flex justify-between items-center p-5 text-left bg-gray-50 hover:bg-gray-100 transition">
                        <span class="font-semibold text-gray-800">Apakah bisa lihat galeri dekorasi langsung?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform" :class="{ 'rotate-180': open === 4 }"></i>
                    </button>
                    <div x-show="open === 4" x-collapse class="p-5 text-gray-600 border-t border-gray-200">
                        Tentu! Kami memiliki galeri fisik yang bisa Anda kunjungi di alamat kami. Anda juga bisa melihat contoh dekorasi dan paket wedding secara langsung.
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection