<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('jadwal_perawatan_bibit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bibit_id')->constrained('bibit')->cascadeOnDelete();
            $table->string('jenis_perawatan', 150);
            $table->date('tanggal_jadwal');
            $table->enum('status', ['pending','selesai','batal'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('jadwal_perawatan_bibit'); }
};
