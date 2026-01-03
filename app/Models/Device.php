<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    
    // Field yang boleh diisi
    protected $fillable = ['serial_number', 'pin_code', 'name', 'user_id', 'mode', 'is_pump_on'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Relasi: Satu alat punya banyak data sensor
    public function sensorData()
    {
        return $this->hasMany(SensorData::class);
    }

    // Helper: Ambil data sensor paling baru saja
    public function latestSensorData()
    {
        return $this->hasOne(SensorData::class)->latestOfMany();
    }
}