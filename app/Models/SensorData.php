<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    use HasFactory;
    protected $fillable = ['device_id', 'moisture', 'temperature', 'humidity'];

    // --- TAMBAHKAN BAGIAN INI ---
    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}