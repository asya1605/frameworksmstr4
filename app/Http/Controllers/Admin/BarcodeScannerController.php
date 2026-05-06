<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Http\Controllers\Controller;

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
     * Ambil data barang berdasarkan id_barang
     */
    public function getBarang(Request $request)
    {
        $id_barang = $request->id_barang;
        
        $barang = Barang::where('id_barang', $id_barang)->first();

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

        return response()->json([
            'success' => false,
            'message' => 'Data barang tidak ditemukan'
        ], 404);
    }
}
