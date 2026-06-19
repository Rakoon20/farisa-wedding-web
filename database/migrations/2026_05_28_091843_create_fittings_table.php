<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fittings', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->date('fitting_date')->nullable();
            $table->integer('total_clothes')->nullable();       // jumlah kebutuhan pakaian
            $table->string('size')->nullable();                // ukuran baju
            $table->string('color')->nullable();               // pilihan warna
            $table->text('notes')->nullable();                 // kebutuhan lain
            $table->enum('status', ['pending', 'scheduled', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();

            $table->foreign('order_number')->references('order_number')->on('orders')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fittings');
    }
};
