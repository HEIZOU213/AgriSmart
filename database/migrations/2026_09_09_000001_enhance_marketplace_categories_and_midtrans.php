<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kategori_produk', function (Blueprint $table) {
            if (!Schema::hasColumn('kategori_produk', 'tipe_penjualan')) {
                $table->string('tipe_penjualan')->default('langsung')->after('slug');
            }
            if (!Schema::hasColumn('kategori_produk', 'satuan_default')) {
                $table->string('satuan_default')->default('pcs')->after('tipe_penjualan');
            }
            if (!Schema::hasColumn('kategori_produk', 'dp_amount')) {
                $table->decimal('dp_amount', 12, 2)->default(0)->after('satuan_default');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'midtrans_server_key')) {
                $table->string('midtrans_server_key')->nullable()->after('saldo');
            }
            if (!Schema::hasColumn('users', 'midtrans_client_key')) {
                $table->string('midtrans_client_key')->nullable()->after('midtrans_server_key');
            }
            if (!Schema::hasColumn('users', 'midtrans_merchant_id')) {
                $table->string('midtrans_merchant_id')->nullable()->after('midtrans_client_key');
            }
            if (!Schema::hasColumn('users', 'midtrans_is_production')) {
                $table->boolean('midtrans_is_production')->default(false)->after('midtrans_merchant_id');
            }
        });

        Schema::table('produk', function (Blueprint $table) {
            if (!Schema::hasColumn('produk', 'satuan')) {
                $table->string('satuan')->default('pcs')->after('harga');
            }
            if (!Schema::hasColumn('produk', 'tipe_produk')) {
                $table->string('tipe_produk')->default('ready_stock')->after('stok');
            }
            if (!Schema::hasColumn('produk', 'estimasi_panen')) {
                $table->string('estimasi_panen')->nullable()->after('tipe_produk');
            }
        });

        Schema::table('pesanan', function (Blueprint $table) {
            $table->string('status', 50)->default('pending')->change();
            if (!Schema::hasColumn('pesanan', 'tipe_pesanan')) {
                $table->string('tipe_pesanan')->default('langsung')->after('snap_token');
            }
            if (!Schema::hasColumn('pesanan', 'dp_amount')) {
                $table->decimal('dp_amount', 12, 2)->default(0)->after('tipe_pesanan');
            }
            if (!Schema::hasColumn('pesanan', 'dp_paid_at')) {
                $table->timestamp('dp_paid_at')->nullable()->after('dp_amount');
            }
            if (!Schema::hasColumn('pesanan', 'berat_aktual_kg')) {
                $table->decimal('berat_aktual_kg', 8, 2)->nullable()->after('dp_paid_at');
            }
            if (!Schema::hasColumn('pesanan', 'harga_per_kg')) {
                $table->decimal('harga_per_kg', 12, 2)->nullable()->after('berat_aktual_kg');
            }
            if (!Schema::hasColumn('pesanan', 'total_setelah_timbang')) {
                $table->decimal('total_setelah_timbang', 12, 2)->nullable()->after('harga_per_kg');
            }
            if (!Schema::hasColumn('pesanan', 'sisa_pelunasan')) {
                $table->decimal('sisa_pelunasan', 12, 2)->nullable()->after('total_setelah_timbang');
            }
            if (!Schema::hasColumn('pesanan', 'pelunasan_snap_token')) {
                $table->string('pelunasan_snap_token')->nullable()->after('sisa_pelunasan');
            }
            if (!Schema::hasColumn('pesanan', 'pelunasan_paid_at')) {
                $table->timestamp('pelunasan_paid_at')->nullable()->after('pelunasan_snap_token');
            }
            if (!Schema::hasColumn('pesanan', 'kwitansi_nomor')) {
                $table->string('kwitansi_nomor')->nullable()->after('pelunasan_paid_at');
            }
            if (!Schema::hasColumn('pesanan', 'kwitansi_qr_payload')) {
                $table->text('kwitansi_qr_payload')->nullable()->after('kwitansi_nomor');
            }
            if (!Schema::hasColumn('pesanan', 'is_seen')) {
                $table->boolean('is_seen')->default(false)->after('kwitansi_qr_payload');
            }
        });

        // Seed or update standard categories
        $categories = [
            [
                'nama_kategori' => 'Bibit Durian',
                'slug' => 'bibit-durian',
                'tipe_penjualan' => 'langsung',
                'satuan_default' => 'bibit',
                'dp_amount' => 0,
            ],
            [
                'nama_kategori' => 'Buah Durian',
                'slug' => 'buah-durian',
                'tipe_penjualan' => 'booking_dp',
                'satuan_default' => 'kg',
                'dp_amount' => 100000,
            ],
            [
                'nama_kategori' => 'Produk Turunan Durian',
                'slug' => 'produk-turunan-durian',
                'tipe_penjualan' => 'langsung',
                'satuan_default' => 'pcs',
                'dp_amount' => 0,
            ],
        ];

        foreach ($categories as $cat) {
            $existing = DB::table('kategori_produk')->where('slug', $cat['slug'])->first();
            if ($existing) {
                DB::table('kategori_produk')->where('id', $existing->id)->update([
                    'nama_kategori' => $cat['nama_kategori'],
                    'tipe_penjualan' => $cat['tipe_penjualan'],
                    'satuan_default' => $cat['satuan_default'],
                    'dp_amount' => $cat['dp_amount'],
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('kategori_produk')->insert([
                    'nama_kategori' => $cat['nama_kategori'],
                    'slug' => $cat['slug'],
                    'tipe_penjualan' => $cat['tipe_penjualan'],
                    'satuan_default' => $cat['satuan_default'],
                    'dp_amount' => $cat['dp_amount'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropColumn([
                'tipe_pesanan',
                'dp_amount',
                'dp_paid_at',
                'berat_aktual_kg',
                'harga_per_kg',
                'total_setelah_timbang',
                'sisa_pelunasan',
                'pelunasan_snap_token',
                'pelunasan_paid_at',
                'kwitansi_nomor',
                'kwitansi_qr_payload',
                'is_seen',
            ]);
        });

        Schema::table('produk', function (Blueprint $table) {
            $table->dropColumn(['satuan', 'tipe_produk', 'estimasi_panen']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'midtrans_server_key',
                'midtrans_client_key',
                'midtrans_merchant_id',
                'midtrans_is_production',
            ]);
        });

        Schema::table('kategori_produk', function (Blueprint $table) {
            $table->dropColumn([
                'tipe_penjualan',
                'satuan_default',
                'dp_amount',
            ]);
        });
    }
};