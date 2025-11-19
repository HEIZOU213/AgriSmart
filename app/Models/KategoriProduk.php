<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriProduk extends Model
{
    use HasFactory;

    /**
     * Menentukan nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'kategori_produk';

    /**
     * Relasi One-to-Many: Satu Kategori punya banyak Produk
     */
    public function produk(): HasMany
    {
        return $this->hasMany(Produk::class);
    }
}