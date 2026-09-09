<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class JadwalPerawatanBibit extends Model {
    protected $table = 'jadwal_perawatan_bibit';
    protected $fillable = ['user_id','bibit_id','jenis_perawatan','tanggal_jadwal','status','catatan'];
    protected $casts = ['tanggal_jadwal' => 'date'];
    public function user() { return $this->belongsTo(User::class); }
    public function bibit() { return $this->belongsTo(Bibit::class); }
}
