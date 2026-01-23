<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketChat extends Model
{
    use HasFactory;

    // Arahkan ke tabel yang baru kita buat
    protected $table = 'market_chats';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'is_read',
        'reply_to_id', // [BARU] Wajib ada agar bisa di-save controller
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // [BARU] Relasi untuk mengambil pesan yang dibalas
    public function replyTo()
    {
        return $this->belongsTo(MarketChat::class, 'reply_to_id');
    }
}