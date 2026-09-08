<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('stok_barang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nama_barang', 150);
            $table->string('kategori', 100)->default('Umum');
            $table->decimal('jumlah', 12, 2)->default(0);
            $table->string('satuan', 30)->default('pcs');
            $table->decimal('harga_satuan', 12, 2)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('stok_barang'); }
};
