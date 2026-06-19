<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("order_items", function (Blueprint $table) {
            $table->id();
            $table->string("order_number");
            $table->string("item_code");
            $table->string("item_name");
            $table->integer("quantity"); // BISA POSITIF (tambah) atau NEGATIF (kurang)
            $table->integer("price_per_unit");
            $table->integer("subtotal"); // quantity * price_per_unit
            $table->enum("type", ["package_item", "custom_addition", "custom_reduction"])->default("custom_addition");
            $table->timestamps();

            $table->foreign("order_number")->references("order_number")->on("orders")->cascadeOnDelete();
            $table->foreign("item_code")->references("code")->on("items")->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("order_items");
    }
};
