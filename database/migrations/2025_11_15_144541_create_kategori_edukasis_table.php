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
        // Perintah untuk MEMBUAT tabel 'kategori_edukasi'
        Schema::create('kategori_edukasi', function (Blueprint $table) {
            $table->id(); // Ini adalah Primary Key (PK) 'id' tipe bigint
            $table->string('nama_kategori'); // Kolom 'nama_kategori' tipe varchar
            $table->string('slug')->unique(); // Kolom 'slug' tipe varchar dan harus unik
            $table->timestamps(); // Ini otomatis membuat kolom 'created_at' dan 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Perintah untuk MENGHAPUS tabel jika migrasi di-rollback
        Schema::dropIfExists('kategori_edukasi');
    }
};