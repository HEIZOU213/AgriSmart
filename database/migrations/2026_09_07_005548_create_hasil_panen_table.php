<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('hasil_panen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lahan_id')->nullable()->constrained('lahan')->nullOnDelete();
            $table->string('varietas', 100);
            $table->decimal('jumlah_kg', 10, 2)->default(0);
            $table->decimal('harga_per_kg', 12, 2)->nullable();
            $table->date('tanggal_panen');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('hasil_panen'); }
};
