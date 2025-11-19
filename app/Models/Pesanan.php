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
     *
     * @var string
     */
    protected $table = 'pesanan';

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
}