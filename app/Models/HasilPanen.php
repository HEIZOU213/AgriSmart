<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilPanen extends Model
{
    protected $table = 'hasil_panen';
    protected $fillable = ['user_id', 'lahan_id', 'pohon_id', 'varietas', 'jumlah_kg', 'harga_per_kg', 'tanggal_panen', 'catatan'];
    protected $casts = ['tanggal_panen' => 'date'];

    public function user() { return $this->belongsTo(User::class); }
    public function lahan() { return $this->belongsTo(Lahan::class); }
    public function pohon() { return $this->belongsTo(PohonDurian::class, 'pohon_id'); }
}
