<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPesanan extends Model
{
    use HasFactory;

    /**
     * Menentukan nama tabel yang terkait dengan model.
     */
    protected $table = 'detail_pesanan';

    /**
     * [PENTING] Daftar kolom yang boleh diisi.
     * Tanpa ini, Laravel akan menolak menyimpan data barang belanjaan.
     */
    protected $fillable = [
        'pesanan_id',   // <--- WAJIB ADA
        'produk_id',    // <--- WAJIB ADA
        'jumlah',
        'harga_satuan'
    ];

    /**
     * Relasi Many-to-One: Satu Detail Pesanan milik satu Pesanan
     */
    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class);
    }

    /**
     * Relasi Many-to-One: Satu Detail Pesanan merujuk ke satu Produk
     */
    public function produk(): BelongsTo
    {
        // Pastikan nama model Produk sesuai (Produk::class)
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }
}