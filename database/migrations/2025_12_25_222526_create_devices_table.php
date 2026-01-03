<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number')->unique(); // Kode unik alat (misal: AGRI-001)
            $table->string('pin_code'); // Kode rahasia (misal: 123456)
            $table->string('name')->nullable(); // Nama kebun (diisi petani)
            $table->string('mode')->default('AUTO'); // AUTO atau MANUAL
            $table->boolean('is_pump_on')->default(false); // Status pompa tombol web
            $table->foreignId('user_id')->nullable()->constrained('users'); // Pemilik alat
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
