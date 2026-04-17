use Illuminate\Support\Facades\DB;

public function dashboard()
{
    $totalPesanan = DB::table('pesanan')->count();
    $totalPendapatan = DB::table('pesanan')->sum('total');
    $jumlahMenu = DB::table('menu')->count();

    $pesananTerbaru = DB::table('pesanan')
        ->orderBy('id', 'desc')
        ->limit(5)
        ->get();

    return view('admin.dashboard', compact(
        'totalPesanan',
        'totalPendapatan',
        'jumlahMenu',
        'pesananTerbaru'
    ));
}