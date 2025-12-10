<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        // Mengarah ke file: resources/views/tentang/index.blade.php
        // Penulisan view menggunakan tanda titik (.) sebagai pemisah folder
        return view('tentang.index');
    }
}