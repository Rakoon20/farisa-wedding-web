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
        Schema::create("orders", function (Blueprint $table) {
            $table->string("order_number")->primary();
            $table->string("customer_name");
            $table->string("customer_phone");
            $table->text("customer_address")->nullable();
            $table->date("event_date");
            $table->string("package_code")->nullable();
            $table->integer("package_price")->nullable(); // harga paket asli
            $table->integer("total_price"); // final setelah adjustment
            $table->integer("dp_amount")->default(0);
            $table->integer("additional_charge")->default(0);
            $table->string("charge_description")->nullable();
            $table->enum("status", ["pending", "dp_paid", "installment", "paid", "completed", "cancelled"])->default("pending");
            $table->text("notes")->nullable();
            $table->foreignId("created_by")->constrained("users");
            $table->timestamps();

            $table->foreign("package_code")->references("code")->on("packages")->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("orders");
    }
};
