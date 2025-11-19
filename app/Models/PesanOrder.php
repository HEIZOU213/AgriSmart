<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <-- Tambahkan ini

class PesanOrder extends Model
{
    use HasFactory;

    /**
     * [KODE BARU]
     * Tentukan atribut mana yang boleh diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pesanan_id',
        'user_id',
        'body',
    ];

    /**
     * [REKOMENDASI]
     * Definisikan relasi ke User (Pengirim).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * [REKOMENDASI]
     * Definisikan relasi ke Pesanan.
     */
    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class);
    }
}