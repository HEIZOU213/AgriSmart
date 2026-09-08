<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class BiayaOperasional extends Model {
    protected $table = 'biaya_operasional';
    protected $fillable = ['user_id','jenis_biaya','jumlah','tanggal','catatan'];
    protected $casts = ['tanggal' => 'date'];
    public function user() { return $this->belongsTo(User::class); }
}
