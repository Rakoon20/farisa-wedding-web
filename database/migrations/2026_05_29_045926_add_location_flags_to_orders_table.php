<?php

use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Schema::table('orders', function (Blueprint $table) {
        //     $table->boolean('is_outside_city')->default(false)->after('city');
        //     $table->boolean('is_narrow_alley')->default(false)->after('is_outside_city');
        // });
    }

    public function down()
    {
        // Schema::table('orders', function (Blueprint $table) {
        //     $table->dropColumn(['is_outside_city', 'is_narrow_alley']);
        // });
    }
};
