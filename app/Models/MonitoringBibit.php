<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class MonitoringBibit extends Model {
    protected $table = 'monitoring_bibit';
    protected $fillable = ['user_id','bibit_id','tinggi_cm','kondisi','catatan','tanggal'];
    protected $casts = ['tanggal' => 'date'];
    public function user() { return $this->belongsTo(User::class); }
    public function bibit() { return $this->belongsTo(Bibit::class); }
}
