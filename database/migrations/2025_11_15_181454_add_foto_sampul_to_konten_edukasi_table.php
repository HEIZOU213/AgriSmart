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
        Schema::table('konten_edukasi', function (Blueprint $table) {
            // Tambahkan kolom baru untuk menyimpan path foto sampul
            $table->string('foto_sampul')->nullable()->after('url_video');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konten_edukasi', function (Blueprint $table) {
            $table->dropColumn('foto_sampul');
        });
    }
};