<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fittings', function (Blueprint $table) {
            $table->dropColumn(['total_clothes', 'size', 'color']);
        });
    }

    public function down(): void
    {
        Schema::table('fittings', function (Blueprint $table) {
            $table->integer('total_clothes')->nullable();
            $table->string('size')->nullable();
            $table->string('color')->nullable();
        });
    }
};
