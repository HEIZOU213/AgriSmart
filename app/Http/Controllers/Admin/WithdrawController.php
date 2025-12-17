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
        // Ambil data withdraw, urutkan yang pending paling atas
        $requests = Withdrawal::with('user')
                              ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
                              ->latest()
                              ->paginate(10);

        return view('admin.withdraw.index', compact('requests'));
    }

    // Setujui Penarikan (Tandai Sudah Transfer)
    public function approve($id)
    {
        $withdraw = Withdrawal::findOrFail($id);
        
        // Hanya boleh approve jika status masih pending
        if ($withdraw->status == 'pending') {
            $withdraw->status = 'approved';
            $withdraw->save();
            
            return back()->with('success', 'Penarikan disetujui. Pastikan Anda sudah mentransfer dananya.');
        }

        return back()->with('error', 'Permintaan ini sudah diproses sebelumnya.');
    }
}