<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE `pesanan` MODIFY COLUMN `status` VARCHAR(50) NOT NULL DEFAULT 'pending'");
        } else {
            Schema::table('pesanan', function (Blueprint $table) {
                $table->string('status', 50)->default('pending')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE `pesanan` MODIFY COLUMN `status` ENUM('pending','paid','shipping','done','cancelled') NOT NULL DEFAULT 'pending'");
        } else {
            Schema::table('pesanan', function (Blueprint $table) {
                $table->string('status', 20)->default('pending')->change();
            });
        }
    }
};
