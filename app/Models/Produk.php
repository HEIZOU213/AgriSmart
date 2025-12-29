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

    /**
     * KOLOM YANG BOLEH DIISI (Mass Assignment)
     * Tambahkan ini agar data bisa disimpan controller
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
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi Many-to-One: Satu Produk dimiliki oleh satu Kategori Produk
     */
    public function kategoriProduk(): BelongsTo
    {
        return $this->belongsTo(KategoriProduk::class);
    }

    /**
     * Relasi One-to-Many: Satu Produk bisa ada di banyak Detail Pesanan
     */
    public function detailPesanan(): HasMany
    {
        return $this->hasMany(DetailPesanan::class);
    }
}