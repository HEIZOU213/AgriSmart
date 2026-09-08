<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('jadwal_kebun', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lahan_id')->nullable()->constrained('lahan')->nullOnDelete();
            $table->string('jenis_aktivitas', 150);
            $table->date('tanggal');
            $table->enum('status', ['pending','selesai','batal'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('jadwal_kebun'); }
};
