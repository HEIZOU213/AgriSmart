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
        // Perintah untuk MEMBUAT tabel 'konten_edukasi'
        Schema::create('konten_edukasi', function (Blueprint $table) {
            $table->id(); // Primary Key 'id'
            
            // Foreign Key (FK) untuk penulis (Admin)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Foreign Key (FK) untuk kategori
            $table->foreignId('kategori_edukasi_id')->constrained('kategori_edukasi')->onDelete('cascade');

            $table->string('judul'); // Judul artikel atau video
            $table->string('slug')->unique();
            $table->text('isi_konten'); // Isi dari artikel (tipe TEXT)
            $table->enum('tipe_konten', ['artikel', 'video'])->default('artikel');
            $table->string('url_video')->nullable(); // Boleh kosong jika tipenya artikel
            
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Perintah untuk MENGHAPUS tabel
        Schema::dropIfExists('konten_edukasi');
    }
};