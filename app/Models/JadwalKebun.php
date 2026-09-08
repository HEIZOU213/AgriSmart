<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class JadwalKebun extends Model {
    protected $table = 'jadwal_kebun';
    protected $fillable = ['user_id','lahan_id','jenis_aktivitas','tanggal','status','catatan'];
    protected $casts = ['tanggal' => 'date'];
    public function user() { return $this->belongsTo(User::class); }
    public function lahan() { return $this->belongsTo(Lahan::class); }
}
