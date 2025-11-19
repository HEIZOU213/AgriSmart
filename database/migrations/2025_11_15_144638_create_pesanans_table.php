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
        // Perintah untuk MEMBUAT tabel 'pesanan'
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id(); // Primary Key 'id'

            // Foreign Key (FK) untuk pembeli (Konsumen)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('kode_pesanan')->unique(); // Kode unik cth: INV/2025/001
            $table->decimal('total_harga', 10, 2); // Total tagihan pesanan
            $table->text('alamat_kirim'); // Alamat pengiriman (dicopy saat checkout)
            
            // Status untuk melacak proses pesanan
            $table->enum('status', ['pending', 'paid', 'shipping', 'done', 'cancelled'])
                  ->default('pending');
            
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Perintah untuk MENGHAPUS tabel
        Schema::dropIfExists('pesanan');
    }
};