<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class MonitoringPertumbuhan extends Model {
    protected $table = 'monitoring_pertumbuhan';
    protected $fillable = ['user_id','pohon_id','tinggi_cm','diameter_batang','jumlah_cabang','kondisi','catatan','tanggal'];
    protected $casts = ['tanggal' => 'date'];
    public function user() { return $this->belongsTo(User::class); }
    public function pohon() { return $this->belongsTo(PohonDurian::class, 'pohon_id'); }
}
