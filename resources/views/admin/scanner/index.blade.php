@extends('layouts.admin.app')

@section('style')
<style>
    :root {
        --glass-bg: rgba(255, 255, 255, 0.1);
        --glass-border: rgba(255, 255, 255, 0.2);
        --primary-gradient: linear-gradient(135deg, #a855f7, #ec4899);
        --accent-color: #f472b6;
        --text-main: #ffffff;
        --text-sub: rgba(255, 255, 255, 0.9);
        --text-muted: #6b7280;
        --text-label: #2d3748;
        --text-dark: #1a202c;
    }

    body {
        background: radial-gradient(circle at top right, #2d1b4e, #1a1a2e);
        min-height: 100vh;
        color: var(--text-main);
        font-family: 'Outfit', 'Inter', sans-serif;
    }

    .page-header {
        background: linear-gradient(135deg, rgba(168, 85, 247, 0.2), rgba(236, 72, 153, 0.2));
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 24px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .page-header h1 {
        font-weight: 800;
        margin: 0;
        color: #ffffff;
        font-size: 2.2rem;
        letter-spacing: -1px;
        text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    .page-header p {
        color: var(--text-sub);
        margin-top: 8px;
        margin-bottom: 0;
        font-size: 1rem;
        font-weight: 500;
        opacity: 0.9 !important;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.95); /* More solid for better contrast */
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
        overflow: hidden;
    }

    /* Dark mode for scanner wrapper if needed, but the user wants readability */
    .scanner-wrapper {
        max-width: 650px;
        margin: 0 auto;
        width: 100%;
    }

    .scanner-box {
        width: 100%;
        background: #000;
        border-radius: 16px;
        overflow: hidden;
        position: relative;
        aspect-ratio: 4/3;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid rgba(0, 0, 0, 0.1);
    }

    #reader {
        width: 100% !important;
        height: 100% !important;
        border: none !important;
    }

    #reader video {
        object-fit: cover !important;
        width: 100% !important;
        height: 100% !important;
    }

    /* Remove weird html5-qrcode elements */
    #reader__dashboard, #reader__status_span, #reader img, #reader button {
        display: none !important;
    }

    .scanner-frame {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 10;
    }

    .scanner-laser {
        position: absolute;
        top: 10%;
        left: 5%;
        width: 90%;
        height: 2px;
        background: var(--primary-gradient);
        box-shadow: 0 0 15px var(--accent-color);
        animation: scan-anim 2.5s infinite ease-in-out;
        z-index: 11;
        opacity: 0.8;
    }

    @keyframes scan-anim {
        0% { top: 15%; opacity: 0; }
        20% { opacity: 1; }
        80% { opacity: 1; }
        100% { top: 85%; opacity: 0; }
    }

    .corner {
        position: absolute;
        width: 35px;
        height: 35px;
        border: 4px solid var(--accent-color);
        z-index: 12;
    }
    .corner-tl { top: 25px; left: 25px; border-right: 0; border-bottom: 0; border-top-left-radius: 12px; }
    .corner-tr { top: 25px; right: 25px; border-left: 0; border-bottom: 0; border-top-right-radius: 12px; }
    .corner-bl { bottom: 25px; left: 25px; border-right: 0; border-top: 0; border-bottom-left-radius: 12px; }
    .corner-br { bottom: 25px; right: 25px; border-left: 0; border-top: 0; border-bottom-right-radius: 12px; }

    .btn-glass {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 700;
        border-radius: 12px;
        padding: 12px 24px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(168, 85, 247, 0.4);
    }

    .btn-glass:hover {
        opacity: 0.9;
        transform: translateY(-2px);
        color: white;
    }

    .status-badge {
        padding: 8px 16px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .pulse-dot {
        width: 10px;
        height: 10px;
        background: #22c55e;
        border-radius: 50%;
        box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
    }

    .badge-active { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .badge-waiting { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }

    .result-panel {
        background: #ffffff;
        border-radius: 20px;
        padding: 24px;
        margin-top: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        animation: slideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-select-glass {
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        color: var(--text-dark);
        border-radius: 12px;
        padding: 10px 16px;
        font-size: 0.9rem;
        font-weight: 600;
        outline: none;
        cursor: pointer;
        transition: border-color 0.2s;
    }

    .form-select-glass:focus {
        border-color: #a855f7;
    }

    .form-control-glass {
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        color: var(--text-dark);
        font-weight: 600;
        border-radius: 12px;
    }

    .form-control-glass::placeholder {
        color: #94a3b8;
    }

    .progress-compact {
        height: 8px;
        background: #f1f5f9;
        border-radius: 10px;
        overflow: hidden;
    }

    .label-accent {
        color: var(--text-label);
        font-weight: 800;
        letter-spacing: 1px;
        font-size: 0.75rem;
    }

    .text-accent {
        color: #a855f7;
    }

    .x-small { font-size: 0.75rem; letter-spacing: 0.5px; }
    
    .no-icons * { font-family: 'Outfit', 'Inter', sans-serif !important; }

</style>
@endsection

@section('content')
<div class="container-fluid py-4 no-icons">
    
    <div class="page-header">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div>
                <h1 class="text-white fw-bold">Modern POS Scanner</h1>
                <p class="text-white opacity-90 fw-medium">High-performance barcode & QR detection system</p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="toggle-wrapper bg-white bg-opacity-20 p-2 rounded-3 px-3 border border-white border-opacity-20">
                    <div class="form-check form-switch mb-0 d-flex align-items-center gap-2">
                        <input class="form-check-input" type="checkbox" id="toggle-tablet">
                        <label class="form-check-label text-white fw-bold mb-0 small" for="toggle-tablet">IP WEBCAM</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="scanner-wrapper">
        
        <div id="panel-tablet-config" class="glass-card mb-4 p-4" style="display: none;">
            <div class="row g-3 align-items-center">
                <div class="col">
                    <label class="label-accent text-uppercase mb-2 d-block">TABLET ANDROID IP ADDRESS</label>
                    <input type="text" id="tablet-ip" class="form-control form-control-glass" placeholder="e.g. 192.168.1.5:8080">
                </div>
                <div class="col-auto align-self-end">
                    <button class="btn btn-glass" id="btn-connect-tablet" type="button">Connect</button>
                </div>
                <div class="col-auto align-self-end">
                    <span id="tablet-status" class="status-badge badge-waiting">Disconnected</span>
                </div>
            </div>
        </div>

        <div class="glass-card">
            <div class="px-4 py-3 border-bottom border-light d-flex align-items-center justify-content-between bg-light bg-opacity-50">
                <div class="d-flex flex-column">
                    <div class="label-accent text-accent text-uppercase" id="mode-badge">CAMERA: LOCAL</div>
                    <select id="camera-select" class="form-select-glass mt-2" style="min-width: 250px;">
                        <option value="">Detecting cameras...</option>
                    </select>
                </div>
                <div class="status-badge badge-active" id="scanner-status-badge">
                    <span class="pulse-dot"></span> ACTIVE
                </div>
            </div>

            <div class="p-3">
                <div class="scanner-box">
                    <div class="scanner-frame">
                        <div class="scanner-laser"></div>
                        <div class="corner corner-tl"></div>
                        <div class="corner corner-tr"></div>
                        <div class="corner corner-bl"></div>
                        <div class="corner corner-br"></div>
                    </div>

                    {{-- Laptop/Local Mode --}}
                    <div id="mode-laptop" class="w-100 h-100">
                        <div id="reader"></div>
                    </div>

                    {{-- Tablet/IP Mode --}}
                    <div id="mode-tablet" class="w-100 h-100" style="display: none; background: #000;">
                        <img id="tablet-stream-img" src="" alt="Stream" style="width:100%; height:100%; display:block; object-fit: cover;">
                        <div id="tablet-error" style="display:none; position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); color:white; flex-direction:column; align-items:center; justify-content:center; padding:20px; text-align:center; z-index: 20;">
                            <div class="mb-3 opacity-50">Connection lost or invalid IP</div>
                            <button class="btn btn-glass btn-sm" onclick="location.reload()">Retry</button>
                        </div>
                    </div>
                    
                    <canvas id="capture-canvas" style="display:none;"></canvas>
                </div>

                {{-- Modern Result Panel --}}
                <div id="scan-result-container" class="result-panel" style="display: none;">
                    <div class="d-flex align-items-start justify-content-between mb-4">
                        <div>
                            <div class="badge bg-success bg-opacity-10 text-success border border-success mb-2 px-3 py-2" style="font-size: 0.7rem; font-weight: 800;">SCAN SUCCESSFUL</div>
                            <h2 id="res-nama" class="m-0 fw-bold text-dark">Product Name</h2>
                        </div>
                        <div class="text-end">
                            <div class="label-accent text-uppercase opacity-50">PRICE</div>
                            <div id="res-harga" class="fs-2 fw-bold text-accent">Rp 0</div>
                        </div>
                    </div>
                    
                    <div class="bg-light rounded-4 p-4 mb-4 border border-light">
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="label-accent text-uppercase opacity-50 d-block mb-1">PRODUCT ID</label>
                                <div id="res-id" class="fw-bold text-dark fs-5">BARCODE-123</div>
                            </div>
                            <div class="col-6 text-end">
                                <label class="label-accent text-uppercase opacity-50 d-block mb-1">STATUS</label>
                                <div class="text-success fw-bold fs-5">VERIFIED</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-2" style="font-size: 0.85rem;">
                            <span class="text-secondary fw-medium">Auto-restarting scanner in <span id="countdown" class="fw-bold text-dark">10</span>s</span>
                            <span id="countdown-percent" class="text-secondary fw-bold">100%</span>
                        </div>
                        <div class="progress-compact">
                            <div id="reset-progress" class="progress-bar bg-accent" style="width:100%; transition: none;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 text-center opacity-50" style="font-size: 0.75rem; letter-spacing: 3px; font-weight: 700; color: white;">
            ADVANCED SCAN ENGINE V4.0 • SYSTEM OPTIMIZED
        </div>
    </div>

</div>


{{-- Loading --}}
<div id="loading-overlay" class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-white bg-opacity-75" style="display: none !important; z-index: 9999;">
    <div class="text-center">
        <div class="spinner-border text-primary spinner-border-sm" role="status"></div>
        <p class="mt-2 fw-bold text-primary" style="font-size: 0.7rem;">MEMPROSES...</p>
    </div>
</div>

<audio id="beep-sound" preload="auto">
    <source src="https://assets.mixkit.co/active_storage/sfx/2568/2568-preview.mp3" type="audio/mpeg">
</audio>

@endsection

@section('scripts')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const beepSound = document.getElementById('beep-sound');
    const resultContainer = document.getElementById('scan-result-container');
    const loadingOverlay = document.getElementById('loading-overlay');
    const resId = document.getElementById('res-id');
    const resNama = document.getElementById('res-nama');
    const resHarga = document.getElementById('res-harga');
    const modeBadge = document.getElementById('mode-badge');
    const scannerStatusBadge = document.getElementById('scanner-status-badge');
    const countdown = document.getElementById('countdown');
    const countdownPercent = document.getElementById('countdown-percent');
    const resetProgress = document.getElementById('reset-progress');
    const modeLaptop = document.getElementById('mode-laptop');
    const modeTablet = document.getElementById('mode-tablet');
    const toggleTablet = document.getElementById('toggle-tablet');
    const panelTabletConfig = document.getElementById('panel-tablet-config');
    const tabletIpInput = document.getElementById('tablet-ip');
    const btnConnect = document.getElementById('btn-connect-tablet');
    const tabletStatus = document.getElementById('tablet-status');
    const tabletStreamImg = document.getElementById('tablet-stream-img');
    const tabletError = document.getElementById('tablet-error');
    const captureCanvas = document.getElementById('capture-canvas');
    const cameraSelect = document.getElementById('camera-select');

    let isTabletMode = false;
    let isScanning = false;
    let resetTimer = null;
    let countdownInterval = null;
    let html5Qrcode = null;
    let currentCameraId = null;
    let cameras = [];
    let currentTabletIP = '';
    let tabletScanTimer = null;
    let isBeeping = false;

    // Optimization Settings
    const SCAN_CONFIG = {
        fps: 25, // Higher FPS for responsive detection
        qrbox: (viewfinderWidth, viewfinderHeight) => {
            // Responsive QR Box
            const minEdge = Math.min(viewfinderWidth, viewfinderHeight);
            const size = Math.floor(minEdge * 0.7);
            return { width: size, height: size * 0.65 };
        },
        aspectRatio: 1.333334,
        disableFlip: false,
        experimentalFeatures: {
            useBarCodeDetectorIfSupported: true
        }
    };

    function playBeep() {
        if (isBeeping) return;
        isBeeping = true;
        try {
            beepSound.pause();
            beepSound.currentTime = 0;
            beepSound.play().then(() => {
                setTimeout(() => { isBeeping = false; }, 1000);
            }).catch(() => { isBeeping = false; });
        } catch(e) { isBeeping = false; }
    }

    // Camera Initialization
    Html5Qrcode.getCameras().then(devices => {
        cameras = devices;
        cameraSelect.innerHTML = '';
        
        if (cameras && cameras.length > 0) {
            cameras.forEach((camera, index) => {
                const option = document.createElement('option');
                option.value = camera.id;
                option.text = camera.label || `Camera ${index + 1}`;
                cameraSelect.appendChild(option);
            });

            // Auto-select logic
            let selectedId = cameras[0].id;
            
            // 1. Try to find external USB webcam
            const external = cameras.find(c => c.label.toLowerCase().includes('usb') || c.label.toLowerCase().includes('external'));
            if (external) selectedId = external.id;
            
            // 2. If mobile, try back camera
            const back = cameras.find(c => c.label.toLowerCase().includes('back') || c.label.toLowerCase().includes('rear'));
            if (back) selectedId = back.id;

            cameraSelect.value = selectedId;
            currentCameraId = selectedId;
            
            if (!isTabletMode) startScanner();
        } else {
            cameraSelect.innerHTML = '<option value="">No camera detected</option>';
        }
    }).catch(err => {
        console.error("Error getting cameras", err);
        cameraSelect.innerHTML = '<option value="">Permission denied</option>';
    });

    cameraSelect.addEventListener('change', function() {
        currentCameraId = this.value;
        if (!isTabletMode) {
            stopScanner().then(() => startScanner());
        }
    });

    function startScanner() {
        if (isScanning || isTabletMode || !currentCameraId) return;
        
        if (!html5Qrcode) html5Qrcode = new Html5Qrcode("reader");
        
        resultContainer.style.display = 'none';
        
        html5Qrcode.start(
            currentCameraId, 
            SCAN_CONFIG,
            (decodedText) => {
                if (isScanning) return; 
                handleScanSuccess(decodedText);
            },
            () => {} 
        ).then(() => {
            setStatusBadge(true);
            const activeCamera = cameras.find(c => c.id === currentCameraId);
            modeBadge.textContent = "Camera: " + (activeCamera ? activeCamera.label : "Active");
            
            // Attempt Continuous Focus
            try {
                const track = html5Qrcode.getVideoTrack();
                const capabilities = track.getCapabilities();
                if (capabilities.focusMode && capabilities.focusMode.includes('continuous')) {
                    track.applyConstraints({ advanced: [{ focusMode: 'continuous' }] });
                }
            } catch(e) {}
        }).catch(err => {
            console.error("Scanner start error", err);
            setStatusBadge(false);
        });
    }

    function stopScanner() {
        if (html5Qrcode && html5Qrcode.isScanning) {
            return html5Qrcode.stop().catch(err => console.warn("Stop error", err));
        }
        return Promise.resolve();
    }

    function handleScanSuccess(decodedText) {
        isScanning = true;
        playBeep();
        
        if (!isTabletMode) {
            stopScanner().then(() => processScanResult(decodedText));
        } else {
            stopTabletScan();
            processScanResult(decodedText);
        }
        setStatusBadge(false);
    }

    toggleTablet.addEventListener('change', function () {
        isTabletMode = this.checked;
        panelTabletConfig.style.display = isTabletMode ? 'block' : 'none';
        modeBadge.textContent = isTabletMode ? 'Camera: IP Webcam' : 'Camera: Local';
        
        if (isTabletMode) {
            stopScanner().then(() => {
                modeLaptop.style.display = 'none';
                modeTablet.style.display = 'block';
                resultContainer.style.display = 'none';
            });
        } else {
            stopTabletScan();
            modeTablet.style.display = 'none';
            modeLaptop.style.display = 'block';
            startScanner();
        }
    });

    const savedIP = localStorage.getItem('tablet_ip');
    if (savedIP) tabletIpInput.value = savedIP;

    btnConnect.addEventListener('click', function () {
        const ip = tabletIpInput.value.trim();
        if (!ip) return;
        localStorage.setItem('tablet_ip', ip);
        currentTabletIP = ip;
        connectTabletStream(ip);
    });

    function connectTabletStream(ip) {
        const baseUrl = `http://${ip}`;
        tabletStatus.className = 'status-badge badge-waiting';
        tabletStatus.textContent = 'Connecting...';
        tabletError.style.display = 'none';
        
        const testImg = new Image();
        testImg.onload = () => {
            tabletStatus.className = 'status-badge badge-active';
            tabletStatus.textContent = 'Connected';
            tabletStreamImg.src = `${baseUrl}/video`;
            startTabletScan(`${baseUrl}/shot.jpg`);
        };
        testImg.onerror = () => {
            tabletStatus.className = 'status-badge badge-waiting';
            tabletStatus.textContent = 'Error';
            tabletError.style.display = 'flex';
        };
        testImg.src = `${baseUrl}/shot.jpg?t=${Date.now()}`;
    }

    function startTabletScan(snapshotUrl) {
        stopTabletScan();
        isScanning = false;
        setStatusBadge(true);
        
        tabletScanTimer = setInterval(() => {
            if (isScanning) return;
            
            const snap = new Image();
            snap.crossOrigin = 'anonymous';
            snap.onload = () => {
                captureCanvas.width = snap.naturalWidth || 640;
                captureCanvas.height = snap.naturalHeight || 480;
                const ctx = captureCanvas.getContext('2d');
                ctx.drawImage(snap, 0, 0);
                
                const imageData = ctx.getImageData(0, 0, captureCanvas.width, captureCanvas.height);
                const code = jsQR(imageData.data, imageData.width, imageData.height, {
                    inversionAttempts: 'dontInvert'
                });
                
                if (code && !isScanning) {
                    handleScanSuccess(code.data);
                }
            };
            snap.src = `${snapshotUrl}?t=${Date.now()}`;
        }, 400); 
    }

    function stopTabletScan() {
        clearInterval(tabletScanTimer);
        tabletScanTimer = null;
    }

    function setStatusBadge(active) {
        scannerStatusBadge.className = active ? 'status-badge badge-active' : 'status-badge badge-waiting';
        scannerStatusBadge.innerHTML = active ? '<span class="pulse-dot"></span> Active' : 'Idle';
    }

    function processScanResult(idBarang) {
        loadingOverlay.style.setProperty('display', 'flex', 'important');
        
        fetch("{{ route('scanner.barcode.get') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ id_barang: idBarang })
        })
        .then(response => response.json())
        .then(result => {
            loadingOverlay.style.setProperty('display', 'none', 'important');
            if (result.success) {
                resId.innerText = result.data.id_barang;
                resNama.innerText = result.data.nama;
                resHarga.innerText = "Rp " + Number(result.data.harga).toLocaleString('id-ID');
                
                resultContainer.style.display = 'block';
                
                let sisa = 10;
                countdown.textContent = sisa;
                countdownPercent.textContent = "100%";
                
                resetProgress.style.transition = 'none';
                resetProgress.style.width = '100%';
                
                setTimeout(() => {
                    resetProgress.style.transition = 'width 10s linear';
                    resetProgress.style.width = '0%';
                }, 100);

                clearInterval(countdownInterval);
                countdownInterval = setInterval(() => {
                    sisa--;
                    countdown.textContent = sisa;
                    countdownPercent.textContent = Math.round((sisa / 10) * 100) + "%";
                    if (sisa <= 0) clearInterval(countdownInterval);
                }, 1000);

                clearTimeout(resetTimer);
                resetTimer = setTimeout(restartScanner, 10000);
            } else {
                restartScanner();
            }
        })
        .catch(() => {
            loadingOverlay.style.setProperty('display', 'none', 'important');
            restartScanner();
        });
    }

    function restartScanner() {
        resultContainer.style.display = 'none';
        isScanning = false;
        if (isTabletMode) {
            if (currentTabletIP) startTabletScan(`http://${currentTabletIP}/shot.jpg`);
        } else {
            startScanner();
        }
    }
});
</script>

@endsection
