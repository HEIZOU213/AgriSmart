<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Keranjang extends Model
{
    use HasFactory;

    /**
     * [FIX] Menambahkan kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'user_id',
        'produk_id',
        'jumlah',
    ];

    /**
     * Relasi ke Produk (untuk ambil nama, harga, foto)
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }

    /**
     * Relasi ke User (Pemilik keranjang)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}