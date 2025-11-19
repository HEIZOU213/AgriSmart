<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KontenEdukasi extends Model
{
    use HasFactory;

    /**
     * Menentukan nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'konten_edukasi';

    /**
     * Relasi Many-to-One: Satu Konten Edukasi dimiliki oleh satu User (Admin)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi Many-to-One: Satu Konten Edukasi dimiliki oleh satu Kategori Edukasi
     */
    public function kategoriEdukasi(): BelongsTo
    {
        return $this->belongsTo(KategoriEdukasi::class);
    }
}