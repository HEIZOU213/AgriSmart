<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pengadaan_bibit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nama_supplier', 150);
            $table->string('nama_varietas', 100);
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 12, 2)->default(0);
            $table->date('tanggal');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('pengadaan_bibit'); }
};
