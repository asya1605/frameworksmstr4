<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric'
        ]);

        Barang::create([
            'nama' => $request->nama,
            'harga' => $request->harga
        ]);

        return redirect()->route('barang.index');
    }

    public function edit(Barang $barang)
    {
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric'
        ]);

        $barang->update([
            'nama' => $request->nama,
            'harga' => $request->harga
        ]);

        return redirect()->route('barang.index');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect()->route('barang.index');
    }

    // 🔥 METHOD CETAK TAG HARGA
    public function cetak(Request $request)
    {
        $ids = $request->barang;
        $x = $request->x;
        $y = $request->y;

        if (!$ids) {
            return redirect()->back()->with('error', 'Pilih minimal 1 barang');
        }

        $barang = Barang::whereIn('id_barang', $ids)->get();

        // Hitung posisi mulai
        $startIndex = (($y - 1) * 5) + ($x - 1);

        $pdf = Pdf::loadView('barang.cetak', compact('barang', 'startIndex'))
                    ->setPaper('A4', 'portrait');

        return $pdf->stream('tag-harga.pdf');
    }
}