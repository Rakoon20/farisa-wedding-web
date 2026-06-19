<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_clothes', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->string('cloth_code'); // foreign ke items.code
            $table->string('size'); // S, M, L, XL, XXL
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('order_number')->references('order_number')->on('orders')->cascadeOnDelete();
            $table->foreign('cloth_code')->references('code')->on('items')->restrictOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_clothes');
    }
};
