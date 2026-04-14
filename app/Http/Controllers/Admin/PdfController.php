<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Picqer\Barcode\BarcodeGeneratorPNG;
use App\Http\Controllers\Controller;

class PdfController extends Controller
{
    #Form Sertifikat
    public function formSertifikat()
    {
        return view('admin.pdf.form-sertifikat');
    }

    public function generateSertifikat(Request $request)
    {
        $request->validate([
            'nomor' => 'required',
            'nama' => 'required',
            'jabatan' => 'required',
            'acara' => 'required',
            'penyelenggara' => 'required',
            'tanggal_acara' => 'required|date',

            'label_dekan' => 'required',
            'nama_dekan' => 'required',
            'nip_dekan' => 'required',

            'label_koordinator' => 'required',
            'nama_koordinator' => 'required',
            'nip_koordinator' => 'required',

            'label_ketua' => 'required',
            'nama_ketua' => 'required',
            'nim_ketua' => 'required',
        ]);

        // Format tanggal Acara
        Carbon::setLocale('id');

        $tanggalAcara = Carbon::parse($request->tanggal_acara)
            ->translatedFormat('l, d F Y');

        $data = $request->all();
        $data['tanggal_acara'] = $tanggalAcara;

        $pdf = Pdf::loadView('admin.pdf.sertifikat', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->download('admin.sertifikat.pdf');
    }

    #Form Undangan
    public function formUndangan()
    {
        return view('admin.pdf.form-undangan');
    }

    public function generateUndangan(Request $request)
    {
        $request->validate([
            'nomor' => 'required',
            'lampiran' => 'required',
            'tanggal' => 'required|date',
            'perihal' => 'required',
            'penerima' => 'required',
            'isi' => 'required',
            'waktu' => 'required',
            'tempat' => 'required',
            'agenda' => 'required',
            'penutup' => 'required',
            'ttd_jabatan' => 'required',
            'ttd_nama' => 'required',
            'ttd_nip' => 'required',
        ]);

        // Set locale Indonesia
        Carbon::setLocale('id');

        // Format tanggal surat (kanan atas)
        $tanggalSurat = Carbon::parse($request->tanggal)
            ->translatedFormat('d F Y');

        // Format hari & tanggal acara
        $hariTanggal = Carbon::parse($request->tanggal)
            ->translatedFormat('l, d F Y');

        $data = $request->all();

        $data['tanggal'] = $tanggalSurat;
        $data['hari'] = $hariTanggal;

        // Pecah penerima jadi array
        $data['penerima'] = explode(',', $request->penerima);

        $pdf = Pdf::loadView('admin.pdf.undangan', $data)
            ->setPaper('a4', 'portrait');

        return $pdf->download('admin.undangan.pdf');
    }

    #PDF SERTIFIKAT STATIS
    public function sertifikatStatis()
    {
        $pdf = Pdf::loadView('admin.pdf.sertifikat-statis')
            ->setPaper('a4', 'landscape');

        return $pdf->download('admin.sertifikat-statis.pdf');
    }

    #PDF UNDANGAN STATIS
    public function undanganStatis()
    {
        $pdf = Pdf::loadView('admin.pdf.undangan-statis')
            ->setPaper('a4', 'portrait');

        return $pdf->download('admin.undangan-statis.pdf');
    }

    public function cetakTag(Request $request)
    {
        $startIndex = $request->start ?? 0;

        // Ambil semua data barang untuk dicetak tag harganya
        $barang = \App\Models\Barang::all();

        $generator = new BarcodeGeneratorPNG();

        foreach ($barang as $b) {
            $barcode = base64_encode(
                $generator->getBarcode($b->id_barang, $generator::TYPE_CODE_128) // Hasil barcode berupa binary, di-encode ke base64 agar bisa ditampilkan di PDF
            );

            $b->barcode = $barcode;
        }

        $pdf = Pdf::loadView('admin.barang.cetak', [
            'barang' => $barang,
            'startIndex' => $startIndex
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('tag-barang.pdf');
    }
}