<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            $pesanans = DB::table('pesanan')->get();
            foreach ($pesanans as $p) {
                $needsUpdate = false;
                $updateData = [];

                if (in_array($p->id, [83, 84, 85]) || empty($p->tipe_pesanan) || $p->tipe_pesanan === 'langsung') {
                    $hasDurian = DB::table('detail_pesanan')
                        ->join('produk', 'detail_pesanan.produk_id', '=', 'produk.id')
                        ->where('detail_pesanan.pesanan_id', $p->id)
                        ->where(function ($q) {
                            $q->where('produk.nama_produk', 'like', '%durian%')
                              ->orWhere('produk.kategori_produk_id', 4);
                        })
                        ->exists();

                    if ($hasDurian || in_array($p->id, [83, 84, 85])) {
                        $updateData['tipe_pesanan'] = 'booking_durian';
                        $needsUpdate = true;
                    }
                }

                if (empty($p->kwitansi_nomor)) {
                    $prefix = 'KW-' . date('Ymd', strtotime($p->created_at ?: 'now')) . '-';
                    $updateData['kwitansi_nomor'] = $prefix . str_pad($p->id, 5, '0', STR_PAD_LEFT);
                    $needsUpdate = true;
                }

                if (empty($p->kwitansi_qr_payload)) {
                    $updateData['kwitansi_qr_payload'] = 'https://agrismart.my.id/konsumen/pesanan/' . $p->id . '/kwitansi';
                    $needsUpdate = true;
                }

                if ($needsUpdate && !empty($updateData)) {
                    DB::table('pesanan')->where('id', $p->id)->update($updateData);
                }
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Migration kwitansi update notice: ' . $e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
