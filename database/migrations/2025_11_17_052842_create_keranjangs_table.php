<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keranjangs', function (Blueprint $table) {
            $table->id();
            // Hubungkan keranjang dengan User
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Hubungkan keranjang dengan Produk
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            
            $table->integer('jumlah')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keranjangs');
    }
};