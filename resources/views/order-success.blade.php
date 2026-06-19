@extends('layouts.app')

@section('title', 'Pesanan Berhasil - Farisa Wedding Organizer')

@section('content')
<section class="py-20 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-8">
            <!-- Icon Sukses -->
            <div class="text-center mb-6">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check-circle text-green-500 text-4xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Pesanan Berhasil!</h1>
                <p class="text-gray-600">Nomor Pesanan: <strong class="text-pink-500">{{ $order->order_number }}</strong></p>
            </div>

            <!-- Detail Pesanan -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h3 class="font-bold mb-2">Detail Pesanan</h3>
                <div class="space-y-1 text-sm">
                    <div class="flex justify-between"><span>Nama:</span> <span>{{ $order->customer_name }}</span></div>
                    <div class="flex justify-between"><span>Tanggal Acara:</span> <span>{{ \Carbon\Carbon::parse($order->event_date)->format('d F Y') }}</span></div>
                    <div class="flex justify-between"><span>Paket:</span> <span>{{ $order->package->name ?? $order->package_code }}</span></div>
                    <div class="flex justify-between"><span>Total Harga:</span> <span class="font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span></div>
                </div>
            </div>

            <!-- Instruksi Pembayaran (QRIS & Transfer) -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h3 class="font-bold mb-2">Instruksi Pembayaran DP (Rp 1.000.000)</h3>
                <p class="text-sm mb-3">Silakan transfer ke rekening berikut atau scan QRIS:</p>
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 text-center">
                        <img src="{{ asset('images/qris.webp') }}" alt="QRIS" 
                             class="w-40 mx-auto border rounded cursor-pointer hover:opacity-90 transition"
                             onclick="openQrisModal()">
                        <p class="text-sm mt-1">Klik gambar untuk memperbesar</p>
                    </div>
                    <div class="flex-1">
                        <p><strong>Bank BCA</strong><br>123-456-7890<br>a.n Farisa Wedding Organizer</p>
                        <p class="mt-2"><strong>Bank Mandiri</strong><br>987-654-3210<br>a.n Farisa Wedding Organizer</p>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-3">*Upload bukti pembayaran melalui halaman <a href="{{ route('tracking') }}" class="text-pink-500">Cek Pesanan</a>.</p>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex flex-col md:flex-row gap-3 justify-center">
                <a href="{{ route('tracking') }}" class="bg-pink-500 text-white px-6 py-2 rounded-full text-center hover:bg-pink-600 transition">
                    <i class="fas fa-search mr-2"></i>Cek Status Pesanan
                </a>
                <a href="{{ url('/') }}" class="bg-gray-500 text-white px-6 py-2 rounded-full text-center hover:bg-gray-600 transition">
                    <i class="fas fa-home mr-2"></i>Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Modal Popup QRIS -->
<div id="qrisModal" class="fixed inset-0 bg-black bg-opacity-80 hidden items-center justify-center z-50" onclick="closeQrisModal()">
    <div class="relative max-w-md mx-auto p-4" onclick="event.stopPropagation()">
        <button onclick="closeQrisModal()" class="absolute -top-10 right-0 text-white text-3xl hover:text-pink-400">&times;</button>
        <img src="{{ asset('images/qris.webp') }}" alt="QRIS" class="w-full rounded-lg shadow-2xl">
        <p class="text-center text-white mt-3 text-sm">Scan QRIS di atas untuk pembayaran DP</p>
    </div>
</div>

@push('styles')
<style>
    #qrisModal {
        transition: all 0.3s ease;
    }
</style>
@endpush

@push('scripts')
<script>
    function openQrisModal() {
        document.getElementById('qrisModal').classList.remove('hidden');
        document.getElementById('qrisModal').classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    function closeQrisModal() {
        document.getElementById('qrisModal').classList.add('hidden');
        document.getElementById('qrisModal').classList.remove('flex');
        document.body.style.overflow = 'auto';
    }
    // Menutup modal dengan tombol ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('qrisModal');
            if (modal && !modal.classList.contains('hidden')) {
                closeQrisModal();
            }
        }
    });
</script>
@endpush
@endsection