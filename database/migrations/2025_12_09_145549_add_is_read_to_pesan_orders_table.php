<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('pesan_orders', function (Blueprint $table) {
        // Kolom penanda: 0 = belum dibaca, 1 = sudah dibaca
        $table->boolean('is_read')->default(false)->after('body');
    });
}

public function down()
{
    Schema::table('pesan_orders', function (Blueprint $table) {
        $table->dropColumn('is_read');
    });
}
};
