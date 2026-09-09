<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return redirect()->route('portal.index');
    }
}
