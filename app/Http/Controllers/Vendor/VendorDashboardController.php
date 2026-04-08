<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorDashboardController extends Controller
{
    public function index()
    {
        $vendor = DB::table('vendor')
            ->where('iduser', Auth::id())
            ->first();

        $totalMenu = DB::table('menu')
            ->where('idvendor',$vendor->idvendor)
            ->count();

        $totalOrder = DB::table('pesanan')
            ->join('detail_pesanan','pesanan.idpesanan','=','detail_pesanan.idpesanan')
            ->join('menu','menu.idmenu','=','detail_pesanan.idmenu')
            ->where('menu.idvendor',$vendor->idvendor)
            ->distinct('pesanan.idpesanan')
            ->count();
        
        $menuTerlaris = DB::table('detail_pesanan')
            ->join('menu','menu.idmenu','=','detail_pesanan.idmenu')
            ->where('menu.idvendor',$vendor->idvendor)
            ->select(
                'menu.nama_menu',
                DB::raw('SUM(detail_pesanan.jumlah) as total_terjual')
            )
            ->groupBy('menu.nama_menu')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        $totalPendapatan = DB::table('detail_pesanan')
            ->join('menu','menu.idmenu','=','detail_pesanan.idmenu')
            ->where('menu.idvendor',$vendor->idvendor)
            ->sum('detail_pesanan.subtotal');

        $penjualanHariIni = DB::table('detail_pesanan')
            ->join('menu','menu.idmenu','=','detail_pesanan.idmenu')
            ->join('pesanan','pesanan.idpesanan','=','detail_pesanan.idpesanan')
            ->where('menu.idvendor',$vendor->idvendor)
            ->whereDate('pesanan.created_at', now())
            ->sum('detail_pesanan.subtotal');

        return view('vendor.dashboard',compact(
            'totalMenu',
            'totalOrder',
            'totalPendapatan',
            'penjualanHariIni'
        ));
    }
}