<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('monitoring_bibit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bibit_id')->constrained('bibit')->cascadeOnDelete();
            $table->decimal('tinggi_cm', 8, 2)->nullable();
            $table->enum('kondisi', ['sehat','kurang_sehat','kritis'])->default('sehat');
            $table->text('catatan')->nullable();
            $table->date('tanggal');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('monitoring_bibit'); }
};
