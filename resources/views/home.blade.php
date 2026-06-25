@extends('layouts.app')

@section('title', 'Farisa Wedding Organizer - Solusi Pernikahan Impian Anda')

@section('content')
    <!-- ==================== HERO SECTION WITH SLIDER (NO DOTS) ==================== -->
    <section class="relative h-screen overflow-hidden">
        <!-- Slider Images -->
        <div class="absolute inset-0" id="hero-slider">
            <!-- Slide 1 -->
            <div class="hero-slide absolute inset-0 bg-cover bg-center transition-opacity duration-1000 opacity-100" 
                 style="background-image: url('https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');"></div>
            <!-- Slide 2 -->
            <div class="hero-slide absolute inset-0 bg-cover bg-center transition-opacity duration-1000 opacity-0" 
                 style="background-image: url('https://images.unsplash.com/photo-1511285560929-80b456fea0bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');"></div>
            <!-- Slide 3 -->
            <div class="hero-slide absolute inset-0 bg-cover bg-center transition-opacity duration-1000 opacity-0" 
                 style="background-image: url('https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');"></div>
        </div>

        <!-- Overlay Gradient -->
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-black/70"></div>

        <!-- Content -->
        <div class="relative container mx-auto px-4 h-full flex flex-col justify-center items-center text-center text-white z-10">
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold mb-4 animate-fade-in leading-tight">
                Wujudkan <span class="text-pink-400">Hari Bahagia</span> Anda
            </h1>
            <p class="text-lg md:text-xl lg:text-2xl mb-8 max-w-2xl animate-fade-in text-gray-200" style="animation-delay: 0.2s;">
                Farisa Wedding Organizer siap membantu Anda merencanakan pernikahan impian dengan pelayanan terbaik dan dekorasi yang memukau.
            </p>
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 animate-fade-in" style="animation-delay: 0.4s;">
                <a href="{{ url('/packages') }}" class="bg-pink-500 text-white px-8 py-3.5 rounded-full hover:bg-pink-600 transition duration-300 font-semibold transform hover:scale-105 shadow-lg shadow-pink-500/30">
                    Lihat Paket Wedding
                </a>
                <a href="{{ url('/contact') }}" class="bg-transparent border-2 border-white text-white px-8 py-3.5 rounded-full hover:bg-white hover:text-pink-500 transition duration-300 font-semibold transform hover:scale-105">
                    Konsultasi Gratis
                </a>
            </div>
        </div>
    </section>

    <!-- ==================== ABOUT SECTION ==================== -->
    <section class="relative py-20 lg:py-28 bg-gradient-to-b from-white via-rose-50/30 to-white overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 left-0 w-72 h-72 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjg4IiBoZWlnaHQ9IjI4OCIgdmlld0JveD0iMCAwIDI4OCAyODgiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMjAiIGN5PSIyMCIgcj0iNDAiIGZpbGw9IiNGRUI3QzYiIGZpbGwtb3BhY2l0eT0iMC4xIi8+PGNpcmNsZSBjeD0iMjY4IiBjeT0iNjAiIHI9IjYwIiBmaWxsPSIjRkRENEU1IiBmaWxsLW9wYWNpdHk9IjAuMDgiLz48L3N2Zz4=')] bg-no-repeat opacity-70"></div>
            <div class="absolute bottom-0 right-0 w-80 h-80 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIwIiBoZWlnaHQ9IjMyMCIgdmlld0JveD0iMCAwIDMyMCAzMjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMjgwIiBjeT0iMjYwIiByPSI3MCIgZmlsbD0iI0ZFQjdDNiIgZmlsbC1vcGFjaXR5PSIwLjA4Ii8+PGNpcmNsZSBjeD0iNDAiIGN5PSIyODAiIHI9IjUwIiBmaWxsPSIjRkRENEU1IiBmaWxsLW9wYWNpdHk9IjAuMSIvPjwvc3ZnPg==')] bg-no-repeat opacity-60"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full max-w-6xl opacity-[0.03]" style="background-image: radial-gradient(#ec4899 1.5px, transparent 1.5px); background-size: 30px 30px;"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <!-- Section Header -->
            <div class="text-center mb-16 lg:mb-20" data-aos="fade-up" data-aos-duration="800">
                <span class="inline-block text-sm font-semibold tracking-widest text-pink-500 uppercase mb-3 bg-pink-50 px-5 py-2 rounded-full border border-pink-200/60">
                    ✦ Sejak 2013 ✦
                </span>
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-800 mb-4 leading-tight">
                    Tentang <span class="relative inline-block">
                        <span class="bg-gradient-to-r from-pink-500 to-rose-500 bg-clip-text text-transparent">Farisa Wedding</span>
                        <svg class="absolute -bottom-2 left-0 w-full" height="8" viewBox="0 0 200 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 7C50 2 150 2 199 7" stroke="#EC4899" stroke-width="2.5" stroke-linecap="round" fill="none" opacity="0.5"/>
                        </svg>
                    </span>
                </h2>
                <div class="flex items-center justify-center gap-3 mt-2 mb-5">
                    <span class="w-12 h-[2px] bg-pink-300 rounded-full"></span>
                    <span class="w-2 h-2 bg-pink-500 rounded-full"></span>
                    <span class="w-12 h-[2px] bg-pink-300 rounded-full"></span>
                </div>
                <p class="text-gray-600 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed font-light">
                    Lebih dari sekadar wedding organizer kami adalah <span class="font-medium text-gray-700">sahabat perjalanan cinta</span> Anda, menghadirkan momen sakral yang dikenang selamanya.
                </p>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-10 lg:gap-16 items-center">
                <!-- Image Column -->
                <div class="lg:col-span-2 relative" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="200">
                    <div class="relative group">

                        <div class="absolute -bottom-3 -right-3 w-20 h-20 rounded-lg opacity-40" style="background-image: radial-gradient(#ec4899 2px, transparent 2px); background-size: 10px 10px;"></div>
                        <div class="relative rounded-lg overflow-hidden shadow-2xl shadow-pink-200/50">
                            <img src="{{ asset('images/Farisa Wedding Logo.svg') }}" alt="Farisa Wedding Decoration" class="w-full h-auto object-cover rounded-lg transition-transform duration-700 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-pink-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-lg"></div>
                        </div>
                        <!-- Floating Badge -->
                        <div class="absolute -bottom-5 -right-5 md:-bottom-6 md:-right-6 bg-white rounded-full shadow-xl shadow-pink-200/60 p-3 md:p-4 z-10 animate-float">
                            <div class="bg-gradient-to-br from-pink-500 to-rose-600 text-white rounded-full w-16 h-16 md:w-20 md:h-20 flex flex-col items-center justify-center">
                                <span class="text-xl md:text-2xl font-bold leading-none">10+</span>
                                <span class="text-[10px] md:text-xs leading-tight text-center">Tahun</span>
                            </div>
                        </div>
                        <div class="absolute -top-6 -right-6 text-pink-400 text-3xl md:text-4xl opacity-70 animate-spin-slow hidden md:block">✿</div>
                    </div>
                </div>

                <!-- Content Column -->
                <div class="lg:col-span-3 space-y-8" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="400">
                    <div>
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4 flex items-center gap-3">
                            <span class="w-1 h-8 bg-gradient-to-b from-pink-500 to-rose-500 rounded-full inline-block"></span>
                            Mengukir Cerita Indah Sejak 2013
                        </h3>
                        <p class="text-gray-600 leading-relaxed text-base md:text-lg">
                            Farisa Wedding Organizer hadir dengan <span class="font-semibold text-gray-700">dedikasi penuh</span> untuk mewujudkan pernikahan impian Anda. Kami memahami bahwa setiap pasangan memiliki kisah unik dan kami di sini untuk menerjemahkannya ke dalam setiap detail dekorasi, rangkaian acara, dan momen tak terlupakan.
                        </p>
                        <p class="text-gray-600 leading-relaxed text-base md:text-lg mt-3">
                            Dengan tim profesional yang <span class="font-semibold text-gray-700">berpengalaman lebih dari satu dekade</span>, kami telah membersamai ratusan pasangan melangkah ke gerbang pernikahan dengan penuh kehangatan, ketenangan, dan kebahagiaan.
                        </p>
                    </div>

                    <!-- Core Values -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="flex items-start gap-3 bg-white/80 backdrop-blur-sm p-4 rounded-xl shadow-md shadow-pink-100/50 border border-pink-100 hover:shadow-lg hover:shadow-pink-200/40 transition-all duration-300 group cursor-default">
                            <div class="flex-shrink-0 w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center group-hover:bg-pink-500 transition-colors duration-300">
                                <i class="fas fa-heart text-pink-500 group-hover:text-white transition-colors duration-300 text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 text-sm">Cinta & Ketulusan</h4>
                                <p class="text-gray-500 text-xs mt-1">Setiap momen kami rawat dengan sepenuh hati</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 bg-white/80 backdrop-blur-sm p-4 rounded-xl shadow-md shadow-pink-100/50 border border-pink-100 hover:shadow-lg hover:shadow-pink-200/40 transition-all duration-300 group cursor-default">
                            <div class="flex-shrink-0 w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center group-hover:bg-pink-500 transition-colors duration-300">
                                <i class="fas fa-star text-pink-500 group-hover:text-white transition-colors duration-300 text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 text-sm">Kualitas Premium</h4>
                                <p class="text-gray-500 text-xs mt-1">Standar tinggi di setiap detail acara</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 bg-white/80 backdrop-blur-sm p-4 rounded-xl shadow-md shadow-pink-100/50 border border-pink-100 hover:shadow-lg hover:shadow-pink-200/40 transition-all duration-300 group cursor-default">
                            <div class="flex-shrink-0 w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center group-hover:bg-pink-500 transition-colors duration-300">
                                <i class="fas fa-handshake text-pink-500 group-hover:text-white transition-colors duration-300 text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 text-sm">Terpercaya</h4>
                                <p class="text-gray-500 text-xs mt-1">Ratusan pasangan telah membuktikan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Compact 1000+ Statistic -->
                    <div class="flex justify-center">
                        <div class="bg-gradient-to-br from-pink-500 to-rose-600 text-white px-6 py-4 rounded-2xl shadow-lg shadow-pink-300/30 inline-flex items-center gap-3">
                            <span class="text-3xl font-extrabold counter" data-target="1000">0</span>
                            <span class="text-2xl font-bold opacity-70">+</span>
                            <div>
                                <p class="text-sm font-semibold leading-tight">Acara Sukses</p>
                                <p class="text-xs text-pink-100">Pernikahan & event terselenggara</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trust Badges -->
            <div class="mt-16 lg:mt-20 flex flex-wrap justify-center items-center gap-6 md:gap-10 opacity-60" data-aos="fade-up" data-aos-duration="800" data-aos-delay="600">
                <div class="flex flex-wrap justify-center items-center gap-6 md:gap-10">
                    <div class="flex items-center gap-2 text-gray-400"><i class="fas fa-shield-alt text-lg"></i><span class="text-xs font-semibold tracking-wide">BERSERTIFIKAT</span></div>
                    <div class="flex items-center gap-2 text-gray-400"><i class="fas fa-award text-lg"></i><span class="text-xs font-semibold tracking-wide">PENGHARGAAN 2023</span></div>
                    <div class="flex items-center gap-2 text-gray-400"><i class="fas fa-star text-lg"></i><span class="text-xs font-semibold tracking-wide">TOP RATED</span></div>
                    <div class="flex items-center gap-2 text-gray-400"><i class="fas fa-check-circle text-lg"></i><span class="text-xs font-semibold tracking-wide">GARANSI 100%</span></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== WHY CHOOSE US ==================== -->
    <section class="py-20 bg-gray-50 relative">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNGRUI3QzYiIGZpbGwtb3BhY2l0eT0iMC4xIj48Y2lyY2xlIGN4PSIxMCIgY3k9IjEwIiByPSIxLjUiLz48Y2lyY2xlIGN4PSIzMCIgY3k9IjEwIiByPSIxLjUiLz48Y2lyY2xlIGN4PSI1MCIgY3k9IjEwIiByPSIxLjUiLz48Y2lyY2xlIGN4PSIxMCIgY3k9IjMwIiByPSIxLjUiLz48Y2lyY2xlIGN4PSIzMCIgY3k9IjMwIiByPSIxLjUiLz48Y2lyY2xlIGN4PSI1MCIgY3k9IjMwIiByPSIxLjUiLz48Y2lyY2xlIGN4PSIxMCIgY3k9IjUwIiByPSIxLjUiLz48Y2lyY2xlIGN4PSIzMCIgY3k9IjUwIiByPSIxLjUiLz48Y2lyY2xlIGN4PSI1MCIgY3k9IjUwIiByPSIxLjUiLz48L2c+PC9nPjwvc3ZnPg==')] opacity-50"></div>
        <div class="container mx-auto px-4 relative">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-800 mb-2">Kenapa Memilih <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-rose-500">Kami?</span></h2>
                <div class="flex items-center justify-center gap-3 mt-3">
                    <span class="w-12 h-[2px] bg-pink-300 rounded-full"></span>
                    <span class="w-2 h-2 bg-pink-500 rounded-full"></span>
                    <span class="w-12 h-[2px] bg-pink-300 rounded-full"></span>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-2xl shadow-xl shadow-pink-100/40 hover:shadow-2xl hover:shadow-pink-200/50 transition-all duration-300 group text-center transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-20 h-20 bg-gradient-to-br from-pink-100 to-pink-50 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-inner">
                        <i class="fas fa-palette text-pink-500 text-3xl"></i>
                    </div>
                    <h3 class="font-bold text-xl mb-3 text-gray-800">Dekorasi Eksklusif</h3>
                    <p class="text-gray-600">Desain dekorasi yang elegan dan sesuai dengan tema pernikahan impian Anda, ditangani oleh tim kreatif berpengalaman.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-xl shadow-pink-100/40 hover:shadow-2xl hover:shadow-pink-200/50 transition-all duration-300 group text-center transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-20 h-20 bg-gradient-to-br from-pink-100 to-pink-50 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-inner">
                        <i class="fas fa-clock text-pink-500 text-3xl"></i>
                    </div>
                    <h3 class="font-bold text-xl mb-3 text-gray-800">Tepat Waktu</h3>
                    <p class="text-gray-600">Komitmen tinggi terhadap jadwal dan waktu pelaksanaan acara, memastikan setiap momen berjalan lancar tanpa hambatan.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-xl shadow-pink-100/40 hover:shadow-2xl hover:shadow-pink-200/50 transition-all duration-300 group text-center transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-20 h-20 bg-gradient-to-br from-pink-100 to-pink-50 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-inner">
                        <i class="fas fa-headset text-pink-500 text-3xl"></i>
                    </div>
                    <h3 class="font-bold text-xl mb-3 text-gray-800">Konsultasi 24/7</h3>
                    <p class="text-gray-600">Tim kami siap membantu Anda kapan saja selama proses persiapan, memberikan solusi dan ide terbaik untuk hari bahagia Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== CTA SECTION ==================== -->
    <section class="py-20 bg-gradient-to-r from-pink-500 to-rose-600 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 w-40 h-40 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-60 h-60 bg-white rounded-full blur-3xl"></div>
        </div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4" data-aos="fade-up">Wujudkan Pernikahan Impian Bersama Kami</h2>
            <p class="text-white text-lg md:text-xl mb-8 max-w-2xl mx-auto opacity-90" data-aos="fade-up" data-aos-delay="100">Konsultasikan konsep pernikahan Anda bersama tim profesional kami. 
            Kami siap membantu merancang setiap detail acara agar menjadi momen istimewa yang berkesan.</p>
            <a href="{{ url('/contact') }}" class="inline-flex items-center gap-2 bg-white text-pink-600 px-10 py-4 rounded-full hover:bg-gray-100 transition duration-300 font-bold shadow-2xl shadow-pink-900/30 transform hover:scale-105" data-aos="fade-up" data-aos-delay="200">
                <i class="fas fa-comments"></i>
                Hubungi Kami Sekarang
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </section>
@endsection

@push('styles')
<!-- AOS Library -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    /* Animations */
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 1s ease-out forwards;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin-slow {
        animation: spin-slow 20s linear infinite;
    }
    /* Hero slider transition */
    .hero-slide {
        transition: opacity 1s ease-in-out;
    }
</style>
@endpush

@push('scripts')
<!-- AOS Init -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ once: true, duration: 800 });
</script>

