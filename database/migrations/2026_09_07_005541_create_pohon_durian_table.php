<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pohon_durian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('kode_pohon', 50)->unique();
            $table->string('nama_varietas', 100);
            $table->string('lokasi', 200)->nullable();
            $table->enum('fase', ['bibit','vegetatif','generatif','produktif'])->default('bibit');
            $table->enum('kondisi', ['sehat','perawatan','bermasalah'])->default('sehat');
            $table->date('tanggal_tanam')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('pohon_durian'); }
};
