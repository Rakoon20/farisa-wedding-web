<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom package_price jika belum ada
        if (!Schema::hasColumn('orders', 'package_price')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->integer('package_price')->nullable()->after('package_code');
            });
        }

        // 2. Perbaiki enum status orders (tambah nilai 'pending')
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'dp_paid', 'installment', 'paid', 'completed', 'cancelled') NOT NULL DEFAULT 'pending'");

        // 3. Jadikan created_by nullable (karena mungkin user belum ada)
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->change();
        });

        // 4. Tambah kolom di order_items jika belum ada
        if (!Schema::hasColumn('order_items', 'item_name')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->string('item_name')->nullable()->after('item_code');
            });
        }
        if (!Schema::hasColumn('order_items', 'subtotal')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->integer('subtotal')->nullable()->after('price_per_unit');
            });
        }
        if (!Schema::hasColumn('order_items', 'type')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->enum('type', ['package_item', 'custom_addition', 'custom_reduction'])->default('custom_addition')->after('subtotal');
            });
        }
    }

    public function down(): void
    {
        // Rollback tidak perlu lengkap, karena hanya perbaikan
        if (Schema::hasColumn('orders', 'package_price')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('package_price');
            });
        }
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable(false)->change();
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['item_name', 'subtotal', 'type']);
        });
    }
};
