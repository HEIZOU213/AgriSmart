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
        Schema::table('users', function (Blueprint $table) {
            // 1. Jadikan kolom 'password' nullable agar pengguna Socialite tanpa password bisa login.
            //    Anda mungkin perlu menginstal `doctrine/dbal` jika belum: composer require doctrine/dbal
            $table->string('password')->nullable()->change(); 
            
            // 2. Tambahkan kolom Socialite:
            $table->string('provider')->nullable()->after('password');
            $table->string('provider_id')->nullable()->index()->after('provider');
            
            // 3. (Opsional) Hapus kolom 'foto_profil' jika Socialite akan mengisi 'avatar'. 
            //    Namun, karena tabel Anda sudah ada, kita biarkan saja. 
            //    Socialite akan mengisi 'avatar' dari Google.

            // 4. (Opsional) Jika kolom foto_profil ingin Anda gunakan untuk Socialite avatar, Anda harus rename kolomnya.
            // $table->renameColumn('foto_profil', 'avatar'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom yang ditambahkan saat rollback
            $table->dropColumn(['provider', 'provider_id']);
            
            // Kembalikan kolom password ke NOT NULL (jika Anda ingin mengembalikannya)
            // Namun, jika Anda ingin mempertahankan login tradisional, biarkan password tetap nullable
            // atau pastikan Anda tahu cara mengembalikannya tanpa error.
            // $table->string('password')->default('')->change(); 
        });
    }
};