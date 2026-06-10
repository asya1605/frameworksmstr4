<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VendorScannerController extends Controller
{
    /**
     * Halaman scanner QR Code untuk vendor
     */
    public function index()
    {
        return view('vendor.scanner.index');
    }

    /**
     * AJAX: ambil data pesanan berdasarkan idpesanan dari QR
     */
    public function getPesanan(Request $request)
    {
        $idpesanan = $request->idpesanan;

        if (!$idpesanan) {
            return response()->json([
                'success' => false,
                'message' => 'ID Pesanan tidak valid.'
            ]);
        }

        // Ambil data pesanan utama
        $pesanan = DB::table('pesanan')
            ->where('idpesanan', $idpesanan)
            ->first();

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan dengan ID ' . $idpesanan . ' tidak ditemukan.'
            ]);
        }

        // Ambil detail item pesanan
        $detail = DB::table('detail_pesanan')
            ->join('menu', 'menu.idmenu', '=', 'detail_pesanan.idmenu')
            ->where('detail_pesanan.idpesanan', $idpesanan)
            ->select(
                'menu.nama_menu',
                'detail_pesanan.jumlah',
                'detail_pesanan.harga',
                'detail_pesanan.subtotal'
            )
            ->get();

        return response()->json([
            'success'  => true,
            'pesanan'  => [
                'idpesanan'    => $pesanan->idpesanan,
                'nama_customer'=> $pesanan->nama_customer,
                'total'        => $pesanan->total,
                'status_bayar' => $pesanan->status_bayar,
            ],
            'detail'   => $detail,
        ]);
    }
}
