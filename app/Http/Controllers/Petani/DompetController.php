<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Withdrawal;

class DompetController extends Controller
{
    // Halaman Dompet
    public function index()
    {
        $petani = Auth::user();
        // Ambil riwayat penarikan
        $riwayat = Withdrawal::where('user_id', $petani->id)->latest()->get();
        
        return view('petani.dompet.index', compact('petani', 'riwayat'));
    }

    // Proses Tarik Dana
    public function store(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:10000',
            'bank' => 'required|string',
            'rekening' => 'required|numeric',
        ]);

        $petani = Auth::user();

        // 1. Cek Saldo Cukup Gak?
        if ($petani->saldo < $request->jumlah) {
            return back()->with('error', 'Saldo tidak mencukupi!');
        }

        // 2. Kurangi Saldo Petani (Biar gak ditarik dobel)
        $petani->saldo -= $request->jumlah;
        $petani->save();

        // 3. Catat Request di Database
        Withdrawal::create([
            'user_id' => $petani->id,
            'jumlah' => $request->jumlah,
            'nama_bank' => $request->bank,
            'nomor_rekening' => $request->rekening,
            'status' => 'pending', // Menunggu Admin Transfer
        ]);

        return back()->with('success', 'Permintaan penarikan berhasil dikirim. Tunggu Admin transfer ya!');
    }
}