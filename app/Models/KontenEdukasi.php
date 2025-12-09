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
     * Pastikan kolom ini bisa diisi (Mass Assignment)
     * Sesuaikan dengan nama kolom di database Anda
     */
    protected $guarded = ['id']; 

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
        return $this->belongsTo(KategoriEdukasi::class, 'kategori_edukasi_id');
    }

    // ==========================================
    // TAMBAHAN: ACCESSOR UNTUK YOUTUBE
    // ==========================================

    /**
     * Mengubah URL Youtube biasa menjadi URL Embed secara otomatis.
     * Cara panggil di Blade: $konten->youtube_embed_url
     */
    public function getYoutubeEmbedUrlAttribute()
    {
        // Ambil url asli dari database
        $url = $this->url_video;

        // Jika url kosong, kembalikan null
        if (empty($url)) {
            return null;
        }

        // Regex canggih untuk menangkap ID video dari berbagai format link Youtube
        // Support: youtu.be, youtube.com/watch?v=, youtube.com/embed/, dll
        $pattern = '%^# Match any youtube URL
            (?:https?://)?  # Optional scheme. Either http or https
            (?:www\.)?      # Optional www subdomain
            (?:             # Group host alternatives
              youtu\.be/    # Either youtu.be,
            | youtube\.com  # or youtube.com
              (?:           # Group path alternatives
                /embed/     # Either /embed/
              | /v/         # or /v/
              | /watch\?v=  # or /watch\?v=
              )
            )
            ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
            $%x';

        $result = preg_match($pattern, $url, $matches);

        // Jika pola cocok, kita ambil ID-nya ($matches[1]) dan rangkai jadi link embed
        if ($result) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        // Jika bukan link youtube yang valid, kembalikan apa adanya (fallback)
        return $url;
    }
}