<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str; // Impor Str

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KontenEdukasi>
 */
class KontenEdukasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $judul = fake()->sentence(); // Buat judul palsu
        
        return [
            'judul' => $judul,
            'slug' => Str::slug($judul), // Buat slug dari judul
            'isi_konten' => fake()->paragraphs(3, true), // Buat 3 paragraf
            'tipe_konten' => 'artikel',
            'url_video' => null,
            // user_id dan kategori_edukasi_id akan kita isi dari Seeder
        ];
    }
}