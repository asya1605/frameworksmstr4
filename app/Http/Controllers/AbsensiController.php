<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AbsensiController extends Controller
{
    /**
     * Display NFC attendance scanner page and today's attendance logs.
     */
    public function index()
    {
        $today = Carbon::now('Asia/Jakarta')->toDateString();
        
        $absensi = Absensi::with('mahasiswa')
            ->whereDate('waktu_absen', $today)
            ->orderBy('waktu_absen', 'desc')
            ->get();

        return view('absensi.nfc', compact('absensi'));
    }

    /**
     * Store NFC attendance swipe.
     */
    public function store(Request $request)
    {
        $request->validate([
            'serial_number' => 'required|string',
        ], [
            'serial_number.required' => 'Serial number NFC wajib dikirim.',
        ]);

        $serialNumber = trim($request->serial_number);

        // Cari Mahasiswa
        $mahasiswa = Mahasiswa::where('nfc_serial_number', $serialNumber)->first();

        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Kartu tidak terdaftar'
            ], 404);
        }

        // Simpan Absensi
        $waktuAbsen = Carbon::now('Asia/Jakarta');
        
        $absensi = Absensi::create([
            'mahasiswa_id' => $mahasiswa->idmahasiswa,
            'waktu_absen' => $waktuAbsen,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil direkam!',
            'mahasiswa' => [
                'nim' => $mahasiswa->nim,
                'nama' => $mahasiswa->nama,
            ],
            'waktu_absen' => $waktuAbsen->format('d-m-Y H:i:s'),
        ]);
    }
}
