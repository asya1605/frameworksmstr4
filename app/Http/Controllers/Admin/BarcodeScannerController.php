<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class BarcodeScannerController extends Controller
{
    /**
     * Tampilkan halaman scanner
     */
    public function index()
    {
        return view('admin.scanner.index');
    }

    /**
     * Ambil data barang berdasarkan hasil scan barcode
     */
    public function getBarang(Request $request)
    {
        // Ambil hasil scan lalu hapus spasi / enter
        $id_barang = trim($request->id_barang);

        // Simpan log hasil scan
        Log::info('HASIL SCAN BARCODE: ' . $id_barang);

        // Cari barang berdasarkan id_barang
        $barang = Barang::where('id_barang', 'LIKE', '%' . $id_barang . '%')->first();

        // Jika barang ditemukan
        if ($barang) {

            return response()->json([
                'success' => true,
                'data' => [
                    'id_barang' => $barang->id_barang,
                    'nama' => $barang->nama,
                    'harga' => number_format($barang->harga, 0, ',', '.')
                ]
            ]);

        }

        // Jika barang tidak ditemukan
        return response()->json([
            'success' => false,
            'message' => 'Barang dengan ID ' . $id_barang . ' tidak ditemukan di database.'
        ], 404);
    }
}