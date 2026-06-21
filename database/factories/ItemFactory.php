<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        Item::insert([

            [
                'code' => 'ITM-001',
                'name' => 'Rias Pengantin',
                'description' => 'Rias pengantin',
                'price' => 1000000,
                'is_active' => true,
            ],

            [
                'code' => 'ITM-002',
                'name' => 'Rias Keluarga & Pager Ayu',
                'description' => 'Rias keluarga dan pager ayu',
                'price' => 350000,
                'is_active' => true,
            ],

            [
                'code' => 'ITM-003',
                'name' => 'Pelaminan 6m',
                'description' => 'Pelaminan ukuran 6 meter',
                'price' => 5000000,
                'is_active' => true,
            ],

            [
                'code' => 'ITM-004',
                'name' => 'Melati Segar',
                'description' => 'Dekorasi menggunakan melati segar',
                'price' => 500000,
                'is_active' => true,
            ],

            [
                'code' => 'ITM-005',
                'name' => 'Dekorasi Bunga Hidup + Plastik',
                'description' => 'Dekorasi bunga hidup dan plastik',
                'price' => 3000000,
                'is_active' => true,
            ],

            [
                'code' => 'ITM-006',
                'name' => 'Taman Bunga Hidup + Plastik',
                'description' => 'Taman dekorasi bunga',
                'price' => 1000000,
                'is_active' => true,
            ],

            [
                'code' => 'ITM-007',
                'name' => 'Tenda 12 x 12',
                'description' => 'Tenda ukuran 12 x 12 meter',
                'price' => 5760000,
                'is_active' => true,
            ],

            [
                'code' => 'ITM-008',
                'name' => 'Tenda Kerucut 3 x 3',
                'description' => 'Tenda kerucut ukuran 3 x 3 meter',
                'price' => 360000,
                'is_active' => true,
            ],

            [
                'code' => 'ITM-009',
                'name' => 'Panggung Pelaminan 3 x 6',
                'description' => 'Panggung pelaminan',
                'price' => 900000,
                'is_active' => true,
            ],

            [
                'code' => 'ITM-010',
                'name' => 'Kursi + Bungkus',
                'description' => 'Kursi dengan bungkus',
                'price' => 10000,
                'is_active' => true,
            ],

            [
                'code' => 'ITM-011',
                'name' => 'Meja VIP + Kursi',
                'description' => 'Meja VIP dan kursi',
                'price' => 75000,
                'is_active' => true,
            ],

            [
                'code' => 'ITM-012',
                'name' => 'Meja Prasmanan',
                'description' => 'Meja prasmanan',
                'price' => 300000,
                'is_active' => true,
            ],

            [
                'code' => 'ITM-013',
                'name' => 'Meja Tamu',
                'description' => 'Meja tamu acara',
                'price' => 75000,
                'is_active' => true,
            ],

            [
                'code' => 'ITM-014',
                'name' => 'Meja Buah/Snack',
                'description' => 'Meja buah dan snack',
                'price' => 75000,
                'is_active' => true,
            ],

            [
                'code' => 'ITM-015',
                'name' => 'Piring + Sendok + Garpu',
                'description' => 'Peralatan makan',
                'price' => 4000,
                'is_active' => true,
            ],

            [
                'code' => 'ITM-016',
                'name' => 'Tempat Lauk + Tempat Nasi',
                'description' => 'Tempat lauk dan nasi',
                'price' => 50000,
                'is_active' => true,
            ],

            [
                'code' => 'ITM-017',
                'name' => 'Gapura + Selamat Datang',
                'description' => 'Dekorasi gapura masuk',
                'price' => 150000,
                'is_active' => true,
            ],

            [
                'code' => 'ITM-018',
                'name' => 'Karpet Jalan',
                'description' => 'Karpet jalan masuk',
                'price' => 240000,
                'is_active' => true,
            ],

            [
                'code' => 'ITM-019',
                'name' => 'Standing Photo',
                'description' => 'Standing foto acara',
                'price' => 50000,
                'is_active' => true,
            ],

            [
                'code' => 'ITM-020',
                'name' => 'Photo + Video',
                'description' => 'Dokumentasi foto dan video',
                'price' => 2000000,
                'is_active' => true,
            ],

        ]);
    }
}