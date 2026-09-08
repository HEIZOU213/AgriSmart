<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lahan extends Model
{
    protected $table = 'lahan';
    protected $guarded = [];

    public function user() { return $this->belongsTo(User::class); }
    public function pohon() { return $this->hasMany(PohonDurian::class, 'lahan_id'); }
    public function panen() { return $this->hasMany(HasilPanen::class, 'lahan_id'); }
    public function jadwal() { return $this->hasMany(JadwalKebun::class, 'lahan_id'); }
}
