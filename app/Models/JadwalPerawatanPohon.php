<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class JadwalPerawatanPohon extends Model {
    protected $table = 'jadwal_perawatan_pohon';
    protected $fillable = ['user_id','pohon_id','jenis_perawatan','tanggal_jadwal','status','catatan'];
    protected $casts = ['tanggal_jadwal' => 'date'];
    public function user() { return $this->belongsTo(User::class); }
    public function pohon() { return $this->belongsTo(PohonDurian::class, 'pohon_id'); }
}
