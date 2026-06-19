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
        Schema::create("items", function (Blueprint $table) {
            $table->string("code")->primary(); // custom code: BRG-001
            $table->string("name");
            $table->text("description")->nullable();

            // Kolom harga (decimal, 12 digit total, 2 digit di belakang koma)
            $table->decimal("price", 12, 2)->default(0);

            $table->boolean("is_active")->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("items");
    }
};
