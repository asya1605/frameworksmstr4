<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Toko;
use App\Models\Kunjungan;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KunjunganController extends Controller
{
    public function index()
    {
        return view('vendor.kunjungan.index');
    }

    public function store(Request $request)
    {
        try {
            \Illuminate\Support\Facades\Log::info('REQUEST MASUK', $request->all());

            return response()->json([
                'success' => true,
                'message' => 'DEBUG BERHASIL',
                'request' => $request->all(),
                'data' => [
                    'nama_toko' => 'DEBUG TOKO',
                    'status' => 'DITERIMA',
                    'jarak' => 10,
                    'threshold_efektif' => 50
                ]
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Formula Haversine untuk menghitung jarak antara 2 koordinat (meter)
     */
    private function haversine($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // dalam meter

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }
}
