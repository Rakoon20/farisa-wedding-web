<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('method')->change();
        });
    }

    public function down()
    {
        // Kembalikan ke enum (opsional)
        Schema::table('payments', function (Blueprint $table) {
            $table->enum('method', ['cash', 'transfer', 'midtrans'])->change();
        });
    }
};