<!-- Hero Slider Script (Auto-play only, without dots) -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const slides = document.querySelectorAll('.hero-slide');
        let currentSlide = 0;
        const totalSlides = slides.length;
        let slideInterval;

        function showSlide(index) {
            slides.forEach(slide => {
                slide.classList.remove('opacity-100');
                slide.classList.add('opacity-0');
            });
            slides[index].classList.remove('opacity-0');
            slides[index].classList.add('opacity-100');
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            showSlide(currentSlide);
        }

        function startSlider() {
            slideInterval = setInterval(nextSlide, 2000);
        }

        function stopSlider() {
            clearInterval(slideInterval);
        }

        // Initialize
        showSlide(0);
        startSlider();

        // Pause on hover
        const heroSection = document.querySelector('#hero-slider').parentElement;
        heroSection.addEventListener('mouseenter', stopSlider);
        heroSection.addEventListener('mouseleave', startSlider);
    });
</script>

<!-- Counter Animation for 1000+ -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('.counter');
        const speed = 80;
        const animateCounter = (counter) => {
            const target = parseFloat(counter.getAttribute('data-target'));
            const count = parseFloat(counter.innerText);
            const increment = target / speed;
            if (count < target) {
                counter.innerText = Math.ceil(count + increment);
                setTimeout(() => animateCounter(counter), 20);
            } else {
                counter.innerText = target;
            }
        };
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        counters.forEach(counter => observer.observe(counter));
    });
</script>
@endpush