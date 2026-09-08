<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('lahan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nama_lahan', 150);
            $table->decimal('luas_ha', 10, 2)->default(0);
            $table->string('lokasi', 300)->nullable();
            $table->enum('kondisi', ['baik','sedang','buruk'])->default('baik');
            $table->integer('jumlah_pohon')->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('lahan'); }
};
