<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class StokBarang extends Model {
    protected $table = 'stok_barang';
    protected $fillable = ['user_id','nama_barang','kategori','jumlah','satuan','harga_satuan','catatan'];
    public function user() { return $this->belongsTo(User::class); }
}
