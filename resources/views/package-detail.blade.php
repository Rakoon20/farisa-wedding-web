@extends('layouts.app')

@section('title', $package->name . ' - Farisa Wedding Organizer')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-cover bg-center py-20" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=1600');">
        <div class="container mx-auto px-4 text-center text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ $package->name }}</h1>
            <div class="w-20 h-1 bg-pink-400 mx-auto mb-4"></div>
            <p class="text-lg max-w-2xl mx-auto">Detail lengkap paket wedding Farisa Wedding Organizer</p>
        </div>
    </section>

    <!-- Package Detail Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <!-- Image -->
                    @if($package->image)
                        <img src="{{ Storage::url($package->image) }}" alt="{{ $package->name }}" class="w-full h-80 object-cover">
                    @else
                        <div class="w-full h-80 bg-linear-to-br from-pink-200 to-pink-300 flex items-center justify-center">
                            <i class="fas fa-image text-pink-400 text-6xl"></i>
                        </div>
                    @endif

                    <!-- Content -->
                    <div class="p-8">
                        <!-- Price -->
                        <div class="mb-6 pb-6 border-b border-gray-200">
                            <span class="text-gray-500 text-lg">Harga Paket:</span>
                            <span class="text-pink-500 font-bold text-4xl ml-3">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <h3 class="font-semibold text-xl text-gray-800 mb-3">Deskripsi Paket</h3>
                            <p class="text-gray-600 leading-relaxed">{{ $package->description ?? 'Deskripsi paket belum tersedia. Silakan hubungi kami untuk informasi lebih lanjut.' }}</p>
                        </div>

                        <!-- Items in Package -->
                        @if($packageItems->count() > 0)
                            <div class="mb-6">
                                <h3 class="font-semibold text-xl text-gray-800 mb-3">Item yang Termasuk</h3>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <!-- Header Table -->
                                    <div class="grid grid-cols-12 gap-4 pb-3 mb-2 border-b-2 border-gray-300 font-semibold text-gray-700">
                                        <div class="col-span-6">Item</div>
                                        <div class="col-span-2 text-center">Qty</div>
                                        <div class="col-span-2 text-right">Harga/Item</div>
                                        <div class="col-span-2 text-right">Subtotal</div>
                                    </div>
                                    
                                    <!-- Items List -->
                                    <div class="space-y-2">
                                        @foreach($packageItems as $item)
                                            <div class="grid grid-cols-12 gap-4 py-2 border-b border-gray-200 last:border-0 items-center">
                                                <div class="col-span-6">
                                                    <div class="flex items-center">
                                                        <i class="fas fa-check-circle text-pink-500 mr-2 text-sm"></i>
                                                        <span class="font-medium text-gray-800">{{ $item->name }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-span-2 text-center">
                                                    <span class="bg-pink-100 text-pink-700 px-2 py-1 rounded-full text-sm font-semibold">x{{ $item->pivot->quantity }}</span>
                                                </div>
                                                <div class="col-span-2 text-right text-gray-600">
                                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                                </div>
                                                <div class="col-span-2 text-right font-semibold text-pink-600">
                                                    Rp {{ number_format($item->price * $item->pivot->quantity, 0, ',', '.') }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <!-- Total -->
                                    <div class="grid grid-cols-12 gap-4 pt-3 mt-2 border-t-2 border-gray-300">
                                        <div class="col-span-8"></div>
                                        <div class="col-span-2 text-right font-bold text-gray-800">Total:</div>
                                        <div class="col-span-2 text-right font-bold text-pink-500 text-xl">
                                            Rp {{ number_format($package->price, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Buttons -->
                        <div class="flex flex-col md:flex-row gap-4 justify-between items-center pt-6 border-t border-gray-200">
                            <a href="{{ route('packages.index') }}" class="text-gray-500 hover:text-pink-500 transition">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Paket
                            </a>
                            <div class="flex gap-3">
                                <a href="https://wa.me/{{ env('FONNTE_PHONE', '6281234567890') }}?text=Halo%20Farisa%20WO%2C%20saya%20tertarik%20dengan%20paket%20{{ urlencode($package->name) }}%20dan%20ingin%20konsultasi" 
                                   target="_blank"
                                   class="bg-green-500 text-white px-6 py-2 rounded-full hover:bg-green-600 transition duration-300">
                                    <i class="fab fa-whatsapp mr-2"></i>Konsultasi WA
                                </a>
                                <a href="{{ route('order.index', ['package' => $package->code]) }}" 
                                   class="bg-pink-500 text-white px-6 py-2 rounded-full hover:bg-pink-600 transition duration-300">
                                    <i class="fas fa-shopping-cart mr-2"></i>Pesan Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-pink-500">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Siap Menikah?</h2>
            <p class="text-white text-lg mb-8 max-w-2xl mx-auto">Segera pesan paket wedding Anda dan dapatkan promo menarik!</p>
            <a href="{{ url('/contact') }}" class="bg-white text-pink-500 px-8 py-3 rounded-full hover:bg-gray-100 transition duration-300 font-semibold">
                <i class="fas fa-phone-alt mr-2"></i>Hubungi Kami
            </a>
        </div>
    </section>
@endsection