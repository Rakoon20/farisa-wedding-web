<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom package_price ke orders
        // Schema::table('orders', function (Blueprint $table) {
        //     $table->integer('package_price')->nullable()->after('package_code');
        // });

        // Tambah kolom yang diperlukan ke order_items
        // Schema::table('order_items', function (Blueprint $table) {
        //     $table->string('item_name')->nullable()->after('item_code');
        //     $table->integer('subtotal')->nullable()->after('price_per_unit');
        //     $table->enum('type', ['package_default', 'custom_addition', 'custom_reduction'])->default('custom_addition')->after('subtotal');
        // });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('package_price');
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['item_name', 'subtotal', 'type']);
        });
    }
};
