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
        // Perintah untuk MEMBUAT tabel 'mitra'
        Schema::create('mitra', function (Blueprint $table) {
            $table->id(); // Primary Key 'id'
            $table->string('nama_lembaga'); // Nama lembaga partner
            $table->enum('tipe', ['pemerintah', 'swasta', 'lainnya'])->default('swasta');
            $table->text('deskripsi')->nullable(); // Deskripsi kerja sama, boleh kosong
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Perintah untuk MENGHAPUS tabel
        Schema::dropIfExists('mitra');
    }
};