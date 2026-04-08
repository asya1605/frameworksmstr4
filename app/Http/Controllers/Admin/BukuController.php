<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;
use App\Http\Controllers\Controller;
class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with('kategori')->get();
        return view('admin.buku.index', compact('buku'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('admin.buku.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        Buku::create([
            'kode' => $request->kode,
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'idkategori' => $request->idkategori
        ]);

        return redirect()->route('buku.index');
    }

    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategori = Kategori::all();

        return view('admin.buku.edit', compact('buku', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $buku->update([
            'kode' => $request->kode,
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'idkategori' => $request->idkategori
        ]);

        return redirect()->route('buku.index');
    }

    public function delete($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route('buku.index');
    }
}
