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
        // Perintah untuk MEMBUAT tabel 'detail_pesanan'
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id(); // Primary Key 'id'

            // Foreign Key (FK) untuk pesanan
            $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade');
            
            // Foreign Key (FK) untuk produk
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');

            $table->integer('jumlah'); // Jumlah produk ini yang dibeli
            $table->decimal('harga_satuan', 10, 2); // Harga produk PADA SAAT dibeli

            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Perintah untuk MENGHAPUS tabel
        Schema::dropIfExists('detail_pesanan');
    }
};