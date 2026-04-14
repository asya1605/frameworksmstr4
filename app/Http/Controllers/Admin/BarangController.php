<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return view('admin.barang.index', compact('barang'));
    }

    public function create()
    {
        return view('admin.barang.create');
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
        return view('admin.barang.edit', compact('barang'));
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

    // CETAK TAG HARGA
public function cetak(Request $request)
{
    $ids = $request->barang;
    $x = $request->x;
    $y = $request->y;

    if (!$ids) {
        return redirect()->back()->with('error', 'Pilih minimal 1 barang');
    }

    $barang = Barang::whereIn('id_barang', $ids)->get()->values();

    // posisi mulai (dari x,y)
    $startIndex = (($y - 1) * 5) + ($x - 1);

    // total slot 1 halaman (5x8)
    $totalSlots = 40;

    // isi slot kosong dulu
    $slots = array_fill(0, $totalSlots, null);

    foreach ($barang as $i => $item) {

        $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();

        $barcode = base64_encode(
            $generator->getBarcode($item->id_barang, $generator::TYPE_CODE_128)
        );

        $slots[$startIndex + $i] = (object)[
            'id_barang' => $item->id_barang,
            'nama' => $item->nama,
            'harga' => $item->harga,
            'barcode' => $barcode
        ];
    }

    // bagi per halaman (jaga-jaga kalau lebih dari 40)
    $pages = array_chunk($slots, 40);

    $pdf = Pdf::loadView('admin.barang.cetak', compact('pages'))
        ->setPaper('A4', 'portrait');

    return $pdf->stream('tag-harga.pdf');

    }
}