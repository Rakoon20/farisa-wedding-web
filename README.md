# Farisa Wedding Organizer

Sistem manajemen wedding organizer berbasis web dengan fitur pemesanan paket, pembayaran manual (QRIS/transfer), pelacakan pesanan, manajemen admin (Filament), dan laporan pendapatan.

## ✨ Fitur Utama

### Untuk Customer

- **Lihat Paket Wedding** – Menampilkan daftar paket dengan detail item dan harga.
- **Pemesanan Online** – Pilih paket, tambah/kurang item (adjustment), isi data diri, pilih tanggal acara & jenis venue.
- **Cek Ketersediaan Tanggal** – Validasi bentrok jadwal (max 2 acara/hari, larangan dua tenda di hari sama).
- **Upload Bukti Pembayaran** – Unggah bukti transfer/QRIS untuk DP, cicilan, atau pelunasan.
- **Tracking Pesanan** – Cek status pesanan, riwayat pembayaran, sisa tagihan, dan galeri contoh baju.
- **Download Invoice** (setelah lunas) – Unduh invoice PDF otomatis.
- **Galeri Baju** – Lihat koleksi model baju sebagai referensi sebelum fitting.

### Untuk Admin (Filament Panel)

- **Manajemen Order** – Lihat, edit, hapus pesanan, ubah status (pending, dp_paid, installment, paid, completed, cancelled).
- **Manajemen Pembayaran** – Konfirmasi bukti bayar (update `is_confirmed`), otomatis ubah status order.
- **Manajemen Paket** – CRUD paket wedding, atur item dalam paket & harga.
- **Manajemen Koleksi Baju** – Tambah/edit/hapus baju (nama, kategori, gambar, warna) sebagai galeri referensi.
- **Manajemen Items (Barang)** – CRUD barang/jasa pendukung (kursi, tenda, rias, dll) dengan harga.
- **Laporan Pendapatan** – Export Excel/PDF pendapatan berdasarkan rentang tanggal (hanya pembayaran terkonfirmasi).
- **Dashboard** – Statistik (total order, selesai, pemasukan, pending konfirmasi), grafik pendapatan bulanan, daftar order terbaru, widget pending konfirmasi.

### Fitur Teknis

- Auto-generate nomor pesanan (WO-YYYY-XXXX)
- Validasi bentrok jadwal (venue & jumlah acara)
- Auto-update total harga saat admin ubah biaya tambahan (additional_charge)
- Payment otomatis tercatat saat admin ubah status order (dari `pending` ke `dp_paid` → buat payment DP, dari `pending`/`installment` ke `paid` → buat payment final)
- Upload bukti pembayaran oleh customer langsung masuk ke payments dengan status `is_confirmed = false`
- Data fitting baju diinput admin (tidak online), customer hanya lihat galeri

## 🛠 Teknologi

- **Framework**: Laravel 12
- **Admin Panel**: Filament 5
- **Frontend**: Blade + Tailwind CSS + Alpine.js
- **Database**: MySQL
- **PDF**: barryvdh/laravel-dompdf
- **Excel**: maatwebsite/excel
- **Chart**: Flowframe/laravel-trend

## 📁 Instalasi

### Prasyarat

- PHP >= 8.2
- Composer
- MySQL
- Node.js & NPM (opsional, untuk assets)

### Langkah-langkah

```bash
# Clone repository
git clone https://github.com/username/farisa-wo.git
cd farisa-wo

# Install dependensi PHP
composer install

# Install dependensi Node (jika ada frontend assets)
npm install && npm run build

# Copy file environment
cp .env.example .env

# Konfigurasi database di file .env
DB_DATABASE=wedding_dekstop_app
DB_USERNAME=root
DB_PASSWORD=

# Generate key
php artisan key:generate

# Jalankan migration (pastikan database sudah dibuat)
php artisan migrate

# (Opsional) Seed data awal
php artisan db:seed

# Buat symbolic link untuk storage
php artisan storage:link

# Jalankan server
php artisan serve
```

### Akses Aplikasi

- **Website Customer**: `http://localhost:8000`
- **Admin Panel**: `http://localhost:8000/admin`  
  Login dengan user yang dibuat (gunakan `php artisan tinker` untuk membuat user, atau seeder)

## 📦 Struktur Database (Inti)

- `items` – barang/jasa (kursi, tenda, dll)
- `packages` – paket wedding
- `package_items` – pivot paket ↔ item (dengan quantity)
- `orders` – pesanan customer (nomor unik, status, total, biaya tambahan)
- `order_items` – adjustment item dari paket (tambah/kurang)
- `payments` – catatan pembayaran (dp, cicilan, final) dengan flag `is_confirmed`
- `fittings` – data fitting (diisi admin)
- `clothes` – koleksi baju untuk galeri

## 🧪 Penggunaan

### Customer

1. Buka `/packages` → pilih paket → klik "Pesan Sekarang"
2. Isi form, tentukan adjustment item (opsional), pilih tanggal & venue
3. Submit → dapat nomor pesanan & instruksi bayar DP
4. Lakukan pembayaran via QRIS/transfer ke rekening yang tertera
5. Upload bukti melalui halaman `/tracking`
6. Admin konfirmasi → status order berubah, notifikasi di dashboard
7. Setelah total bayar mencapai 50%, customer bisa mengisi data fitting (form muncul di tracking)
8. Setelah lunas → bisa download invoice

### Admin

- Login ke `/admin`
- Kelola order, konfirmasi pembayaran (tab "Payments" di edit order)
- Lihat pending konfirmasi di widget dashboard atau widget khusus
- Export laporan dari widget Reports (pilih rentang tanggal)
- Kelola paket, item, koleksi baju dari menu navigasi

## ⚙️ Konfigurasi Penting

- **Biaya Tambahan**: Admin dapat mengisi `additional_charge` di edit order (misal biaya luar kota/gang sempit), total otomatis update.
- **Ketersediaan Tanggal**: Diatur di model `Order::isDateAvailable()`. Maksimal 2 acara/hari, tidak boleh dua tenda di hari yang sama.
- **DP**: Fixed Rp1.000.000, disimpan di kolom `dp_amount`. Saat admin ubah status `pending` → `dp_paid`, otomatis buat payment DP.
- **Fitting**: Hanya admin yang input via relation manager di edit order. Customer lihat galeri baju sebagai referensi.

## 📄 Lisensi

MIT License – silakan gunakan dan modifikasi sesuai kebutuhan.

## 👤 Kontak

Untuk pertanyaan lebih lanjut, hubungi:  
Farisa Wedding Organizer – [info@farisawo.com](mailto:info@farisawo.com)
