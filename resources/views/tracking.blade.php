@extends('layouts.app')

@section('title', 'Tracking Pesanan - Farisa Wedding Organizer')

@section('content')
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-3xl font-bold text-center mb-8">Tracking Pesanan</h1>

            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <form id="trackingForm" class="flex gap-3">
                    <input type="text" id="orderNumber" placeholder="Masukkan nomor telepon/WA (contoh: 081234567890)" class="flex-1 border rounded px-4 py-2">
                    <button type="submit" id="searchBtn" class="bg-pink-500 text-white px-6 py-2 rounded-full hover:bg-pink-600 transition flex items-center gap-2">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </form>
                <p class="text-xs text-gray-400 mt-2">*Cari pesanan menggunakan nomor telepon yang didaftarkan saat pemesanan.</p>
            </div>

            <div id="trackingResult" class="hidden bg-white rounded-lg shadow p-6"></div>
        </div>
    </div>
</section>

<!-- Modal Popup QRIS -->
<div id="qrisModal" class="fixed inset-0 bg-black bg-opacity-80 hidden items-center justify-center z-50" onclick="closeQrisModal()">
    <div class="relative max-w-md mx-auto p-4" onclick="event.stopPropagation()">
        <button onclick="closeQrisModal()" class="absolute -top-10 right-0 text-white text-3xl hover:text-pink-400">&times;</button>
        <img src="{{ asset('images/qris.webp') }}" alt="QRIS" class="w-full rounded-lg shadow-2xl">
        <p class="text-center text-white mt-3 text-sm">Scan QRIS untuk pembayaran</p>
    </div>
</div>

<div id="toast" class="fixed bottom-5 right-5 z-50 transform transition-all duration-300 translate-y-20 opacity-0">
    <div class="bg-gray-800 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3">
        <i id="toastIcon" class="fas fa-info-circle"></i>
        <span id="toastMessage"></span>
    </div>
</div>
@endsection

