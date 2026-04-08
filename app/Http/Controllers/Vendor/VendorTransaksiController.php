<?php

namespace App\Http\Controllers\Vendor;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorTransaksiController extends Controller
{
    // halaman daftar transaksi
    public function index()
    {
        $vendor = DB::table('vendor')
            ->where('iduser', Auth::id())
            ->first();

        $data = DB::table('pesanan')
            ->join('detail_pesanan','detail_pesanan.idpesanan','=','pesanan.idpesanan')
            ->join('menu','menu.idmenu','=','detail_pesanan.idmenu')
            ->where('menu.idvendor',$vendor->idvendor)
            ->select('pesanan.*')
            ->distinct()
            ->orderBy('pesanan.idpesanan','asc')
            ->get();

        return view('vendor.order.transaksi', compact('data'));
        }

        // halaman detail transaksi
    public function detail($id)
    {
        $vendor = DB::table('vendor')
            ->where('iduser', Auth::id())
            ->first();

        $pesanan = DB::table('pesanan')
            ->where('idpesanan',$id)
            ->first();

        $detail = DB::table('detail_pesanan')
            ->join('menu','menu.idmenu','=','detail_pesanan.idmenu')
            ->where('detail_pesanan.idpesanan',$id)
            ->where('menu.idvendor',$vendor->idvendor)
            ->select(
                'menu.nama_menu',
                'detail_pesanan.harga',
                'detail_pesanan.jumlah',
                'detail_pesanan.subtotal'
            )
            ->get();

        return view('vendor.order.detail',compact('pesanan','detail'));
    }
}