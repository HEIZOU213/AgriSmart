<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $guarded = [];

    // --- TAMBAHKAN KODE INI ---
    // Menghubungkan Withdrawal ke User (Petani)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}