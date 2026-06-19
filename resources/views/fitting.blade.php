@extends('layouts.app')

@section('title', 'Jadwal Fitting - Farisa Wedding Organizer')

@section('content')
<section class="py-16 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-3xl font-bold text-center mb-8">Jadwal Fitting</h1>

            <!-- Informasi Pesanan -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="font-bold text-xl mb-3">Pesanan: {{ $order->order_number }}</h2>
                <div class="space-y-1 text-sm">
                    <div><strong>Nama:</strong> {{ $order->customer_name }}</div>
                    <div><strong>Paket:</strong> {{ $order->package->name ?? $order->package_code }}</div>
                    <div><strong>Total Harga:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                    <div><strong>Total Dibayar:</strong> Rp {{ number_format($order->total_paid, 0, ',', '.') }}</div>
                    <div><strong>Sisa:</strong> Rp {{ number_format($order->remaining_payment, 0, ',', '.') }}</div>
                </div>

                @if(!$order->canScheduleFitting())
                    <div class="mt-4 p-3 bg-yellow-100 text-yellow-800 rounded">
                        ⚠️ Syarat fitting: minimal pembayaran 50% dari total paket. Saat ini pembayaran Anda belum mencapai 50%.
                    </div>
                @endif
            </div>

            <!-- Form Fitting -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="font-bold text-xl mb-4">Form Fitting</h2>

                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">{{ session('error') }}</div>
                @endif

                @if($fitting && $fitting->status != 'cancelled')
                    <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded">
                        <p><strong>Status Fitting:</strong> 
                            @if($fitting->status == 'pending') Menunggu konfirmasi admin
                            @elseif($fitting->status == 'scheduled') Dijadwalkan pada {{ \Carbon\Carbon::parse($fitting->fitting_date)->format('d F Y') }}
                            @elseif($fitting->status == 'completed') Telah selesai
                            @endif
                        </p>
                        @if($fitting->fitting_date)
                            <p><strong>Tanggal Fitting:</strong> {{ \Carbon\Carbon::parse($fitting->fitting_date)->format('d F Y') }}</p>
                        @endif
                    </div>
                @endif

                <form action="{{ route('fitting.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="order_number" value="{{ $order->order_number }}">

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Tanggal Fitting yang diinginkan <span class="text-red-500">*</span></label>
                        <input type="date" name="fitting_date" class="w-full border rounded px-3 py-2" value="{{ old('fitting_date', $fitting->fitting_date ?? '') }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Jumlah kebutuhan pakaian</label>
                        <input type="number" name="total_clothes" class="w-full border rounded px-3 py-2" value="{{ old('total_clothes', $fitting->total_clothes ?? '') }}" placeholder="Contoh: 3">
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Ukuran baju</label>
                        <input type="text" name="size" class="w-full border rounded px-3 py-2" value="{{ old('size', $fitting->size ?? '') }}" placeholder="Contoh: M, L, XL, atau 41, 42">
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Pilihan warna</label>
                        <input type="text" name="color" class="w-full border rounded px-3 py-2" value="{{ old('color', $fitting->color ?? '') }}" placeholder="Contoh: Putih, Krim, Biru">
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Catatan lain</label>
                        <textarea name="notes" rows="3" class="w-full border rounded px-3 py-2" placeholder="Misalnya: ingin baju longgar, atau bahan tertentu">{{ old('notes', $fitting->notes ?? '') }}</textarea>
                    </div>

                    @if(!$fitting || $fitting->status == 'cancelled')
                        <button type="submit" class="bg-pink-500 text-white px-6 py-2 rounded-full" {{ !$order->canScheduleFitting() ? 'disabled' : '' }}>
                            Kirim Permintaan Fitting
                        </button>
                    @else
                        <p class="text-gray-500">Permintaan fitting sudah dikirim. Silakan tunggu konfirmasi admin.</p>
                    @endif
                </form>
            </div>
        </div>
    </div>
</section>
@endsection