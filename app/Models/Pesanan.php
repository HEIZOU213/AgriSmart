<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pesanan extends Model
{
    use HasFactory;

    /**
     * Menentukan nama tabel yang terkait dengan model.
     */
    protected $table = 'pesanan'; // Pastikan nama tabel di database benar 'pesanan' atau 'pesanans'?

    /**
     * [PENTING] Daftar kolom yang boleh diisi/diupdate.
     * Tanpa ini, fitur update 'is_seen' akan ERROR.
     */
    protected $fillable = [
        'kode_pesanan',
        'user_id',
        'total_harga',
        'status',
        'bukti_pembayaran',
        'is_seen', // <--- WAJIB ADA UNTUK NOTIFIKASI

        // JANGAN LUPA DUA KOLOM INI:
        'alamat_kirim',    // <--- WAJIB ADA
        'snap_token',      // <--- WAJIB ADA (Untuk Midtrans)
        
        // Kolom tambahan dari database Anda
        'admin_fee',
        'seller_income',
        'konsumen_arsip',

        // Booking & Pelunasan Buah Durian
        'tipe_pesanan',
        'dp_amount',
        'dp_paid_at',
        'berat_aktual_kg',
        'harga_per_kg',
        'total_setelah_timbang',
        'sisa_pelunasan',
        'pelunasan_snap_token',
        'pelunasan_paid_at',
        'kwitansi_nomor',
        'kwitansi_qr_payload',
    ];

    protected $casts = [
        'dp_paid_at' => 'datetime',
        'pelunasan_paid_at' => 'datetime',
        'total_harga' => 'float',
        'dp_amount' => 'float',
        'berat_aktual_kg' => 'float',
        'harga_per_kg' => 'float',
        'total_setelah_timbang' => 'float',
        'sisa_pelunasan' => 'float',
        'admin_fee' => 'float',
        'seller_income' => 'float',
    ];

    /**
     * Relasi Many-to-One: Satu Pesanan dimiliki oleh satu User (Konsumen)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi One-to-Many: Satu Pesanan punya banyak Detail Pesanan
     */
    public function detailPesanan(): HasMany
    {
        return $this->hasMany(DetailPesanan::class);
    }

    /**
     * Relasi ke Chat (PesanOrder)
     */
    public function pesanOrders()
    {
        return $this->hasMany(PesanOrder::class);
    }

    /**
     * Cek apakah ini booking buah durian
     */
    public function isBookingDurian(): bool
    {
        return $this->tipe_pesanan === 'booking_durian' || str_starts_with($this->kode_pesanan, 'BKG-');
    }

    /**
     * Cek apakah pesanan sedang menunggu penimbangan hasil panen
     */
    public function isMenungguTimbang(): bool
    {
        return $this->isBookingDurian() && in_array($this->status, ['booked', 'menunggu_panen', 'diproses']) && is_null($this->berat_aktual_kg);
    }

    /**
     * Cek apakah pesanan sedang menunggu pelunasan setelah ditimbang
     */
    public function isMenungguPelunasan(): bool
    {
        return $this->isBookingDurian() && $this->status === 'menunggu_pelunasan';
    }

    /**
     * Cek apakah pesanan lunas
     */
    public function isLunas(): bool
    {
        return in_array($this->status, ['paid', 'selesai', 'settlement', 'success', 'dikirim']);
    }

    /**
     * Dapatkan Pekebun penjual dari pesanan ini
     */
    public function getPekebun(): ?User
    {
        $detail = $this->detailPesanan()->with('produk.user')->first();
        return $detail?->produk?->user;
    }

    /**
     * Helper URL QR Code
     */
    public function getQrCodeUrlAttribute(): string
    {
        $payload = $this->kwitansi_qr_payload ?: route('konsumen.pesanan.kwitansi', $this->id);
        return \App\Services\QrCodeService::getUrl($payload, 250);
    }

    /**
     * Helper SVG QR Code
     */
    public function getQrCodeSvgAttribute(): string
    {
        $payload = $this->kwitansi_qr_payload ?: route('konsumen.pesanan.kwitansi', $this->id);
        return \App\Services\QrCodeService::generateSvg($payload, 220);
    }

    /**
     * Generate format nomor kwitansi resmi
     */
    public function generateKwitansiNomor(): string
    {
        return 'KW-' . date('Ymd') . '-' . str_pad((string)$this->id, 5, '0', STR_PAD_LEFT);
    }
}