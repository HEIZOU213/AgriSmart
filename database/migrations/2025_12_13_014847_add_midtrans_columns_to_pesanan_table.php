<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pesanan', function (Blueprint $table) {
            // Kolom untuk token Midtrans (PENTING AGAR TOMBOL MUNCUL)
            $table->string('snap_token')->nullable()->after('total_harga');
            
            // Kolom untuk Komisi (Penyebab Error Anda)
            $table->decimal('admin_fee', 15, 2)->default(0)->after('snap_token');
            $table->decimal('seller_income', 15, 2)->default(0)->after('admin_fee');
        });
    }

    public function down()
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropColumn(['snap_token', 'admin_fee', 'seller_income']);
        });
    }
};