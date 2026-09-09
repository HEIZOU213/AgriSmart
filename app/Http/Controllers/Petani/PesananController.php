<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\DetailPesanan;
use App\Models\User;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Import DB untuk transaksi
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class PesananController extends Controller
{
    /**
     * Menampilkan daftar pesanan (Versi WEB)
     */
    public function index(Request $request)
    {
        $petaniId = Auth::id();

        // Query Dasar
        $query = Pesanan::whereHas('detailPesanan.produk', function($q) use ($petaniId) {
            $q->where('user_id', $petaniId);
        });

        // Filter
        if ($request->filled('filter_produk')) {
            $keyword = $request->filter_produk;
            $query->whereHas('detailPesanan.produk', function($q) use ($keyword) {
                $q->where('nama_produk', 'like', '%' . $keyword . '%');
            });
        }
        if ($request->filled('filter_tanggal')) {
            $query->whereDate('created_at', $request->filter_tanggal);
        }
        if ($request->filled('filter_status')) {
            $query->where('status', $request->filter_status);
        }

        $pesananMasuk = $query->with('user')
                              ->orderBy('created_at', 'desc')
                              ->paginate(10)
                              ->withQueryString();
                            
        return view('petani.pesanan.index', ['pesananMasuk' => $pesananMasuk]);
    }

    /**
     * Detail Pesanan (Versi WEB)
     */
    public function show(string $id)
    {
        $pesanan = Pesanan::where('id', $id)
                          ->with(['user', 'detailPesanan.produk'])
                          ->firstOrFail();

        // Tandai sudah dilihat (Pastikan kolom is_seen ada di DB)
        if ($pesanan->status == 'pending' && $pesanan->is_seen == 0) {
            $pesanan->update(['is_seen' => true]);
        }

        return view('petani.pesanan.show', [
            'pesanan' => $pesanan,
        ]);
    }

    /**
     * Update Status (Versi WEB)
     */
    public function update(Request $request, string $id)
    {
        $petaniId = Auth::id();

        // 1. Cek Kepemilikan (Security)
        $produkIds = Produk::where('user_id', $petaniId)->pluck('id');
        $orderHasPetaniProduct = DetailPesanan::where('pesanan_id', $id)
                                              ->whereIn('produk_id', $produkIds)
                                              ->exists();
        
        if (!$orderHasPetaniProduct) {
            abort(403, 'Akses Dilarang.');
        }
        
        $pesanan = Pesanan::findOrFail($id);

        // 2. Validasi Status
        if ($request->status == 'paid') {
            return back()->with('error', 'Status "Paid" hanya boleh diubah otomatis oleh Sistem.');
        }
        if ($pesanan->status == 'paid' && $request->status == 'pending') {
            return back()->with('error', 'Pesanan sudah lunas, tidak dapat dikembalikan ke pending.');
        }

        $request->validate([
            'status' => 'required|in:shipping,done,cancelled', 
        ]);

        // 3. LOGIKA POTONG SALDO & REFUND KE KONSUMEN
        if (in_array($pesanan->status, ['paid', 'shipping']) && $request->status == 'cancelled') {
            $petani = User::find($petaniId);
            if ($petani && ($pesanan->seller_income ?? 0) > 0) {
                $petani->saldo = max(0, $petani->saldo - $pesanan->seller_income);
                $petani->save();
            }

            // Refund ke saldo konsumen
            $konsumen = User::find($pesanan->user_id);
            if ($konsumen) {
                $konsumen->increment('saldo', $pesanan->total_harga);
            }
        }
        
        // 4. LOGIKA KEMBALIKAN STOK (Restock)
        if ($request->status == 'cancelled' && $pesanan->status != 'cancelled') {
             foreach ($pesanan->detailPesanan as $detail) {
                $produk = $detail->produk;
                if ($produk && $produk->user_id == $petaniId) {
                    $produk->stok = $produk->stok + $detail->jumlah;
                    $produk->save();
                }
            }
        }

        // 5. Simpan Perubahan Status
        $pesanan->status = $request->status;
        $pesanan->save();

        return redirect()->route('petani.pesanan.show', $pesanan->id)
                         ->with('success', 'Status diperbarui.');
    }

    // ----------------------------------------------------------------------
    // API (UNTUK APLIKASI FLUTTER)
    // ----------------------------------------------------------------------

    // API: Ambil Daftar Pesanan
    public function apiIndex(Request $request)
    {
        $user = $request->user();
        $productIds = Produk::where('user_id', $user->id)->pluck('id');

        if ($productIds->isEmpty()) {
            return response()->json(['success' => true, 'data' => []]);
        }

        $orders = Pesanan::whereHas('detailPesanan', function ($query) use ($productIds) {
            $query->whereIn('produk_id', $productIds);
        })
        ->with(['detailPesanan' => function ($query) use ($productIds) {
            $query->whereIn('produk_id', $productIds)->with('produk');
        }, 'user'])
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    // API: Update Status (DIPERBAIKI DENGAN NOTIFIKASI OTOMATIS)
    public function apiUpdateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:shipping,done,cancelled'
        ]);

        return DB::transaction(function () use ($request, $id) {
            $user = $request->user() ?: Auth::user();

            // Verifikasi kepemilikan: pesanan harus berisi produk milik pekebun ini
            $productIds = Produk::where('user_id', $user->id)->pluck('id');
            $orderHasProduct = DetailPesanan::where('pesanan_id', $id)
                                            ->whereIn('produk_id', $productIds)
                                            ->exists();

            if (!$orderHasProduct) {
                return response()->json(['success' => false, 'message' => 'Akses ditolak. Pesanan bukan terkait produk Anda.'], 403);
            }
            
            // Load detail pesanan, produk, DAN user pembeli
            $pesanan = Pesanan::with(['detailPesanan.produk', 'user'])->find($id);

            if (!$pesanan) {
                return response()->json(['success' => false, 'message' => 'Pesanan tidak ditemukan'], 404);
            }

            $oldStatus = $pesanan->status;
            $newStatus = $request->status;
            $pembeliId = $pesanan->user_id; // AMBIL ID PEMBELI SECARA OTOMATIS

            // 1. LOGIKA RESTOCK (Jika batal, kembalikan stok)
            if ($newStatus == 'cancelled' && $oldStatus != 'cancelled') {
                foreach ($pesanan->detailPesanan as $detail) {
                    $produk = $detail->produk;
                    if ($produk && $produk->user_id == $user->id) {
                        $produk->stok = $produk->stok + $detail->jumlah;
                        $produk->save();
                    }
                }
            }

            // 2. LOGIKA REFUND (Potong Saldo Pekebun & Kembalikan ke Konsumen)
            if (in_array($oldStatus, ['paid', 'shipping']) && $newStatus == 'cancelled') {
                $pendapatan = $pesanan->seller_income ?? 0;
                
                if ($pendapatan > 0) {
                    $petani = User::find($user->id);
                    if ($petani) {
                        $petani->saldo = max(0, $petani->saldo - $pendapatan);
                        $petani->save();
                    }
                }

                // Refund ke saldo konsumen
                $konsumen = User::find($pembeliId);
                if ($konsumen) {
                    $konsumen->increment('saldo', $pesanan->total_harga ?? 0);
                }
            }

            // 3. --- [BARU] LOGIKA KIRIM NOTIFIKASI OTOMATIS ---
            $judul = "Update Pesanan #" . ($pesanan->kode_pesanan ?? $pesanan->id);
            $pesan = "";
            $type = "info";

            if ($newStatus == 'paid') {
                $pesan = "Pesanan Anda telah DITERIMA oleh pekebun durian dan sedang diproses.";
                $type = "success";
            } elseif ($newStatus == 'shipping') {
                $pesan = "Pesanan Anda sedang DALAM PENGIRIMAN menuju alamat Anda.";
                $type = "info";
            } elseif ($newStatus == 'cancelled') {
                $pesan = "Mohon maaf, pesanan Anda DIBATALKAN oleh pekebun durian. Stok akan dikembalikan.";
                $type = "danger";
            } elseif ($newStatus == 'done') {
                $pesan = "Pesanan selesai. Terima kasih telah berbelanja!";
                $type = "success";
            }

            // Buat Notifikasi di Database (Hanya jika ada pesan status)
            if ($pesan != "") {
                Notifikasi::create([
                    'user_id' => $pembeliId, // Ini akan otomatis mengirim ke pembeli yang benar
                    'judul'   => $judul,
                    'pesan'   => $pesan,
                    'type'    => $type,
                    'is_read' => false
                ]);
            }
            // ------------------------------------------------

            $pesanan->status = $newStatus;
            $pesanan->save();

            return response()->json([
                'success' => true, 
                'message' => 'Status berhasil diubah & Notifikasi terkirim', 
                'data' => $pesanan
            ]);
        });
    }

    /**
     * Input berat timbangan buah durian setelah panen.
     * Menghitung total_setelah_timbang, sisa_pelunasan, nomor kwitansi, dan Snap token pelunasan.
     */
    public function inputTimbangan(Request $request, $id)
    {
        $petani = Auth::user();
        $produkIds = Produk::where('user_id', $petani->id)->pluck('id');
        $orderHasPetaniProduct = DetailPesanan::where('pesanan_id', $id)
            ->whereIn('produk_id', $produkIds)
            ->exists();

        if (!$orderHasPetaniProduct) {
            abort(403, 'Akses Dilarang.');
        }

        $request->validate([
            'berat_aktual_kg' => 'required|numeric|min:0.1|max:500',
        ]);

        $pesanan = Pesanan::with(['user', 'detailPesanan.produk'])->findOrFail($id);

        $berat = (float) $request->berat_aktual_kg;
        $detail = $pesanan->detailPesanan->first();
        $hargaPerKg = $pesanan->harga_per_kg ?: ($detail?->harga_satuan ?: ($detail?->produk?->harga ?: 0));
        $totalSetelahTimbang = $berat * $hargaPerKg;
        $dpAmount = $pesanan->dp_amount > 0 ? (float) $pesanan->dp_amount : min(100000.00, (float) $totalSetelahTimbang);
        $sisaPelunasan = max(0, $totalSetelahTimbang - $dpAmount);

        $kwitansiNomor = $pesanan->kwitansi_nomor ?: $pesanan->generateKwitansiNomor();
        $kwitansiPayload = route('konsumen.pesanan.kwitansi', $pesanan->id);

        // Generate Snap Token untuk pelunasan via Midtrans akun Pekebun
        $snapToken = null;
        if ($sisaPelunasan > 0) {
            if (app()->environment('testing') || empty($petani->getMidtransServerKey())) {
                $snapToken = 'MOCK-PELUNASAN-SNAP-' . Str::random(12);
            } else {
                try {
                    Config::$serverKey = $petani->getMidtransServerKey();
                    Config::$isProduction = $petani->isMidtransProduction();
                    Config::$isSanitized = true;
                    Config::$is3ds = true;

                    $params = [
                        'transaction_details' => [
                            'order_id' => 'PELUNASAN-' . $pesanan->kode_pesanan,
                            'gross_amount' => (int) $sisaPelunasan,
                        ],
                        'customer_details' => [
                            'first_name' => $pesanan->user?->name ?: 'Konsumen',
                            'email' => $pesanan->user?->email ?: 'konsumen@agrismart.id',
                        ],
                    ];
                    $snapToken = Snap::getSnapToken($params);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::warning('Pelunasan snap generation fallback: ' . $e->getMessage());
                    $snapToken = 'FALLBACK-PELUNASAN-SNAP-' . Str::random(12);
                }
            }
        }

        $pesanan->update([
            'berat_aktual_kg' => $berat,
            'harga_per_kg' => $hargaPerKg,
            'total_setelah_timbang' => $totalSetelahTimbang,
            'total_harga' => $totalSetelahTimbang,
            'sisa_pelunasan' => $sisaPelunasan,
            'kwitansi_nomor' => $kwitansiNomor,
            'kwitansi_qr_payload' => $kwitansiPayload,
            'pelunasan_snap_token' => $snapToken,
            'status' => $sisaPelunasan > 0 ? 'menunggu_pelunasan' : 'paid',
            'admin_fee' => 0,
            'seller_income' => $totalSetelahTimbang,
        ]);

        // Kirim Notifikasi ke Konsumen
        if ($pesanan->user_id) {
            $pesanNotif = $sisaPelunasan > 0 
                ? 'Buah durian pesanan #' . $pesanan->kode_pesanan . ' telah ditimbang (' . $berat . ' kg). Total: Rp ' . number_format($totalSetelahTimbang, 0, ',', '.') . '. Sisa pelunasan: Rp ' . number_format($sisaPelunasan, 0, ',', '.') . '. Silakan cek E-Kwitansi Anda.'
                : 'Buah durian pesanan #' . $pesanan->kode_pesanan . ' telah ditimbang (' . $berat . ' kg). Total: Rp ' . number_format($totalSetelahTimbang, 0, ',', '.') . '. Pembayaran LUNAS (tercover DP Rp ' . number_format($dpAmount, 0, ',', '.') . '). Silakan cek E-Kwitansi Anda.';

            Notifikasi::create([
                'user_id' => $pesanan->user_id,
                'judul'   => $sisaPelunasan > 0 ? 'Hasil Timbang Durian Siap!' : 'Hasil Timbang Durian Siap (Lunas)',
                'pesan'   => $pesanNotif,
                'type'    => 'info',
                'is_read' => false
            ]);
        }

        return redirect()->route('petani.pesanan.show', $pesanan->id)
            ->with('success', 'Hasil penimbangan berhasil disimpan! Total: Rp ' . number_format($totalSetelahTimbang, 0, ',', '.') . ' (Sisa Pelunasan: Rp ' . number_format($sisaPelunasan, 0, ',', '.') . ')');
    }

    /**
     * API: Verifikasi QR Code E-Kuitansi oleh Petani (Mobile)
     * Mengambil data pesanan asli dari DB sehingga harga 100% akurat
     */
    public function apiVerifyQr(Request $request)
    {
        $qrToken = trim($request->input('qr_token', ''));

        if (empty($qrToken)) {
            return response()->json(['success' => false, 'message' => 'QR Token tidak boleh kosong'], 400);
        }

        $kodePesanan = null;
        $orderId = null;

        // 1. Cek jika qrToken adalah JSON
        if (str_starts_with($qrToken, '{')) {
            $json = json_decode($qrToken, true);
            if (is_array($json)) {
                $kodePesanan = $json['kode_pesanan'] ?? null;
                $orderId = $json['id'] ?? $json['order_id'] ?? null;
            }
        }

        // 2. Jika qrToken adalah URL (e.g. http://.../konsumen/pesanan/5/kwitansi)
        if (preg_match('#/konsumen/pesanan/(\d+)#', $qrToken, $matches)) {
            $orderId = (int)$matches[1];
        }

        // 3. Jika qrToken adalah kode pesanan langsung (INV-..., COD-..., BKG-...)
        if (empty($kodePesanan) && empty($orderId)) {
            if (preg_match('/(INV|COD|BKG)-[A-Za-z0-9\-]+/', $qrToken, $matches)) {
                $kodePesanan = $matches[0];
            } elseif (is_numeric($qrToken)) {
                $orderId = (int)$qrToken;
            } else {
                $kodePesanan = $qrToken;
            }
        }

        // 4. Query pesanan riil dari database
        $pesanan = null;
        if (!empty($kodePesanan)) {
            $pesanan = Pesanan::with(['detailPesanan.produk', 'user'])
                ->where('kode_pesanan', $kodePesanan)
                ->orWhere('kwitansi_nomor', $kodePesanan)
                ->first();
        }

        if (!$pesanan && !empty($orderId)) {
            $pesanan = Pesanan::with(['detailPesanan.produk', 'user'])->find($orderId);
        }

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Data pesanan dengan kode QR "' . $qrToken . '" tidak ditemukan di sistem kebun.'
            ], 404);
        }

        // 5. Hitung nilai keuangan pesanan secara akurat
        $total = (double) ($pesanan->total_setelah_timbang > 0 ? $pesanan->total_setelah_timbang : $pesanan->total_harga);
        $isBooking = $pesanan->isBookingDurian();
        $isCod = str_starts_with($pesanan->kode_pesanan, 'COD');

        if ($isBooking) {
            $type = 'booking_durian';
            $dpAmount = (double) ($pesanan->dp_amount > 0 ? $pesanan->dp_amount : min(100000, $total));
            $remaining = (double) ($pesanan->sisa_pelunasan !== null ? $pesanan->sisa_pelunasan : max(0, $total - $dpAmount));
            $needsSettlement = ($remaining > 0 && !in_array($pesanan->status, ['paid', 'selesai', 'done']));
            $isDpPaid = true;
            $isFullyPaid = !$needsSettlement;
        } elseif ($isCod) {
            $type = 'ready_stock';
            $dpAmount = 0.0;
            $remaining = $total;
            $needsSettlement = !in_array($pesanan->status, ['selesai', 'done']);
            $isDpPaid = false;
            $isFullyPaid = !in_array($pesanan->status, ['selesai', 'done']);
        } else {
            $type = 'ready_stock';
            $dpAmount = $total;
            $remaining = 0.0;
            $needsSettlement = false;
            $isDpPaid = true;
            $isFullyPaid = true;
        }

        // Jika pesanan transfer ready stock dan belum done/selesai, otomatis selesaikan
        if (!$needsSettlement && !in_array($pesanan->status, ['selesai', 'done'])) {
            $pesanan->status = 'selesai';
            $pesanan->save();
        }

        return response()->json([
            'success' => true,
            'needs_settlement' => $needsSettlement,
            'remaining_balance' => $remaining,
            'total' => $total,
            'dp_amount' => $dpAmount,
            'is_cod' => $isCod,
            'type' => $type,
            'order' => [
                'id' => $pesanan->id,
                'user_id' => $pesanan->user_id,
                'kode_pesanan' => $pesanan->kode_pesanan,
                'kwitansi_nomor' => $pesanan->kwitansi_nomor,
                'type' => $type,
                'total' => $total,
                'total_harga' => $total,
                'dp_amount' => $dpAmount,
                'remaining_balance' => $remaining,
                'is_dp_paid' => $isDpPaid,
                'is_fully_paid' => $isFullyPaid,
                'payment_method' => $isCod ? 'cod' : 'transfer',
                'status' => $pesanan->status,
                'status_pesanan' => $pesanan->status,
                'status_pembayaran' => $isFullyPaid ? 'paid' : ($isDpPaid ? 'dp_paid' : 'pending_verification'),
                'alamat_kirim' => $pesanan->alamat_kirim,
                'created_at' => $pesanan->created_at ? $pesanan->created_at->toIso8601String() : date('c'),
                'qr_code_token' => $pesanan->kode_pesanan,
                'buyer_name' => $pesanan->user ? $pesanan->user->name : 'Pelanggan Durian',
                'user' => $pesanan->user ? ['name' => $pesanan->user->name, 'email' => $pesanan->user->email] : null,
                'items' => $pesanan->detailPesanan,
                'detail_pesanan' => $pesanan->detailPesanan,
            ]
        ]);
    }

    /**
     * API: Selesaikan transaksi pelunasan COD atau Booking Panen di kebun
     */
    public function apiSettleOrder(Request $request, $id)
    {
        return DB::transaction(function () use ($id) {
            $pesanan = Pesanan::with('detailPesanan.produk')->find($id);

            if (!$pesanan) {
                return response()->json(['success' => false, 'message' => 'Pesanan tidak ditemukan'], 404);
            }

            $pesanan->status = 'selesai';
            $pesanan->sisa_pelunasan = 0;
            $pesanan->save();

            // Notifikasi ke pembeli
            Notifikasi::create([
                'user_id' => $pesanan->user_id,
                'judul' => 'Pesanan #' . $pesanan->kode_pesanan . ' Telah Selesai',
                'pesan' => 'Pembayaran tunai/pelunasan telah diverifikasi oleh pekebun durian di kebun. Terima kasih telah berbelanja!',
                'type' => 'success',
                'is_read' => false,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pelunasan berhasil diverifikasi dan pesanan selesai.',
                'data' => $pesanan
            ]);
        });
    }
}


