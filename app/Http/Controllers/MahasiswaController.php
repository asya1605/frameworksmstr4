<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswa = Mahasiswa::all();
        return view('mahasiswa.index', compact('mahasiswa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|unique:mahasiswas,nim',
            'nama' => 'required|string|max:255',
            'nfc_serial_number' => 'nullable|unique:mahasiswas,nfc_serial_number',
        ], [
            'nim.required' => 'NIM wajib diisi.',
            'nim.unique' => 'NIM sudah terdaftar.',
            'nama.required' => 'Nama wajib diisi.',
            'nfc_serial_number.unique' => 'NFC Serial Number sudah digunakan oleh mahasiswa lain.',
        ]);

        $mahasiswa = Mahasiswa::create([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'nfc_serial_number' => $request->nfc_serial_number,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Mahasiswa berhasil ditambahkan.',
            'data' => $mahasiswa
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $request->validate([
            'nim' => [
                'required',
                Rule::unique('mahasiswas', 'nim')->ignore($mahasiswa->idmahasiswa, 'idmahasiswa'),
            ],
            'nama' => 'required|string|max:255',
            'nfc_serial_number' => [
                'nullable',
                Rule::unique('mahasiswas', 'nfc_serial_number')->ignore($mahasiswa->idmahasiswa, 'idmahasiswa'),
            ],
        ], [
            'nim.required' => 'NIM wajib diisi.',
            'nim.unique' => 'NIM sudah terdaftar.',
            'nama.required' => 'Nama wajib diisi.',
            'nfc_serial_number.unique' => 'NFC Serial Number sudah digunakan oleh mahasiswa lain.',
        ]);

        $mahasiswa->update([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'nfc_serial_number' => $request->nfc_serial_number,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Mahasiswa berhasil diperbarui.',
            'data' => $mahasiswa
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete();

        return response()->json([
            'success' => true,
            'message' => 'Mahasiswa berhasil dihapus.'
        ]);
    }
}
