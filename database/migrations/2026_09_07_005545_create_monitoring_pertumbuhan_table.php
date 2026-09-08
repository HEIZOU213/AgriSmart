<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('monitoring_pertumbuhan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pohon_id')->constrained('pohon_durian')->cascadeOnDelete();
            $table->decimal('tinggi_cm', 8, 2)->nullable();
            $table->decimal('diameter_batang', 8, 2)->nullable();
            $table->integer('jumlah_cabang')->nullable();
            $table->enum('kondisi', ['sehat','perawatan','bermasalah'])->default('sehat');
            $table->text('catatan')->nullable();
            $table->date('tanggal');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('monitoring_pertumbuhan'); }
};
