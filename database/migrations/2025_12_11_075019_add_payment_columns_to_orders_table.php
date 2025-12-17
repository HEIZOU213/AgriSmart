<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
        $table->string('snap_token')->nullable()->after('total_price'); // Token dari Midtrans
        $table->string('status')->default('pending')->after('snap_token'); // pending, success, failed
        $table->decimal('admin_fee', 15, 2)->default(0); // Keuntungan kamu
        $table->decimal('seller_income', 15, 2)->default(0); // Hak petani
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
