<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_images', function (Blueprint $table) {
            $table->id();
            $table->string('package_code');
            $table->string('image');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->foreign('package_code')
                ->references('code')
                ->on('packages')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_images');
    }
};
