<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Perintah untuk MENGUBAH tabel 'users'
        Schema::table('users', function (Blueprint $table) {
            // Sesuai ERD, kita tambahkan 3 kolom baru
            $table->enum('role', ['petani', 'konsumen', 'admin'])->default('konsumen')->after('password');
            $table->string('no_telepon')->nullable()->after('role');
            $table->text('alamat')->nullable()->after('no_telepon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Perintah untuk MENGHAPUS kolom jika migrasi di-rollback
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('no_telepon');
            $table->dropColumn('alamat');
        });
    }
};