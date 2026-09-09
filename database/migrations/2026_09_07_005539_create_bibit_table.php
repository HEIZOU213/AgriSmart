<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('bibit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('kode_bibit', 50)->unique();
            $table->string('nama_varietas', 100);
            $table->string('asal_benih', 200)->nullable();
            $table->integer('jumlah')->default(1);
            $table->enum('status', ['aktif','perawatan','siap_tanam','mati'])->default('aktif');
            $table->enum('kondisi', ['sehat','kurang_sehat','kritis'])->default('sehat');
            $table->date('tanggal_semai')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('bibit'); }
};
