@extends('layouts.app')

@section('title', 'Tentang Kami - Farisa Wedding Organizer')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-cover bg-center py-24" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1519741497674-611481863552?w=1600');">
        <div class="container mx-auto px-4 text-center text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Tentang <span class="text-pink-400">Kami</span></h1>
            <div class="w-20 h-1 bg-pink-400 mx-auto mb-4"></div>
            <p class="text-lg max-w-2xl mx-auto">Mewujudkan pernikahan impian Anda dengan pelayanan terbaik dan sentuhan profesional</p>
        </div>
    </section>

    <!-- Visi & Misi -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Visi & <span class="text-pink-500">Misi</span></h2>
                <div class="w-20 h-1 bg-pink-500 mx-auto"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Visi -->
                <div class="bg-gray-50 rounded-lg p-8 shadow-md text-center">
                    <div class="w-20 h-20 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-eye text-pink-500 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Visi</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Menjadi Wedding Organizer terdepan di Indonesia yang dikenal dengan kreativitas, profesionalisme, dan pelayanan yang tulus dalam mewujudkan pernikahan impian setiap pasangan.
                    </p>
                </div>

                <!-- Misi -->
                <div class="bg-gray-50 rounded-lg p-8 shadow-md text-center">
                    <div class="w-20 h-20 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bullseye text-pink-500 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Misi</h3>
                    <ul class="text-left text-gray-600 space-y-2">
                        <li><i class="fas fa-check-circle text-pink-500 mr-2"></i> Memberikan pelayanan terbaik dengan standar kualitas tinggi</li>
                        <li><i class="fas fa-check-circle text-pink-500 mr-2"></i> Menciptakan dekorasi yang unik dan sesuai kepribadian pasangan</li>
                        <li><i class="fas fa-check-circle text-pink-500 mr-2"></i> Menjaga kepercayaan dengan transparansi dan komunikasi yang baik</li>
                        <li><i class="fas fa-check-circle text-pink-500 mr-2"></i> Terus berinovasi mengikuti tren pernikahan terkini</li>
                        <li><i class="fas fa-check-circle text-pink-500 mr-2"></i> Membangun tim yang solid dan profesional</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Story Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Perjalanan <span class="text-pink-500">Kami</span></h2>
                <div class="w-20 h-1 bg-pink-500 mx-auto"></div>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Sejak awal berdiri hingga menjadi Wedding Organizer terpercaya</p>
            </div>
            <div class="relative">
                <!-- Timeline Line -->
                <div class="hidden md:block absolute left-1/2 transform -translate-x-1/2 w-1 bg-pink-300 h-full"></div>
                
                <!-- Timeline Item 1 -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-12">
                    <div class="md:w-5/12 text-center md:text-right order-2 md:order-1">
                        <h3 class="text-xl font-bold text-gray-800">2014 - Awal Berdiri</h3>
                        <p class="text-gray-600 mt-2">Farisa Wedding Organizer berdiri dengan visi membantu pasangan mewujudkan pernikahan impian dengan konsep sederhana namun elegan.</p>
                    </div>
                    <div class="relative z-10 order-1 md:order-2">
                        <div class="w-12 h-12 bg-pink-500 rounded-full flex items-center justify-center text-white font-bold">1</div>
                    </div>
                    <div class="md:w-5/12 order-3"></div>
                </div>

                <!-- Timeline Item 2 -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-12">
                    <div class="md:w-5/12 order-3"></div>
                    <div class="relative z-10 order-2">
                        <div class="w-12 h-12 bg-pink-500 rounded-full flex items-center justify-center text-white font-bold">2</div>
                    </div>
                    <div class="md:w-5/12 text-center md:text-left order-1 md:order-3">
                        <h3 class="text-xl font-bold text-gray-800">2017 - Mulai Dipercaya</h3>
                        <p class="text-gray-600 mt-2">Mulai dipercaya oleh 100+ pasangan dan memperluas tim profesional di berbagai bidang.</p>
                    </div>
                </div>

                <!-- Timeline Item 3 -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-12">
                    <div class="md:w-5/12 text-center md:text-right order-2 md:order-1">
                        <h3 class="text-xl font-bold text-gray-800">2020 - Inovasi Digital</h3>
                        <p class="text-gray-600 mt-2">Beradaptasi dengan era digital, menyediakan konsultasi online dan galeri virtual untuk memudahkan pasangan.</p>
                    </div>
                    <div class="relative z-10 order-1 md:order-2">
                        <div class="w-12 h-12 bg-pink-500 rounded-full flex items-center justify-center text-white font-bold">3</div>
                    </div>
                    <div class="md:w-5/12 order-3"></div>
                </div>

                <!-- Timeline Item 4 -->
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="md:w-5/12 order-3"></div>
                    <div class="relative z-10 order-2">
                        <div class="w-12 h-12 bg-pink-500 rounded-full flex items-center justify-center text-white font-bold">4</div>
                    </div>
                    <div class="md:w-5/12 text-center md:text-left order-1 md:order-3">
                        <h3 class="text-xl font-bold text-gray-800">2024 - Kini & Masa Depan</h3>
                        <p class="text-gray-600 mt-2">Melayani 500+ pasangan bahagia dan terus berkomitmen memberikan pengalaman pernikahan terbaik.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    {{-- <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Tim <span class="text-pink-500">Profesional</span></h2>
                <div class="w-20 h-1 bg-pink-500 mx-auto"></div>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Didukung oleh tim yang berpengalaman dan berdedikasi untuk acara spesial Anda</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Team 1 -->
                <div class="text-center group">
                    <div class="relative overflow-hidden rounded-full w-48 h-48 mx-auto mb-4 shadow-lg">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Founder" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                    </div>
                    <h3 class="font-semibold text-xl">Farisa Rahma</h3>
                    <p class="text-pink-500">Founder & Lead Planner</p>
                    <p class="text-gray-500 text-sm mt-2">Pengalaman 10+ tahun di industri wedding</p>
                </div>

                <!-- Team 2 -->
                <div class="text-center group">
                    <div class="relative overflow-hidden rounded-full w-48 h-48 mx-auto mb-4 shadow-lg">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Dekorator" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                    </div>
                    <h3 class="font-semibold text-xl">Ahmad Hidayat</h3>
                    <p class="text-pink-500">Head Dekorator</p>
                    <p class="text-gray-500 text-sm mt-2">Spesialis dekorasi indoor & outdoor</p>
                </div>

                <!-- Team 3 -->
                <div class="text-center group">
                    <div class="relative overflow-hidden rounded-full w-48 h-48 mx-auto mb-4 shadow-lg">
                        <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Koordinasi" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                    </div>
                    <h3 class="font-semibold text-xl">Siti Nurbaya</h3>
                    <p class="text-pink-500">Koordinator Vendor</p>
                    <p class="text-gray-500 text-sm mt-2">Jaringan vendor terpercaya</p>
                </div>

                <!-- Team 4 -->
                <div class="text-center group">
                    <div class="relative overflow-hidden rounded-full w-48 h-48 mx-auto mb-4 shadow-lg">
                        <img src="https://randomuser.me/api/portraits/men/86.jpg" alt="Dokumentasi" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                    </div>
                    <h3 class="font-semibold text-xl">Budi Santoso</h3>
                    <p class="text-pink-500">Tim Dokumentasi</p>
                    <p class="text-gray-500 text-sm mt-2">Videografer & fotografer profesional</p>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Achievement Section -->
    {{-- <section class="py-16 bg-pink-500">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center text-white">
                <div>
                    <i class="fas fa-calendar-check text-4xl mb-3"></i>
                    <h3 class="text-3xl md:text-4xl font-bold">500+</h3>
                    <p class="text-sm">Acara Sukses</p>
                </div>
                <div>
                    <i class="fas fa-smile text-4xl mb-3"></i>
                    <h3 class="text-3xl md:text-4xl font-bold">500+</h3>
                    <p class="text-sm">Pasangan Bahagia</p>
                </div>
                <div>
                    <i class="fas fa-star text-4xl mb-3"></i>
                    <h3 class="text-3xl md:text-4xl font-bold">4.9</h3>
                    <p class="text-sm">Rating Kepuasan</p>
                </div>
                <div>
                    <i class="fas fa-users text-4xl mb-3"></i>
                    <h3 class="text-3xl md:text-4xl font-bold">20+</h3>
                    <p class="text-sm">Tim Profesional</p>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Testimonials -->
    {{-- <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Apa Kata <span class="text-pink-500">Mereka?</span></h2>
                <div class="w-20 h-1 bg-pink-500 mx-auto"></div>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Testimoni dari pasangan yang sudah menggunakan layanan kami</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white rounded-lg p-6 shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-600 italic mb-4">"Farisa WO sangat profesional! Semua persiapan pernikahan kami berjalan lancar. Dekorasinya cantik banget, sesuai dengan yang kami mau. Terima kasih tim Farisa!"</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-pink-200 flex items-center justify-center mr-3">
                            <i class="fas fa-user text-pink-500"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold">Andini & Rizky</h4>
                            <p class="text-gray-500 text-sm">Pernikahan, Januari 2024</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white rounded-lg p-6 shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-600 italic mb-4">"Pelayanan sangat ramah dan komunikatif. Koordinasi dengan vendor sangat baik, semua berjalan tepat waktu. Harga juga worth it dengan kualitasnya!"</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-pink-200 flex items-center justify-center mr-3">
                            <i class="fas fa-user text-pink-500"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold">Sarah & Dimas</h4>
                            <p class="text-gray-500 text-sm">Pernikahan, Maret 2024</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white rounded-lg p-6 shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-600 italic mb-4">"Makasih Farisa WO sudah membantu pernikahan kami jadi indah dan berkesan. Semua tamu terkesima dengan dekorasinya. Rekomended banget!"</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-pink-200 flex items-center justify-center mr-3">
                            <i class="fas fa-user text-pink-500"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold">Mega & Andri</h4>
                            <p class="text-gray-500 text-sm">Pernikahan, Mei 2024</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

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