<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class WeekEmpat extends Controller
{
    public function index()
    {
        return view('admin.week4.index');
    }

    public function submit(Request $req)
    {
        $data = $req->post('name');

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Data received successfully',
            'data' => [
                'name' => $data
            ]
        ]);
    }

    public function wilayah()
    {
        $provinces = DB::table('provinces')->get();

        return view('admin.week4.wilayah', compact('provinces'));
    }

    public function wilayahAxios()
    {
        $provinces = DB::table('provinces')->get();

        return view('admin.week4.wilayah_axios', compact('provinces'));
    }

    public function getCities(Request $request)
    {
        $cities = DB::table('regencies')
            ->where('province_id', $request->province_id)
            ->get();

        return response()->json($cities);
    }

    public function getDistricts(Request $request)
    {
        $districts = DB::table('districts')
            ->where('regency_id', $request->city_id)
            ->get();

        return response()->json($districts);
    }

    public function getVillages(Request $request)
    {
        $villages = DB::table('villages')
            ->where('district_id', $request->district_id)
            ->get();

        return response()->json($villages);
    }

    public function pos()
    {
        $barang = DB::table('barang')->get();

        return view('admin.week4.pos', compact('barang'));
    }

    public function posAxios()
    {
        $barang = DB::table('barang')->get();

        return view('admin.week4.posAxios', compact('barang'));
    }

    public function findBarang(Request $request)
    {
        $barang = DB::table('barang')
            ->where('id_barang', $request->kode)
            ->first();

        if ($barang) {
            return response()->json([
                'status' => 'success',
                'data' => $barang
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Barang tidak ditemukan'
            ]);
        }
    }

    public function bayar(Request $request)
    {
        $penjualan = DB::table('penjualan')->insertGetId([
            'total' => $request->total,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        foreach ($request->items as $item) {
            DB::table('penjualan_detail')->insert([
                'penjualan_id' => $penjualan,
                'kode_barang' => $item['kode'],
                'nama_barang' => $item['nama'],
                'harga' => $item['harga'],
                'jumlah' => $item['jumlah'],
                'subtotal' => $item['subtotal']
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Transaksi berhasil disimpan'
        ]);
    }

    public function searchBarang(Request $request)
    {
        $keyword = $request->keyword;

        $barang = DB::table('barang')
            ->where('id_barang', 'like', "%$keyword%")
            ->orWhere('nama', 'like', "%$keyword%")
            ->limit(10)
            ->get();

        return response()->json($barang);
    }
}