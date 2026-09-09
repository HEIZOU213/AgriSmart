<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('produk')) {
            if (!Schema::hasColumn('produk', 'satuan')) {
                Schema::table('produk', function (Blueprint $table) {
                    $table->string('satuan')->default('pcs')->nullable()->after('harga');
                });
            }
            if (!Schema::hasColumn('produk', 'tipe_produk')) {
                Schema::table('produk', function (Blueprint $table) {
                    $table->string('tipe_produk')->default('ready_stock')->nullable()->after('stok');
                });
            }
            if (!Schema::hasColumn('produk', 'estimasi_panen')) {
                Schema::table('produk', function (Blueprint $table) {
                    $table->string('estimasi_panen')->nullable()->after('tipe_produk');
                });
            }
        }
    }

    public function down(): void
    {
    }
};
