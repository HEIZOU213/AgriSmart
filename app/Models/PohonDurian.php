<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PohonDurian extends Model
{
    protected $table = 'pohon_durian';
    protected $guarded = [];
    protected $casts = ['tanggal_tanam' => 'date'];

    public function user() { return $this->belongsTo(User::class); }
    public function monitoring() { return $this->hasMany(MonitoringPertumbuhan::class, 'pohon_id'); }
    public function jadwal() { return $this->hasMany(JadwalPerawatanPohon::class, 'pohon_id'); }
    
    // Relasi baru
    public function lahan() { return $this->belongsTo(Lahan::class, 'lahan_id'); }
    public function bibit() { return $this->belongsTo(Bibit::class, 'bibit_id'); }
    public function hasilPanen() { return $this->hasMany(HasilPanen::class, 'pohon_id'); }
}
