@extends('layouts.app')

@section('title', 'Pesan Paket Wedding - Farisa Wedding Organizer')

@section('content')
<!-- Hero Section -->
<section class="relative bg-cover bg-center py-20" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=1600');">
    <div class="container mx-auto px-4 text-center text-white">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Pesan <span class="text-pink-400">Paket Wedding</span></h1>
        <div class="w-20 h-1 bg-pink-400 mx-auto mb-4"></div>
        <p class="text-lg max-w-2xl mx-auto">Isi form di bawah ini untuk memesan paket wedding impian Anda</p>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="orderForm" action="{{ route('order.submit') }}" method="POST" class="bg-white rounded-xl shadow-lg p-8">
                @csrf

                <!-- Pilih Paket -->
                <div class="mb-6">
                    <label for="package_code" class="block text-gray-700 font-semibold mb-2">Pilih Paket Wedding <span class="text-red-500">*</span></label>
                    <select name="package_code" id="package_code" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" required>
                        <option value="">-- Pilih Paket --</option>
                        @foreach($packages as $pkg)
                            <option value="{{ $pkg->code }}" {{ (request()->get('package') == $pkg->code || old('package_code') == $pkg->code) ? 'selected' : '' }}>
                                {{ $pkg->name }} - Rp {{ number_format($pkg->price, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Detail Paket -->
                <div id="packageDetail" class="hidden mb-6 bg-gray-50 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-800 mb-2">Detail Paket:</h3>
                    <div id="packageItemsList"></div>
                    <div class="mt-2 pt-2 border-t border-gray-300">
                        <span class="font-bold">Harga Paket:</span>
                        <span id="packagePrice" class="text-pink-500 font-bold ml-2">Rp 0</span>
                    </div>
                </div>

                <!-- Adjustment Items -->
                <div id="adjustmentSection" class="hidden mb-6">
                    <h3 class="font-semibold text-gray-800 mb-3">Tambah/Kurang Item (Opsional)</h3>
                    <div id="adjustmentItems" class="space-y-3"></div>
                    <button type="button" id="addAdjustmentBtn" class="text-pink-500 text-sm hover:underline mt-2">
                        <i class="fas fa-plus mr-1"></i>Tambah Adjustment
                    </button>
                </div>

                <!-- Total Harga (tanpa biaya tambahan di frontend) -->
                <div id="totalSection" class="hidden mb-6 p-4 bg-pink-50 rounded-lg">
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-gray-800 text-lg">Total Harga:</span>
                        <span id="totalPrice" class="font-bold text-pink-500 text-2xl">Rp 0</span>
                    </div>
                    <div class="text-sm text-gray-500 mt-1">
                        *DP yang harus dibayarkan: Rp 1.000.000 (non-refundable)
                    </div>
                </div>

                <!-- Data Customer -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="customer_name" class="block text-gray-700 font-semibold mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" 
                               placeholder="Contoh: Andini Putri" required>
                    </div>
                    <div>
                        <label for="customer_phone" class="block text-gray-700 font-semibold mb-2">Nomor Telepon/WA <span class="text-red-500">*</span></label>
                        <input type="tel" name="customer_phone" id="customer_phone" value="{{ old('customer_phone') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" 
                               placeholder="Contoh: 081234567890" required>
                    </div>
                </div>

                <!-- Tanggal & Venue -->
                <div class="mt-4">
                    <label for="event_date" class="block text-gray-700 font-semibold mb-2">Tanggal Acara <span class="text-red-500">*</span></label>
                    <input type="date" name="event_date" id="event_date" value="{{ old('event_date') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" required>
                    <div id="dateAvailability" class="text-sm mt-1"></div>
                </div>

                <div class="mt-4">
                    <label for="venue_type" class="block text-gray-700 font-semibold mb-2">Jenis Venue <span class="text-red-500">*</span></label>
                    <select name="venue_type" id="venue_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" required>
                        <option value="">-- Pilih Venue --</option>
                        <option value="gedung" {{ old('venue_type') == 'gedung' ? 'selected' : '' }}>Gedung</option>
                        <option value="tenda" {{ old('venue_type') == 'tenda' ? 'selected' : '' }}>Tenda</option>
                    </select>
                </div>

                <div class="mt-4">
                    <label for="customer_address" class="block text-gray-700 font-semibold mb-2">Alamat Acara</label>
                    <textarea name="customer_address" id="customer_address" rows="2" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" 
                              placeholder="Contoh: Jl. Raya Bahagia No. 123, Kec. Bahagia, Kota Bahagia">{{ old('customer_address') }}</textarea>
                </div>

                <!-- Kota / Wilayah -->
                <div class="mt-4">
                    <label for="city" class="block text-gray-700 font-semibold mb-2">Kota/Wilayah <span class="text-red-500">*</span></label>
                    <select name="city" id="city" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" required>
                        <option value="">-- Pilih Kota --</option>
                        <option value="cilegon" {{ old('city') == 'cilegon' ? 'selected' : '' }}>Cilegon</option>
                        <option value="merak" {{ old('city') == 'merak' ? 'selected' : '' }}>Merak</option>
                        <option value="luar" {{ old('city') == 'luar' ? 'selected' : '' }}>Luar Kota (Cilegon/Merak)</option>
                    </select>
                </div>

                <!-- Catatan -->
                <div class="mt-4">
                    <label for="notes" class="block text-gray-700 font-semibold mb-2">Catatan / Permintaan Khusus</label>
                    <textarea name="notes" id="notes" rows="3" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" 
                              placeholder="Contoh: Dekorasi warna putih, tambahan kursi 50, menu catering khusus, dll">{{ old('notes') }}</textarea>
                </div>

                <div class="mt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                    <a href="{{ route('packages.index') }}" class="text-gray-500 hover:text-pink-500 transition">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Paket
                    </a>
                    <button type="submit" class="bg-pink-500 text-white px-8 py-3 rounded-full hover:bg-pink-600 transition duration-300 font-semibold">
                        <i class="fas fa-paper-plane mr-2"></i>Kirim Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    const allItems = @json($items ?? []);
    const packagesData = @json($packages);
    const packageItemsApiUrl = "{{ url('/api/package-items') }}";
    const checkDateRoute = "{{ route('order.check-date') }}";

    let currentPackage = null;
    let adjustmentCount = 0;
    let packageDefaultItems = [];

    function showToast(message, type = 'error') {
        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.style.position = 'fixed';
            container.style.bottom = '20px';
            container.style.right = '20px';
            container.style.zIndex = '9999';
            document.body.appendChild(container);
        }
        const toast = document.createElement('div');
        toast.className = 'bg-gray-800 text-white px-4 py-2 rounded-lg shadow-lg mb-2 flex items-center gap-2 transition-all duration-300 transform translate-x-full opacity-0';
        toast.style.minWidth = '250px';
        const icon = type === 'error' ? '❌' : (type === 'success' ? '✅' : 'ℹ️');
        toast.innerHTML = `<span>${icon}</span><span>${message}</span>`;
        container.appendChild(toast);
        setTimeout(() => {
            toast.classList.remove('translate-x-full', 'opacity-0');
            toast.classList.add('translate-x-0', 'opacity-100');
        }, 10);
        setTimeout(() => {
            toast.classList.remove('translate-x-0', 'opacity-100');
            toast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    function formatNumber(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    }

    function calculateTotal() {
        if (!currentPackage) return;
        let total = parseFloat(currentPackage.price);
        if (isNaN(total)) total = 0;

        document.querySelectorAll('.adjustment-item').forEach(item => {
            const select = item.querySelector('.adjustment-item-select');
            const qtyInput = item.querySelector('.adjustment-item-qty');
            if (select && select.value && qtyInput && qtyInput.value) {
                const qty = parseInt(qtyInput.value, 10);
                if (!isNaN(qty) && qty !== 0) {
                    const selectedItem = allItems.find(i => i.code === select.value);
                    if (selectedItem) {
                        const price = parseFloat(selectedItem.price);
                        if (!isNaN(price)) {
                            total += price * qty;
                        }
                    }
                }
            }
        });

        document.getElementById('totalPrice').innerText = 'Rp ' + formatNumber(total);
    }

    function addAdjustmentRow() {
        const container = document.getElementById('adjustmentItems');
        const index = adjustmentCount++;
        const div = document.createElement('div');
        div.className = 'adjustment-item flex gap-3 items-center mb-2';
        div.innerHTML = `
            <select name="adjustments[${index}][item_code]" class="flex-1 px-3 py-2 border rounded-lg adjustment-item-select">
                <option value="">Pilih Item</option>
                ${allItems.map(item => `<option value="${item.code}">${item.name} (Rp ${formatNumber(item.price)})</option>`).join('')}
            </select>
            <input type="number" name="adjustments[${index}][quantity]" placeholder="Qty (+/-)" class="w-24 px-3 py-2 border rounded-lg adjustment-item-qty" value="1" step="1">
            <button type="button" class="remove-adjustment text-red-500 hover:text-red-700" onclick="this.parentElement.remove(); calculateTotal();">
                <i class="fas fa-trash"></i>
            </button>
        `;

        const select = div.querySelector('.adjustment-item-select');
        const qty = div.querySelector('.adjustment-item-qty');

        const update = () => {
            const itemCode = select.value;
            if (!itemCode) {
                qty.value = '';
                calculateTotal();
                return;
            }
            let newQty = parseInt(qty.value, 10) || 0;
            const defaultItem = packageDefaultItems.find(i => i.code === itemCode);
            if (defaultItem) {
                const defaultQty = defaultItem.defaultQty;
                let otherAdjustment = 0;
                document.querySelectorAll('.adjustment-item').forEach(adj => {
                    if (adj === div) return;
                    const sel = adj.querySelector('.adjustment-item-select');
                    const q = adj.querySelector('.adjustment-item-qty');
                    if (sel && sel.value === itemCode && q && q.value) {
                        otherAdjustment += parseInt(q.value, 10) || 0;
                    }
                });
                const totalQty = defaultQty + otherAdjustment + newQty;
                if (totalQty < 0) {
                    showToast(`Tidak bisa mengurangi ${defaultItem.name} melebihi jumlah yang tersedia di paket.`, 'error');
                    qty.value = 0;
                    calculateTotal();
                    return;
                }
            }
            calculateTotal();
        };

        select.addEventListener('change', update);
        qty.addEventListener('input', update);
        container.appendChild(div);
        calculateTotal();
    }

    function loadPackageDetail(package) {
        fetch(`${packageItemsApiUrl}/${package.code}`)
            .then(res => res.json())
            .then(data => {
                const container = document.getElementById('packageItemsList');
                if (data.items && data.items.length > 0) {
                    packageDefaultItems = data.items.map(item => ({
                        code: item.code,
                        name: item.name,
                        defaultQty: item.pivot.quantity,
                        price: item.price
                    }));
                    container.innerHTML = '<div class="space-y-1">' + data.items.map(item => 
                        `<div class="flex justify-between text-sm">
                            <span>• ${item.name} x${item.pivot.quantity}</span>
                            <span>Rp ${formatNumber(item.price * item.pivot.quantity)}</span>
                        </div>`
                    ).join('') + '</div>';
                } else {
                    container.innerHTML = '<p class="text-gray-500 text-sm">Tidak ada item dalam paket ini</p>';
                    packageDefaultItems = [];
                }
                document.getElementById('packagePrice').innerText = 'Rp ' + formatNumber(package.price);
                document.getElementById('adjustmentItems').innerHTML = '';
                adjustmentCount = 0;
                calculateTotal();
            })
            .catch(err => {
                console.error('Error loading package details:', err);
                showToast('Gagal memuat detail paket', 'error');
            });
    }

    document.getElementById('addAdjustmentBtn').addEventListener('click', addAdjustmentRow);

    document.getElementById('package_code').addEventListener('change', function() {
        const packageCode = this.value;
        if (packageCode) {
            currentPackage = packagesData.find(p => p.code === packageCode);
            if (currentPackage) {
                loadPackageDetail(currentPackage);
                document.getElementById('packageDetail').classList.remove('hidden');
                document.getElementById('adjustmentSection').classList.remove('hidden');
                document.getElementById('totalSection').classList.remove('hidden');
            }
        } else {
            document.getElementById('packageDetail').classList.add('hidden');
            document.getElementById('adjustmentSection').classList.add('hidden');
            document.getElementById('totalSection').classList.add('hidden');
            packageDefaultItems = [];
            currentPackage = null;
        }
    });

    // Cek ketersediaan tanggal
    let dateCheckTimeout;
    function checkDateAvailability() {
        const date = document.getElementById('event_date').value;
        const venue = document.getElementById('venue_type').value;
        const availabilityDiv = document.getElementById('dateAvailability');
        if (!date || !venue) {
            availabilityDiv.innerHTML = '';
            return;
        }
        availabilityDiv.innerHTML = '<span class="text-gray-500"><i class="fas fa-spinner fa-spin mr-1"></i>Memeriksa...</span>';
        clearTimeout(dateCheckTimeout);
        dateCheckTimeout = setTimeout(() => {
            fetch(`${checkDateRoute}?date=${date}&venue_type=${venue}`)
                .then(res => res.json())
                .then(data => {
                    if (data.available) {
                        availabilityDiv.innerHTML = '<span class="text-green-500"><i class="fas fa-check-circle mr-1"></i>' + data.message + '</span>';
                    } else {
                        availabilityDiv.innerHTML = '<span class="text-red-500"><i class="fas fa-times-circle mr-1"></i>' + data.message + '</span>';
                    }
                })
                .catch(() => {
                    availabilityDiv.innerHTML = '<span class="text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>Gagal memeriksa tanggal</span>';
                });
        }, 500);
    }

    document.getElementById('event_date').addEventListener('change', checkDateAvailability);
    document.getElementById('venue_type').addEventListener('change', checkDateAvailability);

    // Trigger jika ada package dari URL
    if (document.getElementById('package_code').value) {
        document.getElementById('package_code').dispatchEvent(new Event('change'));
    }
</script>
@endpush