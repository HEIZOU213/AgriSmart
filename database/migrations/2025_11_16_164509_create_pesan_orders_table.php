<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesan_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ID Pengirim
            $table->text('body'); // Isi pesan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesan_orders');
    }
};