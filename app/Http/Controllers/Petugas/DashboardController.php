<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Show petugas dashboard
     */
    public function index()
    {
        return view('petugas.dashboard');
    }
}
