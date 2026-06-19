<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fitting_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fitting_id')->constrained()->cascadeOnDelete();
            $table->foreignId('cloth_id')->constrained('clothes')->cascadeOnDelete();
            $table->string('size');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fitting_items');
    }
};
