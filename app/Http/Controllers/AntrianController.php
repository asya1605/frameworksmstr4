<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\RiwayatAntrian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AntrianController extends Controller
{
    // === VIEWS ===
    public function customer()
    {
        $this->updateQueueSnapshot();
        return view('antrian.customer');
    }

    public function admin()
    {
        $this->updateQueueSnapshot();
        return view('antrian.admin');
    }

    public function papan()
    {
        $this->updateQueueSnapshot();
        return view('antrian.papan');
    }

    // === CACHE HELPER ===
    private function updateQueueSnapshot()
    {
        try {
            $todayStart = Carbon::today();
            
            // Get today's waiting and calling queues (very lightweight query)
            $antrians = Antrian::where('created_at', '>=', $todayStart)
                ->whereIn('status', ['menunggu', 'dipanggil'])
                ->orderByRaw("FIELD(status, 'dipanggil', 'menunggu')")
                ->orderBy('idantrian', 'asc')
                ->get();
                
            $dipanggil = $antrians->where('status', 'dipanggil')->first();
            
            // Limit waiting list to max 5 in the array to keep payload small
            $waitingList = $antrians->where('status', 'menunggu')->slice(0, 5);
            
            $list = [];
            if ($dipanggil) {
                $list[] = [
                    'idantrian' => $dipanggil->idantrian,
                    'nomor_antrian' => $dipanggil->nomor_antrian,
                    'nama' => $dipanggil->nama,
                    'status' => $dipanggil->status
                ];
            }
            foreach ($waitingList as $item) {
                $list[] = [
                    'idantrian' => $item->idantrian,
                    'nomor_antrian' => $item->nomor_antrian,
                    'nama' => $item->nama,
                    'status' => $item->status
                ];
            }

            $data = [
                'current' => $dipanggil ? $dipanggil->nomor_antrian : '---',
                'current_name' => $dipanggil ? $dipanggil->nama : 'Belum Ada',
                'list' => $list,
                'timestamp' => time()
            ];

            Cache::put('queue_snapshot', $data, 86400); // 1 day cache
            Log::info('[SSE] Queue snapshot updated successfully.', ['snapshot' => $data]);
        } catch (\Exception $e) {
            Log::error('[SSE] Error updating queue snapshot:', ['message' => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        Log::info('[STORE] 1. Request masuk.', ['payload' => $request->all()]);

        try {
            Log::info('[STORE] 2. Menjalankan validasi.');
            $request->validate(['nama' => 'required|string|max:255']);
            Log::info('[STORE] Validasi sukses.');

            Log::info('[STORE] 3. Menghitung jumlah antrian hari ini.');
            $todayStart = Carbon::today();
            $count = Antrian::where('created_at', '>=', $todayStart)->count();
            Log::info('[STORE] Jumlah antrian hari ini ditemukan.', ['count' => $count]);

            Log::info('[STORE] 4. Generate nomor antrian.');
            $nomor = 'A-' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
            Log::info('[STORE] Nomor antrian terbuat.', ['nomor' => $nomor]);

            Log::info('[STORE] 5. Membuat record Antrian baru di database.');
            $antrian = Antrian::create([
                'nomor_antrian' => $nomor,
                'nama' => $request->nama,
                'status' => 'menunggu'
            ]);
            Log::info('[STORE] Record Antrian sukses dibuat.', ['id' => $antrian->idantrian, 'nomor' => $antrian->nomor_antrian]);

            // Update queue snapshot in cache
            $this->updateQueueSnapshot();

            Log::info('[STORE] 6. Mengirim JSON response sukses.');
            return response()->json([
                'success' => true,
                'nomor' => $antrian->nomor_antrian
            ]);

        } catch (\Exception $e) {
            Log::error('[STORE] Terjadi error pada method store()', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    public function panggil($id)
    {
        $antrian = Antrian::findOrFail($id);
        $now = Carbon::now();

        $antrian->update([
            'status' => 'dipanggil',
            'called_at' => $now
        ]);

        // Insert / Update riwayat_antrian to log this transition
        RiwayatAntrian::updateOrCreate(
            ['idantrian' => $antrian->idantrian],
            [
                'nomor_antrian' => $antrian->nomor_antrian,
                'nama' => $antrian->nama,
                'status' => 'dipanggil',
                'called_at' => $now,
            ]
        );
        
        // Update queue snapshot in cache
        $this->updateQueueSnapshot();
        
        return response()->json(['success' => true]);
    }

    public function recall($id)
    {
        $antrian = Antrian::findOrFail($id);

        // Refresh snapshot with new timestamp to trigger recall on client sides
        $this->updateQueueSnapshot();

        return response()->json(['success' => true]);
    }

    public function selesai($id)
    {
        $antrian = Antrian::findOrFail($id);
        $now = Carbon::now();

        $antrian->update([
            'status' => 'selesai'
        ]);

        // Calculate service duration in seconds
        $calledAt = $antrian->called_at ? Carbon::parse($antrian->called_at) : $antrian->created_at;
        $durasi = $now->diffInSeconds($calledAt);

        // Update riwayat_antrian with finished status, finished_at, and durasi
        RiwayatAntrian::updateOrCreate(
            ['idantrian' => $antrian->idantrian],
            [
                'nomor_antrian' => $antrian->nomor_antrian,
                'nama' => $antrian->nama,
                'status' => 'selesai',
                'called_at' => $antrian->called_at,
                'finished_at' => $now,
                'durasi' => $durasi,
            ]
        );

        // Update queue snapshot in cache
        $this->updateQueueSnapshot();

        return response()->json(['success' => true]);
    }

    public function terlambat($id)
    {
        $antrian = Antrian::findOrFail($id);

        $antrian->update([
            'status' => 'terlambat'
        ]);

        // Update riwayat_antrian to log late status
        RiwayatAntrian::updateOrCreate(
            ['idantrian' => $antrian->idantrian],
            [
                'nomor_antrian' => $antrian->nomor_antrian,
                'nama' => $antrian->nama,
                'status' => 'terlambat',
                'called_at' => $antrian->called_at,
            ]
        );

        // Update queue snapshot in cache
        $this->updateQueueSnapshot();

        return response()->json(['success' => true]);
    }

    public function historyList()
    {
        // Get latest 100 history entries
        $history = RiwayatAntrian::orderBy('idriwayat', 'desc')
            ->limit(100)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $history
        ]);
    }

    // === SSE LOGIC ===
    public function stream()
    {
        if (session_id()) {
            session_write_close();
        }

        ignore_user_abort(true);

        return response()->stream(function () {
            // Seed default snapshot if cache is missing to guarantee zero DB queries inside SSE
            if (!Cache::has('queue_snapshot')) {
                Cache::put('queue_snapshot', [
                    'current' => '---',
                    'current_name' => 'Belum Ada',
                    'list' => [],
                    'timestamp' => time()
                ], 86400);
            }

            // Fetch snapshot strictly from cache only
            $data = Cache::get('queue_snapshot');

            echo "retry: 1000\n"; // Instruct browser to reconnect after 1 second
            echo "event: queue-update\n";
            echo "data: " . json_encode($data) . "\n\n";

            ob_flush();
            flush();
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache, must-revalidate',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no' // Prevent buffering
        ]);
    }
}
