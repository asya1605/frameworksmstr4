@extends('layouts.admin.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);">
                <div class="card-header bg-primary text-white p-4 border-0">
                    <h4 class="mb-0 d-flex align-items-center">
                        <i class="fas fa-barcode me-3"></i> Barcode Scanner
                    </h4>
                    <p class="mb-0 opacity-75 mt-1">Arahkan kamera ke barcode barang untuk memindai</p>
                </div>
                <div class="card-body p-0">
                    <!-- Scanner Container -->
                    <div id="reader" style="width: 100%; border: none; min-height: 400px; background: #000;"></div>
                    
                    <!-- Result Overlay (Initially Hidden) -->
                    <div id="scan-result-container" class="p-4 border-top" style="display: none;">
                        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center mb-4">
                            <i class="fas fa-check-circle me-3 fs-4"></i>
                            <div>
                                <strong>Berhasil!</strong> Barcode terdeteksi.
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-12">
                                <h5 class="text-muted text-uppercase small fw-bold mb-3">Informasi Barang</h5>
                                <div class="p-4 rounded-4" style="background: #f8f9fa;">
                                    <div class="row mb-3">
                                        <div class="col-4 text-muted">ID Barang:</div>
                                        <div class="col-8 fw-bold" id="res-id">-</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-4 text-muted">Nama Barang:</div>
                                        <div class="col-8 fw-bold" id="res-nama">-</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4 text-muted">Harga:</div>
                                        <div class="col-8 fw-bold text-primary fs-5" id="res-harga">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 d-grid">
                            <button id="btn-scan-again" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                                <i class="fas fa-sync me-2"></i> Scan Lagi
                            </button>
                        </div>
                    </div>

                    <!-- Loading Overlay -->
                    <div id="loading-overlay" class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-white opacity-75" style="display: none !important; z-index: 100;">
                        <div class="text-center">
                            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
                            <p class="mt-3 fw-bold">Mengambil data...</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 text-center">
                <p class="text-muted small">Praktikum 1 - Barcode Reader & Scanner</p>
            </div>
        </div>
    </div>
</div>

<!-- Audio element for Beep -->
<audio id="beep-sound" preload="auto">
    <source src="https://assets.mixkit.co/active_storage/sfx/2568/2568-preview.mp3" type="audio/mpeg">
</audio>

@endsection

@section('scripts')
<!-- Include html5-qrcode library -->
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const beepSound = document.getElementById('beep-sound');
        const reader = document.getElementById('reader');
        const resultContainer = document.getElementById('scan-result-container');
        const loadingOverlay = document.getElementById('loading-overlay');
        const btnScanAgain = document.getElementById('btn-scan-again');

        // Elements for result display
        const resId = document.getElementById('res-id');
        const resNama = document.getElementById('res-nama');
        const resHarga = document.getElementById('res-harga');

        let html5QrcodeScanner = new Html5Qrcode("reader");

        // Configuration for the scanner
        const config = { 
            fps: 10, 
            qrbox: { width: 250, height: 150 },
            aspectRatio: 1.0
        };

        const startScanner = () => {
            resultContainer.style.display = 'none';
            reader.style.display = 'block';
            
            html5QrcodeScanner.start(
                { facingMode: "environment" }, 
                config, 
                onScanSuccess,
                onScanFailure
            ).catch(err => {
                console.error("Gagal menjalankan scanner:", err);
                alert("Kamera tidak dapat diakses. Pastikan izin kamera telah diberikan.");
            });
        };

        function onScanSuccess(decodedText, decodedResult) {
            // 1. Bunyikan suara beep
            beepSound.play().catch(e => console.log("Audio play failed:", e));

            // 2. Berhenti scanning
            html5QrcodeScanner.stop().then(() => {
                reader.style.display = 'none';
                processScanResult(decodedText);
            }).catch(err => {
                console.error("Gagal menghentikan scanner:", err);
            });
        }

        function onScanFailure(error) {
            // Terjadi saat scanner sedang berjalan tapi tidak menemukan barcode
            // console.warn(`Code scan error = ${error}`);
        }

        function processScanResult(idBarang) {
            // Tampilkan loading
            loadingOverlay.style.setProperty('display', 'flex', 'important');

            // 3 & 4. Kirim id_barang ke backend menggunakan AJAX (Fetch API)
            fetch("{{ route('scanner.barcode.get') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    id_barang: idBarang
                })
            })
            .then(response => response.json())
            .then(result => {
                loadingOverlay.style.setProperty('display', 'none', 'important');
                
                if (result.success) {
                    // 5 & 6. Tampilkan hasil
                    resId.innerText = result.data.id_barang;
                    resNama.innerText = result.data.nama;
                    resHarga.innerText = "Rp " + result.data.harga;
                    
                    resultContainer.style.display = 'block';
                } else {
                    alert("Barang dengan ID " + idBarang + " tidak ditemukan di database.");
                    startScanner();
                }
            })
            .catch(error => {
                loadingOverlay.style.setProperty('display', 'none', 'important');
                console.error("Error:", error);
                alert("Terjadi kesalahan saat mengambil data barang.");
                startScanner();
            });
        }

        btnScanAgain.addEventListener('click', function() {
            startScanner();
        });

        // Jalankan scanner pertama kali
        startScanner();
    });
</script>

<style>
    /* Styling khusus untuk reader agar lebih premium */
    #reader {
        border-radius: 0 0 1rem 1rem !important;
        overflow: hidden;
    }
    #reader__scan_region {
        background: #000;
    }
    #reader__dashboard {
        padding: 20px !important;
        background: #fff !important;
    }
    #reader__camera_selection {
        padding: 8px;
        border-radius: 8px;
        border: 1px solid #ddd;
    }
    button#html5-qrcode-button-camera-start, 
    button#html5-qrcode-button-camera-stop {
        padding: 10px 20px;
        border-radius: 50px;
        border: none;
        background: #007bff;
        color: white;
        font-weight: bold;
        transition: all 0.3s;
    }
    button#html5-qrcode-button-camera-start:hover {
        background: #0056b3;
        transform: translateY(-2px);
    }
</style>
@endsection
