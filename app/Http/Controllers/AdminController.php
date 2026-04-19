<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalPesanan = DB::table('orders')->count();
        $totalPendapatan = DB::table('orders')->sum('total_price');
        $jumlahMenu = 0;

        $pesananPending = DB::table('orders')
            ->where('status', 'pending')
            ->count();

        $pesananTerbaru = DB::table('orders')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPesanan',
            'totalPendapatan',
            'jumlahMenu',
            'pesananPending',
            'pesananTerbaru'
        ));
    }
}