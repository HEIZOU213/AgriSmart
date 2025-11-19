<?php

namespace Database\Seeders;

// Impor semua Model dan Facade yang kita butuhkan
use App\Models\User;
use App\Models\KategoriEdukasi;
use App\Models\KategoriProduk;
use App\Models\KontenEdukasi;
use App\Models\Produk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // --- 1. Buat User Penting (Admin, Petani, Konsumen) ---
        // Kita buat manual agar tahu password-nya
        
        $adminUser = User::create([
            'name' => 'Admin yanda',
            'email' => 'yanda@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // password = "password"
            'role' => 'admin',
            'no_telepon' => '081234567890',
            'alamat' => 'Kantor Pusat AgriSmart',
        ]);

        $petaniUser = User::create([
            'name' => 'Petani Budi',
            'email' => 'petani@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // password = "password"
            'role' => 'petani',
            'no_telepon' => '081200001111',
            'alamat' => 'Desa Makmur Jaya',
        ]);

        $konsumenUser = User::create([
            'name' => 'Konsumen Ani',
            'email' => 'konsumen@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // password = "password"
            'role' => 'konsumen',
            'no_telepon' => '081222223333',
            'alamat' => 'Kota Sejahtera',
        ]);

        // --- 2. Buat Kategori ---
        
        $katProduk1 = KategoriProduk::create(['nama_kategori' => 'Sayuran', 'slug' => 'sayuran']);
        $katProduk2 = KategoriProduk::create(['nama_kategori' => 'Buah-buahan', 'slug' => 'buah-buahan']);
        
        $katEdukasi1 = KategoriEdukasi::create(['nama_kategori' => 'Teknik Bertani', 'slug' => 'teknik-bertani']);
        $katEdukasi2 = KategoriEdukasi::create(['nama_kategori' => 'Wirausaha Tani', 'slug' => 'wirausaha-tani']);


        // --- 3. Buat Produk (pakai Factory) ---
        // Kita akan buat 5 produk sayuran milik Petani Budi
        Produk::factory(5)->create([
            'user_id' => $petaniUser->id,
            'kategori_produk_id' => $katProduk1->id,
        ]);

        // Kita buat 5 produk buah-buahan milik Petani Budi
        Produk::factory(5)->create([
            'user_id' => $petaniUser->id,
            'kategori_produk_id' => $katProduk2->id,
        ]);
        
        // --- 4. Buat Konten Edukasi (pakai Factory) ---
        // Kita buat 3 konten teknik bertani milik Admin
        KontenEdukasi::factory(3)->create([
            'user_id' => $adminUser->id,
            'kategori_edukasi_id' => $katEdukasi1->id,
        ]);
    }
}