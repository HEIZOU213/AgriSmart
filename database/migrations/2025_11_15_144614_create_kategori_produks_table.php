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
        // Perintah untuk MEMBUAT tabel 'kategori_produk'
        Schema::create('kategori_produk', function (Blueprint $table) {
            $table->id(); // Primary Key 'id'
            $table->string('nama_kategori'); // Cth: "Sayuran", "Buah", "Rempah"
            $table->string('slug')->unique(); // Cth: "sayuran", "buah"
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Perintah untuk MENGHAPUS tabel
        Schema::dropIfExists('kategori_produk');
    }
};
