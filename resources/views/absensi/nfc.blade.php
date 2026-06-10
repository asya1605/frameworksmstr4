@extends('master')

@section('title', 'Scanner Absensi NFC')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <h3 class="page-title mb-0 text-primary font-weight-bold">
        <i class="mdi mdi-nfc menu-icon me-2"></i>Scanner Absensi NFC
    </h3>
    <span class="badge bg-light text-muted border px-3 py-2 font-weight-medium rounded-pill">
        <i class="mdi mdi-calendar-today text-primary me-1"></i> Hari Ini: <span id="currentDate"></span>
    </span>
</div>

<div class="row">
    <!-- LEFT SIDE: NFC SCANNER CARD -->
    <div class="col-lg-5 col-md-12 mb-4">
        <div class="card glass-card border-0 shadow-lg h-100 overflow-hidden">
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                
                <div>
                    <h4 class="card-title font-weight-bold text-dark mb-3">Panel Scanner</h4>
                    <p class="text-muted text-small mb-4">Dekatkan kartu atau tag NFC Anda ke bagian belakang perangkat Android setelah mengaktifkan pemindai di bawah ini.</p>
                </div>

                <!-- Modern Interactive Scanner UI -->
                <div class="scanner-container text-center my-4 p-4 rounded-4" id="scannerVisualizer">
                    <div class="scanner-glow-circle d-flex align-items-center justify-content-center mx-auto mb-4">
                        <i class="mdi mdi-nfc text-white font-48" id="scannerIcon"></i>
                    </div>
                    <h4 class="font-weight-bold mb-1" id="scannerStatusText">Scanner Non-Aktif</h4>
                    <p class="text-muted text-small mb-0" id="scannerInstructionText">Ketuk tombol di bawah untuk mendengarkan sinyal NFC</p>
                </div>

                <div class="d-grid gap-2">
                    <button class="btn btn-gradient-purple btn-lg font-weight-bold shadow-sm" id="btnToggleScanner">
                        <i class="mdi mdi-play-circle-outline me-2"></i> Aktifkan Scanner NFC
                    </button>
                    <button class="btn btn-outline-danger btn-lg font-weight-bold d-none" id="btnStopScanner">
                        <i class="mdi mdi-stop-circle-outline me-2"></i> Matikan Scanner
                    </button>
                </div>

                <!-- Info Alert Requirements -->
                <div class="alert alert-nfc-requirements mt-4 p-3 border-0 rounded-4">
                    <div class="d-flex align-items-start">
                        <i class="mdi mdi-alert-circle-outline text-primary me-2 font-20 mt-1"></i>
                        <div>
                            <span class="font-weight-bold text-dark text-small d-block mb-1">Persyaratan Praktikum Web NFC:</span>
                            <ul class="mb-0 ps-3 text-small text-muted">
                                <li>Hanya kompatibel dengan <strong>Android Chrome</strong>.</li>
                                <li>Aplikasi harus dijalankan di <strong>HTTPS</strong> / <strong>ngrok</strong>.</li>
                                <li>Pastikan modul hardware NFC Android Anda aktif.</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- RIGHT SIDE: TODAY'S ATTENDANCE LOGS -->
    <div class="col-lg-7 col-md-12 mb-4">
        <div class="card glass-card border-0 shadow-lg h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title font-weight-bold text-dark mb-0">Riwayat Kehadiran Hari Ini</h4>
                    <span class="badge badge-gradient-primary rounded-pill font-weight-semibold" id="attendanceCount">
                        {{ $absensi->count() }} Mahasiswa
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle" id="attendanceTable">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>NIM</th>
                                <th>Nama Lengkap</th>
                                <th>Waktu Presensi</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody id="attendanceLogsList">
                            @forelse($absensi as $a)
                            <tr>
                                <td>
                                    <div class="avatar-circle bg-gradient-purple-avatar text-white d-flex align-items-center justify-content-center font-weight-bold">
                                        {{ strtoupper(substr($a->mahasiswa->nama, 0, 1)) }}
                                    </div>
                                </td>
                                <td class="font-weight-bold text-primary">{{ $a->mahasiswa->nim }}</td>
                                <td class="text-dark font-weight-semibold">{{ $a->mahasiswa->nama }}</td>
                                <td>{{ \Carbon\Carbon::parse($a->waktu_absen)->format('H:i:s') }} WIB</td>
                                <td class="text-center">
                                    <span class="badge badge-success-presensi">Hadir</span>
                                </td>
                            </tr>
                            @empty
                            <tr id="emptyRow">
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="mdi mdi-account-off-outline font-48 d-block mb-2 text-secondary"></i>
                                    Belum ada absensi terekam hari ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Styling Premium Glassmorphism & NFC */
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border-radius: 20px;
    }
    .alert-nfc-requirements {
        background: rgba(124, 58, 237, 0.06);
        border: 1px dashed rgba(124, 58, 237, 0.25) !important;
    }
    .font-20 {
        font-size: 20px;
    }
    .font-48 {
        font-size: 48px;
    }
    .text-small {
        font-size: 12.5px;
    }
    
    /* Scanner Visualizer CSS */
    .scanner-container {
        background: #f8fafc;
        border: 2px dashed #cbd5e1;
        transition: all 0.4s ease;
    }
    .scanner-glow-circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: #94a3b8;
        box-shadow: 0 0 0 0 rgba(148, 163, 184, 0.4);
        transition: all 0.4s ease;
    }

    /* Active Scanner Animation States */
    .scanner-active {
        background: rgba(124, 58, 237, 0.04) !important;
        border-color: #7c3aed !important;
    }
    .scanner-active .scanner-glow-circle {
        background: #7c3aed !important;
        animation: pulse-ring 1.8s infinite;
    }
    .scanner-active h4 {
        color: #7c3aed !important;
    }

    /* Error / Rejected Card Animation States */
    .scanner-error {
        background: rgba(239, 68, 68, 0.04) !important;
        border-color: #ef4444 !important;
        animation: shake 0.4s ease;
    }
    .scanner-error .scanner-glow-circle {
        background: #ef4444 !important;
        box-shadow: 0 0 15px rgba(239, 68, 68, 0.5) !important;
    }
    .scanner-error h4 {
        color: #ef4444 !important;
    }

    /* Success Card Animation States */
    .scanner-success {
        background: rgba(16, 185, 129, 0.04) !important;
        border-color: #10b981 !important;
    }
    .scanner-success .scanner-glow-circle {
        background: #10b981 !important;
        box-shadow: 0 0 15px rgba(16, 185, 129, 0.5) !important;
    }
    .scanner-success h4 {
        color: #10b981 !important;
    }

    /* Custom Animations */
    @keyframes pulse-ring {
        0% {
            box-shadow: 0 0 0 0 rgba(124, 58, 237, 0.6);
        }
        70% {
            box-shadow: 0 0 0 25px rgba(124, 58, 237, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(124, 58, 237, 0);
        }
    }
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-8px); }
        75% { transform: translateX(8px); }
    }

    /* Buttons */
    .btn-gradient-purple {
        background: linear-gradient(135deg, #7c3aed, #9333ea);
        color: white;
        border: none;
        transition: all 0.3s;
    }
    .btn-gradient-purple:hover {
        background: linear-gradient(135deg, #6d28d9, #7c3aed);
        color: white;
        box-shadow: 0 6px 16px rgba(124, 58, 237, 0.3);
    }

    /* Avatar Circles */
    .avatar-circle {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        font-size: 14px;
    }
    .bg-gradient-purple-avatar {
        background: linear-gradient(135deg, #a78bfa, #7c3aed);
    }
    .badge-gradient-primary {
        background: linear-gradient(135deg, #7c3aed, #9333ea);
        color: white;
        padding: 6px 14px;
        font-size: 13px;
    }
    .badge-success-presensi {
        background: rgba(16, 185, 129, 0.12);
        color: #10b981;
        padding: 5px 12px;
        border-radius: 30px;
        font-weight: bold;
        font-size: 12px;
    }
</style>

<script>
$(document).ready(function() {
    // Tampilkan Tanggal Hari Ini
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    $('#currentDate').text(new Date().toLocaleDateString('id-ID', options));

    let nfcController = null; // Menyimpan instance AbortController untuk membatalkan scan NFC

    // Tombol Aktifkan Scanner NFC diklik
    $('#btnToggleScanner').click(async function() {
        // 1. Validasi Web NFC API compatibility
        if (!('NDEFReader' in window)) {
            Swal.fire({
                icon: 'warning',
                title: 'Browser Tidak Mendukung Web NFC',
                html: 'Fitur NFC hanya tersedia di <strong>Android Chrome</strong> dengan koneksi aman <strong>HTTPS / ngrok</strong>.',
                confirmButtonColor: '#7c3aed'
            });
            return;
        }

        // Tampilkan State UI Scanner Active
        setScannerUIState('active', 'Mendengarkan Kartu NFC...', 'Tempelkan kartu presensi Anda pada sensor NFC perangkat.');
        
        $('#btnToggleScanner').addClass('d-none');
        $('#btnStopScanner').removeClass('d-none');

        // Batal scan sebelumnya jika ada
        cancelNfcScan();

        nfcController = new AbortController();
        const { signal } = nfcController;

        try {
            const ndef = new NDEFReader();
            await ndef.scan({ signal });
            
            console.log("NDEFReader: Continuous swipe scan started.");

            ndef.onreadingerror = () => {
                playErrorSound();
                setScannerUIState('error', 'Gagal Membaca Kartu', 'Silakan tempelkan ulang kartu presensi Anda.');
                setTimeout(() => {
                    if (nfcController) {
                        setScannerUIState('active', 'Mendengarkan Kartu NFC...', 'Tempelkan kartu presensi Anda pada sensor NFC perangkat.');
                    }
                }, 2000);
            };

            ndef.onreading = async ({ message, serialNumber }) => {
                console.log(`NDEFReader: Card Swiped! Serial: ${serialNumber}`);
                
                // Beep digital audio
                playBeepSound();

                // Ubah status UI ke loading/success sementara
                setScannerUIState('success', 'Membaca Kartu...', `Serial: ${serialNumber}`);

                // Kirim AJAX POST
                $.ajax({
                    url: '/absensi-nfc/store',
                    type: 'POST',
                    data: {
                        serial_number: serialNumber,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        setScannerUIState('success', 'Absensi Berhasil!', response.mahasiswa.nama);
                        
                        // SweetAlert Success
                        Swal.fire({
                            icon: 'success',
                            title: 'Absensi Diterima!',
                            html: `<strong>${response.mahasiswa.nama}</strong><br>NIM: ${response.mahasiswa.nim}<br><small class="text-muted">${response.waktu_absen}</small>`,
                            timer: 2000,
                            showConfirmButton: false
                        });

                        // Perbarui data tabel & counter
                        fetchTodayAttendance();

                        // Kembalikan ke state active setelah 2 detik
                        setTimeout(() => {
                            if (nfcController) {
                                setScannerUIState('active', 'Mendengarkan Kartu NFC...', 'Tempelkan kartu presensi Anda pada sensor NFC perangkat.');
                            }
                        }, 2000);
                    },
                    error: function(xhr) {
                        playErrorSound();
                        
                        let msg = 'Kartu tidak terdaftar';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }

                        setScannerUIState('error', 'Gagal Presensi', msg);

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: msg,
                            timer: 2500,
                            showConfirmButton: false
                        });

                        // Kembalikan ke state active setelah 2.5 detik
                        setTimeout(() => {
                            if (nfcController) {
                                setScannerUIState('active', 'Mendengarkan Kartu NFC...', 'Tempelkan kartu presensi Anda pada sensor NFC perangkat.');
                            }
                        }, 2500);
                    }
                });
            };

        } catch (error) {
            console.error("NFC Scan Error: ", error);
            
            // Matikan state scanner
            stopNfcScanner();

            let errorAlertMsg = 'Gagal mengaktifkan scanner NFC.';
            if (error.name === 'NotAllowedError') {
                errorAlertMsg = 'Izin akses NFC ditolak oleh perangkat/pengguna.';
            } else if (error.name === 'NotSupportedError') {
                errorAlertMsg = 'Fitur NFC tidak didukung pada perangkat ini.';
            }

            Swal.fire({
                icon: 'error',
                title: 'Gagal Scan NFC',
                text: errorAlertMsg,
                confirmButtonColor: '#7c3aed'
            });
        }
    });

    // Tombol Matikan Scanner diklik
    $('#btnStopScanner').click(function() {
        stopNfcScanner();
    });

    function stopNfcScanner() {
        cancelNfcScan();
        setScannerUIState('inactive', 'Scanner Non-Aktif', 'Ketuk tombol di bawah untuk mendengarkan sinyal NFC');
        $('#btnStopScanner').addClass('d-none');
        $('#btnToggleScanner').removeClass('d-none');
    }

    function cancelNfcScan() {
        if (nfcController) {
            nfcController.abort();
            nfcController = null;
            console.log("NDEFReader: Continuous swipe scan aborted.");
        }
    }

    // Mengubah Visual & Teks Status Panel Scanner NFC
    function setScannerUIState(state, statusText, instructionText) {
        const visualizer = $('#scannerVisualizer');
        const icon = $('#scannerIcon');
        
        visualizer.removeClass('scanner-active scanner-success scanner-error');
        icon.removeClass('mdi-nfc mdi-sync mdi-check-circle-outline mdi-alert-circle-outline pulse-icon');

        $('#scannerStatusText').text(statusText);
        $('#scannerInstructionText').text(instructionText);

        if (state === 'active') {
            visualizer.addClass('scanner-active');
            icon.addClass('mdi-nfc pulse-icon');
        } else if (state === 'success') {
            visualizer.addClass('scanner-success');
            icon.addClass('mdi-check-circle-outline');
        } else if (state === 'error') {
            visualizer.addClass('scanner-error');
            icon.addClass('mdi-alert-circle-outline');
        } else {
            // inactive
            icon.addClass('mdi-nfc');
        }
    }

    // Refresh Table Kehadiran via AJAX
    function fetchTodayAttendance() {
        $.ajax({
            url: '/absensi-nfc',
            type: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                // Parse HTML response atau data JSON
                // Karena index() me-return blade view, kita ambil body tabel & counter dari respons
                const newHtml = $(response).find('#attendanceLogsList').html();
                const newCount = $(response).find('#attendanceCount').text();

                $('#attendanceLogsList').html(newHtml);
                $('#attendanceCount').text(newCount);
            },
            error: function(err) {
                console.error("Gagal memperbarui riwayat absensi: ", err);
            }
        });
    }

    // Beep Nada Sukses menggunakan Web Audio API (tidak perlu file statis)
    function playBeepSound() {
        try {
            const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioCtx.createOscillator();
            const gainNode = audioCtx.createGain();

            oscillator.connect(gainNode);
            gainNode.connect(audioCtx.destination);

            oscillator.type = 'sine';
            oscillator.frequency.setValueAtTime(880, audioCtx.currentTime); // Nada Tinggi (A5)
            gainNode.gain.setValueAtTime(0.1, audioCtx.currentTime);
            
            oscillator.start();
            gainNode.gain.exponentialRampToValueAtTime(0.00001, audioCtx.currentTime + 0.12);
            oscillator.stop(audioCtx.currentTime + 0.12);
        } catch (err) {
            console.warn("Web Audio API not supported/blocked: ", err);
        }
    }

    // Beep Nada Gagal menggunakan Web Audio API
    function playErrorSound() {
        try {
            const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioCtx.createOscillator();
            const gainNode = audioCtx.createGain();

            oscillator.connect(gainNode);
            gainNode.connect(audioCtx.destination);

            oscillator.type = 'sawtooth';
            oscillator.frequency.setValueAtTime(220, audioCtx.currentTime); // Nada Rendah (A3)
            gainNode.gain.setValueAtTime(0.12, audioCtx.currentTime);
            
            oscillator.start();
            gainNode.gain.exponentialRampToValueAtTime(0.00001, audioCtx.currentTime + 0.25);
            oscillator.stop(audioCtx.currentTime + 0.25);
        } catch (err) {
            console.warn("Web Audio API error: ", err);
        }
    }
});
</script>
@endsection
