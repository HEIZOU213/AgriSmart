<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bibit extends Model
{
    protected $table = 'bibit';
    protected $guarded = [];
    protected $casts = ['tanggal_semai' => 'date'];

    public function user() { return $this->belongsTo(User::class); }
    public function pengadaan() { return $this->hasMany(PengadaanBibit::class); }
    public function jadwal() { return $this->hasMany(JadwalPerawatanBibit::class); }
    public function monitoring() { return $this->hasMany(MonitoringBibit::class); }
    
    // Relasi ke pohon (setelah ditanam)
    public function pohon() { return $this->hasMany(PohonDurian::class, 'bibit_id'); }
}
