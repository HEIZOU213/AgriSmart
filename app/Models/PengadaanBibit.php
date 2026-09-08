<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PengadaanBibit extends Model {
    protected $table = 'pengadaan_bibit';
    protected $fillable = ['user_id','bibit_id','nama_supplier','nama_varietas','jumlah','harga_satuan','tanggal','catatan'];
    protected $casts = ['tanggal' => 'date'];
    public function user() { return $this->belongsTo(User::class); }
    public function bibit() { return $this->belongsTo(Bibit::class); }
}