@push('styles')
<style>
    .loading-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 2px solid #f3f3f3;
        border-top: 2px solid #ec489a;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .btn-loading {
        opacity: 0.7;
        pointer-events: none;
    }
    .fade-enter {
        animation: fadeIn 0.3s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .gallery-img {
        cursor: pointer;
        transition: transform 0.2s;
    }
    .gallery-img:hover {
        transform: scale(1.05);
    }
</style>
@endpush

@push('scripts')
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
    const invoiceRoute = @json(route('invoice.download', '__ORDER_NUMBER__'));

    function showToast(message, type = 'info') {
        const toast = document.getElementById('toast');
        const toastIcon = document.getElementById('toastIcon');
        const toastMessage = document.getElementById('toastMessage');
        
        toastIcon.className = '';
        if (type === 'success') toastIcon.classList.add('fas', 'fa-check-circle', 'text-green-400');
        else if (type === 'error') toastIcon.classList.add('fas', 'fa-exclamation-circle', 'text-red-400');
        else if (type === 'warning') toastIcon.classList.add('fas', 'fa-exclamation-triangle', 'text-yellow-400');
        else toastIcon.classList.add('fas', 'fa-info-circle', 'text-blue-400');
        
        toastMessage.innerText = message;
        toast.classList.remove('translate-y-20', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');
        setTimeout(() => {
            toast.classList.remove('translate-y-0', 'opacity-100');
            toast.classList.add('translate-y-20', 'opacity-0');
        }, 3000);
    }

    function setButtonLoading(btn, isLoading) {
        if (isLoading) {
            btn.classList.add('btn-loading');
            btn.disabled = true;
            const originalHtml = btn.innerHTML;
            btn.setAttribute('data-original-html', originalHtml);
            btn.innerHTML = '<div class="loading-spinner"></div> Memuat...';
        } else {
            btn.classList.remove('btn-loading');
            btn.disabled = false;
            const originalHtml = btn.getAttribute('data-original-html');
            if (originalHtml) btn.innerHTML = originalHtml;
        }
    }

    function openImageModal(url) {
        let modal = document.getElementById('imageModal');
        if (modal) modal.remove();
        modal = document.createElement('div');
        modal.id = 'imageModal';
        modal.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.85);z-index:10000;display:flex;align-items:center;justify-content:center;cursor:pointer';
        modal.onclick = () => modal.remove();
        const img = document.createElement('img');
        img.src = url;
        img.style.cssText = 'max-width:90%;max-height:90%;border-radius:8px;box-shadow:0 0 20px rgba(0,0,0,0.5)';
        img.onclick = e => e.stopPropagation();
        modal.appendChild(img);
        document.body.appendChild(modal);
    }

    function openQrisModal() {
        const modal = document.getElementById('qrisModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeQrisModal() {
        const modal = document.getElementById('qrisModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeQrisModal();
        }
    });

    // Map status badge
    const statusBadgeMap = {
        'pending': '<span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-sm">Menunggu DP</span>',
        'dp_paid': '<span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm">DP Dibayar</span>',
        'installment': '<span class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-sm">Cicilan</span>',
        'paid': '<span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">Lunas</span>',
        'completed': '<span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-sm">Selesai</span>',
        'cancelled': '<span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-sm">Dibatalkan</span>'
    };

    function renderOrderDetail(order, payments, clothGallery, fitting) {
        const resultDiv = document.getElementById('trackingResult');
        const statusBadge = statusBadgeMap[order.status] || order.status;

        let html = `
            <div class="fade-enter">
                <h2 class="font-bold text-xl mb-4">Detail Pesanan: ${escapeHtml(order.order_number)}</h2>
                <div class="space-y-3">
                    <div class="flex justify-between"><span class="font-semibold">Nama:</span> ${escapeHtml(order.customer_name)}</div>
                    <div class="flex justify-between"><span class="font-semibold">Tanggal Acara:</span> ${new Date(order.event_date).toLocaleDateString('id-ID')}</div>
                    <div class="flex justify-between"><span class="font-semibold">Paket:</span> ${escapeHtml(order.package_name || order.package_code)}</div>
                    <div class="flex justify-between"><span class="font-semibold">Jenis Venue:</span> ${escapeHtml(order.venue_label || '-')}</div>
                    <div class="flex justify-between"><span class="font-semibold">Total Harga:</span> Rp ${formatNumber(order.total_price)}</div>
                    <div class="flex justify-between"><span class="font-semibold">Status:</span> ${statusBadge}</div>
                    <div class="flex justify-between"><span class="font-semibold">Total Dibayar:</span> Rp ${formatNumber(order.total_paid || 0)}</div>
                    <div class="flex justify-between"><span class="font-semibold">Sisa:</span> Rp ${formatNumber(order.remaining_payment || order.total_price)}</div>
                </div>
            </div>
        `;

        // Informasi Pembayaran
        html += `<div class="mt-6 p-4 bg-pink-50 rounded-lg">
                    <h3 class="font-semibold text-lg mb-2">Informasi Pembayaran</h3>
                    <p class="text-sm mb-3">Silakan transfer ke rekening berikut atau scan QRIS:</p>
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1 text-center">
                            <img src="{{ asset('images/qris.webp') }}" alt="QRIS" 
                                 class="w-32 mx-auto border rounded cursor-pointer hover:opacity-90 transition"
                                 onclick="openQrisModal()">
                            <p class="text-xs mt-1">Klik untuk memperbesar</p>
                        </div>
                        <div class="flex-1">
                            <p><strong>Bank BCA</strong><br>123-456-7890<br>a.n Farisa Wedding Organizer</p>
                            <p class="mt-2"><strong>Bank Mandiri</strong><br>987-654-3210<br>a.n Farisa Wedding Organizer</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-3">*Upload bukti pembayaran melalui tombol di bawah.</p>
                </div>`;

        // Riwayat pembayaran
        if (payments.length > 0) {
            html += `<h3 class="font-semibold text-lg mt-6 mb-2">Riwayat Pembayaran</h3><div class="space-y-3">`;
            payments.forEach(p => {
                let statusBadgeHtml = p.is_confirmed ? '<span class="ml-2 bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded-full">✓ Dikonfirmasi</span>' : '<span class="ml-2 bg-yellow-100 text-yellow-800 text-xs px-2 py-0.5 rounded-full">⏳ Menunggu</span>';
                html += `<div class="border-l-4 border-pink-500 pl-3 py-2 bg-gray-50 rounded">
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="font-medium">${escapeHtml(p.type_label)}</span>
                                    <span class="text-xs text-gray-500 ml-2">${p.method.toUpperCase()}</span>
                                    ${statusBadgeHtml}
                                </div>
                                <span class="font-bold text-pink-600">Rp ${formatNumber(p.amount)}</span>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                Tanggal: ${p.payment_date ? new Date(p.payment_date).toLocaleDateString('id-ID') : '-'}
                            </div>
                            ${p.proof ? `<div class="mt-1"><a href="${p.proof}" target="_blank" class="text-xs text-blue-500 hover:underline">Lihat Bukti</a></div>` : ''}
                            ${p.notes ? `<div class="text-xs text-gray-400 mt-1">Catatan: ${escapeHtml(p.notes)}</div>` : ''}
                        </div>`;
            });
            html += `</div>`;
        }

        // ======== DATA FITTING & GALERI BAJU ========
        html += `<div class="mt-6 pt-4 border-t">`;
        if (fitting) {
            // Tampilkan data fitting dan detail baju
            html += `
                <h3 class="font-semibold text-lg mb-3">Data Fitting</h3>
                <div class="bg-gray-100 p-4 rounded-lg">
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <div><span class="font-medium">Tanggal Fitting:</span> ${new Date(fitting.fitting_date).toLocaleDateString('id-ID')}</div>
                        <div><span class="font-medium">Status:</span> ${escapeHtml(fitting.status_label)}</div>
                        <div><span class="font-medium">Catatan:</span> ${escapeHtml(fitting.notes || '-')}</div>
                    </div>
                    ${fitting.items && fitting.items.length > 0 ? `
                        <div class="mt-3 pt-2 border-t border-gray-300">
                            <span class="font-medium text-sm">Detail Baju:</span>
                            <ul class="mt-1 space-y-1 text-sm">
                                ${fitting.items.map(item => `
                                    <li class="flex justify-between">
                                        <span>${escapeHtml(item.cloth_name)}</span>
                                        <span class="text-gray-600">${escapeHtml(item.size)} x${item.quantity}</span>
                                    </li>
                                `).join('')}
                            </ul>
                        </div>
                    ` : '<div class="text-xs text-gray-400 mt-2">Tidak ada detail baju.</div>'}
                </div>
            `;
        } else {
            // Tampilkan galeri baju jika ada, atau fallback
            if (clothGallery.length > 0) {
                html += `<h3 class="font-semibold text-lg mb-3">Contoh Model Baju</h3>
                         <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">`;
                clothGallery.forEach(cloth => {
                    html += `<div class="bg-gray-100 rounded-lg p-2 text-center cursor-pointer gallery-img" onclick="openImageModal('${cloth.image_url}')">
                                 <img src="${cloth.image_url}" alt="${escapeHtml(cloth.name)}" class="w-full h-32 object-cover rounded-md">
                                 <p class="text-sm font-medium mt-1">${escapeHtml(cloth.name)}</p>
                                 ${cloth.color ? `<p class="text-xs text-gray-500">${escapeHtml(cloth.color)}</p>` : ''}
                             </div>`;
                });
                html += `</div>`;
                html += `<p class="text-xs text-gray-500 mt-3">*Untuk fitting, silakan datang ke galeri kami. Admin akan membantu pengukuran dan pemilihan baju.</p>`;
            } else {
                html += `<div class="text-gray-500 text-sm">
                            <i class="fas fa-tshirt mr-1"></i> 
                            Informasi contoh baju akan segera tersedia. Untuk fitting, silakan hubungi admin.
                         </div>`;
            }
        }
        html += `</div>`;

        // Tombol aksi
        if (order.status === 'paid' || order.status === 'completed') {
            const invoiceUrl = invoiceRoute.replace('__ORDER_NUMBER__', order.order_number);
            html += `<div class="mt-4 pt-4 border-t">
                        <a href="${invoiceUrl}" target="_blank" class="bg-green-500 text-white px-4 py-2 rounded-full text-sm hover:bg-green-600 transition inline-flex items-center gap-2">
                            <i class="fas fa-download"></i> Download Invoice
                        </a>
                        <p class="text-xs text-gray-500 mt-2">Pesanan sudah lunas. Terima kasih!</p>
                     </div>`;
        } else {
            html += `<div class="mt-4 pt-4 border-t">
                        <button onclick="showUploadForm('${order.order_number}', ${order.remaining_payment})" class="bg-pink-500 text-white px-4 py-2 rounded-full text-sm hover:bg-pink-600 transition">
                            Upload Bukti Pembayaran
                        </button>
                     </div>`;
        }

        resultDiv.innerHTML = html;
        resultDiv.classList.remove('hidden');
    }

    function fetchOrderDetail(orderNumber) {
        const resultDiv = document.getElementById('trackingResult');
        resultDiv.innerHTML = '<div class="text-center py-8"><div class="loading-spinner"></div><p class="mt-2 text-gray-500">Memuat detail...</p></div>';
        resultDiv.classList.remove('hidden');

        fetch(`/tracking/${encodeURIComponent(orderNumber)}`)
            .then(res => res.json())
            .then(data => {
                if (!data.order) {
                    resultDiv.innerHTML = '<div class="text-red-500 text-center py-4">Detail tidak ditemukan</div>';
                    showToast('Detail tidak ditemukan', 'error');
                    return;
                }
                renderOrderDetail(data.order, data.payments, data.cloth_gallery, data.fitting);
                showToast('Detail pesanan ditemukan', 'success');
            })
            .catch(err => {
                resultDiv.innerHTML = '<div class="text-red-500 text-center py-4">Gagal memuat detail</div>';
                showToast('Gagal memuat detail', 'error');
            });
    }

    document.getElementById('trackingForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const phoneNumber = document.getElementById('orderNumber').value.trim();
        if (!phoneNumber) {
            showToast('Masukkan nomor telepon terlebih dahulu', 'warning');
            return;
        }

        const searchBtn = document.getElementById('searchBtn');
        setButtonLoading(searchBtn, true);

        const resultDiv = document.getElementById('trackingResult');
        resultDiv.innerHTML = '<div class="text-center py-8"><div class="loading-spinner"></div><p class="mt-2 text-gray-500">Memuat data...</p></div>';
        resultDiv.classList.remove('hidden');

        try {
            const res = await fetch(`/tracking/phone/${encodeURIComponent(phoneNumber)}`);
            const data = await res.json();

            if (data.error) {
                resultDiv.innerHTML = '<div class="text-red-500 text-center py-4">Terjadi kesalahan. Coba lagi nanti.</div>';
                showToast('Gagal memuat data', 'error');
                return;
            }

            // Multiple orders
            if (data.multiple && data.orders) {
                let listHtml = `
                    <div class="fade-enter">
                        <h2 class="font-bold text-xl mb-4">Daftar Pesanan</h2>
                        <p class="text-sm text-gray-500 mb-4">Ditemukan ${data.orders.length} pesanan dengan nomor ini. Klik salah satu untuk melihat detail.</p>
                        <div class="space-y-3">
                `;
                data.orders.forEach(order => {
                    const badge = statusBadgeMap[order.status] || order.status;
                    listHtml += `
                        <div class="border rounded-lg p-4 hover:shadow-md transition cursor-pointer" onclick="fetchOrderDetail('${order.order_number}')">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-semibold">${escapeHtml(order.order_number)}</p>
                                    <p class="text-sm text-gray-500">${escapeHtml(order.package_name || '-')} - ${new Date(order.event_date).toLocaleDateString('id-ID')}</p>
                                </div>
                                <div class="text-right">
                                    <div>${badge}</div>
                                    <span class="text-sm font-medium">Rp ${formatNumber(order.total_price)}</span>
                                </div>
                            </div>
                        </div>
                    `;
                });
                listHtml += `</div></div>`;
                resultDiv.innerHTML = listHtml;
                showToast('Pilih pesanan untuk melihat detail', 'info');
                return;
            }

            // Single order
            if (!data.order) {
                resultDiv.innerHTML = '<div class="text-red-500 text-center py-4">Pesanan tidak ditemukan dengan nomor tersebut</div>';
                showToast('Pesanan tidak ditemukan', 'error');
                return;
            }

            renderOrderDetail(data.order, data.payments, data.cloth_gallery, data.fitting);
            showToast('Data pesanan ditemukan', 'success');
        } catch (err) {
            console.error(err);
            resultDiv.innerHTML = '<div class="text-red-500 text-center py-4">Terjadi kesalahan. Pastikan nomor telepon benar atau coba lagi nanti.</div>';
            showToast('Gagal memuat data', 'error');
        } finally {
            setButtonLoading(searchBtn, false);
        }
    });

    function showUploadForm(orderNumber, remainingPayment) {
        const resultDiv = document.getElementById('trackingResult');
        const existing = document.getElementById('uploadFormContainer');
        if (existing) existing.remove();

        const uploadFormHtml = `
            <div id="uploadFormContainer" class="mt-4 p-4 bg-gray-100 rounded fade-enter">
                <h3 class="font-semibold mb-2">Upload Bukti Pembayaran</h3>
                <form id="uploadForm" enctype="multipart/form-data">
                    <input type="hidden" name="order_number" value="${orderNumber}">
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <div class="mb-2">
                        <label class="block text-sm">Jumlah Pembayaran</label>
                        <input type="number" name="amount" id="uploadAmount" class="w-full border rounded px-3 py-1" required>
                        <p class="text-xs text-gray-500 mt-1">Sisa tagihan: Rp ${formatNumber(remainingPayment)}</p>
                    </div>
                    <div class="mb-2">
                        <label class="block text-sm">Metode</label>
                        <select name="method" class="w-full border rounded px-3 py-1">
                            <option value="transfer">Transfer Bank</option>
                            <option value="qris">QRIS</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="block text-sm">Upload Bukti (foto/screenshot)</label>
                        <input type="file" name="proof" accept="image/*" required>
                    </div>
                    <button type="submit" id="submitUploadBtn" class="bg-green-500 text-white px-4 py-1 rounded text-sm">Kirim Bukti</button>
                    <button type="button" onclick="document.getElementById('uploadFormContainer').remove()" class="ml-2 text-gray-500 text-sm">Batal</button>
                </form>
            </div>
        `;
        resultDiv.insertAdjacentHTML('beforeend', uploadFormHtml);

        const amountInput = document.getElementById('uploadAmount');
        const submitBtn = document.getElementById('submitUploadBtn');

        function validateAmount() {
            let amount = parseFloat(amountInput.value);
            if (isNaN(amount)) amount = 0;
            if (amount > remainingPayment) {
                showToast(`Jumlah pembayaran tidak boleh melebihi sisa tagihan (Rp ${formatNumber(remainingPayment)})`, 'error');
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }

        amountInput.addEventListener('input', validateAmount);
        validateAmount();

        document.getElementById('uploadForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const amount = parseFloat(amountInput.value);
            if (amount > remainingPayment) {
                showToast('Nominal melebihi sisa tagihan', 'error');
                return;
            }
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerText;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<div class="loading-spinner"></div> Mengirim...';

            const formData = new FormData(this);
            try {
                const res = await fetch('/upload-payment', { method: 'POST', body: formData });
                const data = await res.json();
                showToast(data.message, 'success');
                setTimeout(() => location.reload(), 1500);
            } catch (err) {
                showToast('Gagal mengirim bukti. Coba lagi.', 'error');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });
    }

    function formatNumber(num) {
        if (isNaN(num)) return '0';
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, m => m === '&' ? '&amp;' : (m === '<' ? '&lt;' : '&gt;'));
    }
</script>
@endpush