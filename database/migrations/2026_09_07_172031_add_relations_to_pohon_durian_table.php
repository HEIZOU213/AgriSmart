<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('pohon_durian', function (Blueprint $table) {
            $table->foreignId('lahan_id')->nullable()->constrained('lahan')->nullOnDelete();
            $table->foreignId('bibit_id')->nullable()->constrained('bibit')->nullOnDelete();
        });
    }
    public function down(): void {
        Schema::table('pohon_durian', function (Blueprint $table) {
            $table->dropForeign(['lahan_id']);
            $table->dropColumn('lahan_id');
            $table->dropForeign(['bibit_id']);
            $table->dropColumn('bibit_id');
        });
    }
};
