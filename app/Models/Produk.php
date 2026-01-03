<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    use HasFactory;

    /**
     * Menentukan nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'produk';

    // =================================================================
    // 🔥 SOLUSI PAMUNGKAS: AUTO LOAD RELASI
    // Tambahkan baris ini agar data Petani & Kategori SELALU terkirim
    // ke Flutter, tidak peduli lewat controller mana.
    // =================================================================
    protected $with = ['user', 'kategoriProduk'];

    /**
     * KOLOM YANG BOLEH DIISI (Mass Assignment)
     */
    protected $fillable = [
        'user_id',            // ID Petani
        'kategori_produk_id', // ID Kategori
        'nama_produk',
        'deskripsi',
        'harga',
        'stok',
        'foto_produk',
    ];

    /**
     * Relasi Many-to-One: Satu Produk dimiliki oleh satu User (Petani)
     */
    public function user(): BelongsTo
    {
        // Pastikan foreign key-nya benar 'user_id'
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi Many-to-One: Satu Produk dimiliki oleh satu Kategori Produk
     */
    public function kategoriProduk(): BelongsTo
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_produk_id');
    }

    /**
     * Relasi One-to-Many: Satu Produk bisa ada di banyak Detail Pesanan
     */
    public function detailPesanan(): HasMany
    {
        return $this->hasMany(DetailPesanan::class);
    }
}