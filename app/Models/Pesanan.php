<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pesanan extends Model
{
    use HasFactory;

    /**
     * Menentukan nama tabel yang terkait dengan model.
     */
    protected $table = 'pesanan'; // Pastikan nama tabel di database benar 'pesanan' atau 'pesanans'?

    /**
     * [PENTING] Daftar kolom yang boleh diisi/diupdate.
     * Tanpa ini, fitur update 'is_seen' akan ERROR.
     */
    protected $fillable = [
        'kode_pesanan',
        'user_id',
        'total_harga',
        'status',
        'bukti_pembayaran',
        'is_seen', // <--- WAJIB ADA UNTUK NOTIFIKASI
    ];

    /**
     * Relasi Many-to-One: Satu Pesanan dimiliki oleh satu User (Konsumen)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi One-to-Many: Satu Pesanan punya banyak Detail Pesanan
     */
    public function detailPesanan(): HasMany
    {
        return $this->hasMany(DetailPesanan::class);
    }

    /**
     * Relasi ke Chat (PesanOrder)
     */
    public function pesanOrders()
    {
        return $this->hasMany(PesanOrder::class);
    }
}