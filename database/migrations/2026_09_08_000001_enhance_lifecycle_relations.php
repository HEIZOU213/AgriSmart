<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Ubah kolom status pada tabel bibit menjadi string agar mendukung status 'ditanam'
        Schema::table('bibit', function (Blueprint $table) {
            $table->string('status', 50)->default('aktif')->change();
        });

        // 2. Tambahkan foreign key pohon_id pada tabel hasil_panen
        Schema::table('hasil_panen', function (Blueprint $table) {
            $table->foreignId('pohon_id')->nullable()->after('lahan_id')->constrained('pohon_durian')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('hasil_panen', function (Blueprint $table) {
            $table->dropForeign(['pohon_id']);
            $table->dropColumn('pohon_id');
        });

        Schema::table('bibit', function (Blueprint $table) {
            $table->enum('status', ['aktif', 'perawatan', 'siap_tanam', 'mati'])->default('aktif')->change();
        });
    }
};
