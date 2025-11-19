<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriEdukasi extends Model
{
    use HasFactory;

    /**
     * Menentukan nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'kategori_edukasi';

    /**
     * Relasi One-to-Many: Satu Kategori punya banyak Konten Edukasi
     */
    public function kontenEdukasi(): HasMany
    {
        return $this->hasMany(KontenEdukasi::class);
    }
}