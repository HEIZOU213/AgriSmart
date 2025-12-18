<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Ini fungsi yang dicari route Anda tadi
    public function cekNotifikasi()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Notifikasi Admin'
        ]);
    }

    // Jika ada fungsi index dashboard, tambahkan juga
    public function index()
    {
        return view('admin.dashboard'); // Sesuaikan dengan nama view Anda
    }
}