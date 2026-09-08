<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    // Tampilkan Daftar Request
    public function index()
    {
        // Ambil data withdraw, urutkan yang pending paling atas (ANSI SQL standard)
        $requests = Withdrawal::with('user')
                              ->orderByRaw("CASE status WHEN 'pending' THEN 1 WHEN 'approved' THEN 2 WHEN 'rejected' THEN 3 ELSE 4 END")
                              ->latest()
                              ->paginate(10);

        return view('admin.withdraw.index', compact('requests'));
    }

    // Setujui Penarikan (Tandai Sudah Transfer)
    public function approve($id)
    {
        $withdraw = Withdrawal::findOrFail($id);
        
        // Hanya boleh approve jika status masih pending
        // Catatan: Saldo sudah dipotong saat user request di DompetController::store
        if ($withdraw->status == 'pending') {
            $withdraw->status = 'approved';
            $withdraw->save();

            // Notifikasi ke pekebun durian
            try {
                \App\Models\Notifikasi::create([
                    'user_id' => $withdraw->user_id,
                    'judul'   => 'Penarikan Dana Disetujui',
                    'pesan'   => 'Penarikan saldo sebesar Rp ' . number_format($withdraw->jumlah, 0, ',', '.') . ' ke rekening ' . $withdraw->nama_bank . ' (' . $withdraw->nomor_rekening . ') telah disetujui & ditransfer.',
                    'type'    => 'success',
                    'is_read' => false
                ]);
            } catch (\Exception $e) {}
            
            return back()->with('success', 'Penarikan disetujui. Pastikan Anda sudah mentransfer dananya.');
        }

        return back()->with('error', 'Permintaan ini sudah diproses sebelumnya.');
    }

    // Tolak Penarikan (Kembalikan Saldo ke Pekebun)
    public function reject($id)
    {
        $withdraw = Withdrawal::findOrFail($id);

        if ($withdraw->status == 'pending') {
            // Refund dana yang ditahan ke saldo pekebun
            $user = $withdraw->user;
            if ($user) {
                $user->increment('saldo', $withdraw->jumlah);
            }

            $withdraw->status = 'rejected';
            $withdraw->save();

            // Notifikasi ke pekebun durian
            try {
                \App\Models\Notifikasi::create([
                    'user_id' => $withdraw->user_id,
                    'judul'   => 'Penarikan Dana Ditolak',
                    'pesan'   => 'Permintaan penarikan saldo sebesar Rp ' . number_format($withdraw->jumlah, 0, ',', '.') . ' ditolak. Saldo telah dikembalikan ke akun Anda.',
                    'type'    => 'danger',
                    'is_read' => false
                ]);
            } catch (\Exception $e) {}

            return back()->with('success', 'Permintaan penarikan ditolak dan saldo telah dikembalikan ke pekebun.');
        }

        return back()->with('error', 'Permintaan ini sudah diproses sebelumnya.');
    }
}

