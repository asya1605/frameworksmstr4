<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TokoController extends Controller
{
    public function index()
    {
        $toko = Toko::all();
        return view('admin.toko.index', compact('toko'));
    }

    public function create()
    {
        return view('admin.toko.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'barcode' => 'required|unique:toko,barcode',
            'nama_toko' => 'required',
            'alamat' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'accuracy' => 'required|numeric',
        ]);

        Toko::create($request->all());

        return redirect()->route('admin.toko.index')->with('success', 'Toko berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $toko = Toko::findOrFail($id);
        return view('admin.toko.edit', compact('toko'));
    }

    public function update(Request $request, $id)
    {
        $toko = Toko::findOrFail($id);

        $request->validate([
            'barcode' => 'required|unique:toko,barcode,' . $id . ',idtoko',
            'nama_toko' => 'required',
            'alamat' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'accuracy' => 'required|numeric',
        ]);

        $toko->update($request->all());

        return redirect()->route('admin.toko.index')->with('success', 'Toko berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $toko = Toko::findOrFail($id);
        $toko->delete();

        return redirect()->route('admin.toko.index')->with('success', 'Toko berhasil dihapus.');
    }
}
