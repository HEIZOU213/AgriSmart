<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Ubah column role dari enum ke varchar agar fleksibel dan mendukung role baru (khusus MySQL)
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(50) NOT NULL DEFAULT 'user'");
        }

        // 2. Migrasikan data existing ke role standar baru: admin, user, pekebun
        DB::statement("UPDATE users SET role = 'pekebun' WHERE role IN ('petani', 'pekebun durian')");
        DB::statement("UPDATE users SET role = 'user' WHERE role = 'konsumen'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("UPDATE users SET role = 'petani' WHERE role = 'pekebun'");
        DB::statement("UPDATE users SET role = 'konsumen' WHERE role = 'user'");
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('petani', 'konsumen', 'admin') NOT NULL DEFAULT 'konsumen'");
    }
};
