<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Perintah untuk MEMBUAT tabel 'produk'
        Schema::create('produk', function (Blueprint $table) {
            $table->id(); // Primary Key 'id'

            // Foreign Key (FK) untuk penjual (Petani)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Foreign Key (FK) untuk kategori produk
            $table->foreignId('kategori_produk_id')->constrained('kategori_produk')->onDelete('cascade');

            $table->string('nama_produk'); // Nama hasil panen
            $table->text('deskripsi')->nullable(); // Deskripsi produk, boleh kosong
            $table->decimal('harga', 10, 2); // Harga, cth: 15000.00 (total 10 digit, 2 di belakang koma)
            $table->integer('stok')->default(0); // Jumlah stok, default-nya 0
            $table->string('foto_produk')->nullable(); // Path/URL ke foto, boleh kosong

            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Perintah untuk MENGHAPUS tabel
        Schema::dropIfExists('produk');
    }
};