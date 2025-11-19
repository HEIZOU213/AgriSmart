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
     *
     * @var string
     */
    protected $table = 'detail_pesanan';

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
        return $this->belongsTo(Produk::class);
    }
}