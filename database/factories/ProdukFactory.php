<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Membuat data palsu
            'nama_produk' => 'Panen ' . fake()->words(2, true) . ' Segar',
            'deskripsi' => fake()->paragraph(),
            'harga' => fake()->numberBetween(10000, 50000), // Harga antara 10rb - 50rb
            'stok' => fake()->numberBetween(10, 100), // Stok antara 10 - 100
            'foto_produk' => null,
            // user_id dan kategori_produk_id akan kita isi dari Seeder
        ];
    }
}