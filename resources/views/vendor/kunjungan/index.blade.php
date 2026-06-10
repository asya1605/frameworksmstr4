@extends('layouts.vendor.vendor')

@section('style')
<style>
    :root {
        --glass-bg: rgba(255, 255, 255, 0.98);
        --glass-border: rgba(0, 0, 0, 0.1);
        --primary-gradient: linear-gradient(135deg, #7c3aed, #db2777);
        --accent-color: #ec4899;
        --text-main: #1f2937;
        --text-sub: #4b5563;
        --text-muted: #6b7280;
        --text-dark: #111827;
    }

    body {
        background: radial-gradient(circle at top right, #1e1b4b, #0f172a);
        min-height: 100vh;
        color: var(--text-main);
        font-family: 'Outfit', 'Inter', sans-serif;
    }

    .page-header {
        background: linear-gradient(135deg, rgba(124, 58, 237, 0.2), rgba(219, 39, 119, 0.2));
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
        font-size: 2rem;
        letter-spacing: -1px;
    }

    .glass-card {
        background: #ffffff;
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
        overflow: hidden;
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

    #reader__dashboard, #reader__status_span, #reader img, #reader button {
        display: none !important;
    }

    .scanner-frame {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        pointer-events: none;
        z-index: 10;
    }

    .scanner-laser {
        position: absolute;
        top: 10%; left: 5%; width: 90%; height: 2px;
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
        width: 35px; height: 35px;
        border: 4px solid var(--accent-color);
        z-index: 12;
    }
    .corner-tl { top: 25px; left: 25px; border-right: 0; border-bottom: 0; border-top-left-radius: 12px; }
    .corner-tr { top: 25px; right: 25px; border-left: 0; border-bottom: 0; border-top-right-radius: 12px; }
    .corner-bl { bottom: 25px; left: 25px; border-right: 0; border-top: 0; border-bottom-left-radius: 12px; }
    .corner-br { bottom: 25px; right: 25px; border-left: 0; border-top: 0; border-bottom-right-radius: 12px; }

    .status-badge {
        padding: 8px 16px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 0.75rem;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .badge-active { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .badge-waiting { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }

    .geo-status-pill {
        padding: 10px 20px;
        border-radius: 50px;
        font-weight: 800;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .geo-ok { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .geo-err { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

    .result-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        display: none;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 100;
        backdrop-filter: blur(15px);
        animation: fadeIn 0.3s ease;
    }
    .overlay-success { background: rgba(34, 197, 94, 0.95); color: white; }
    .overlay-error { background: rgba(239, 68, 68, 0.95); color: white; }

    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

    .progress-compact {
        height: 8px;
        background: rgba(0,0,0,0.1);
        border-radius: 10px;
        overflow: hidden;
        width: 250px;
        margin-top: 20px;
    }
    .progress-bar-fill {
        height: 100%;
        background: #fff;
        width: 100%;
        transition: width 10s linear;
    }

    .form-select-custom {
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        color: var(--text-dark);
        border-radius: 12px;
        padding: 10px 16px;
        font-weight: 700;
        outline: none;
        width: 100%;
    }

    .info-card {
        background: #f9fafb;
        padding: 15px;
        border-radius: 16px;
        border: 1px solid #f3f4f6;
    }
    .info-label { font-size: 0.65rem; font-weight: 900; color: var(--text-muted); text-transform: uppercase; margin-bottom: 2px; }
    .info-value { font-size: 0.95rem; font-weight: 700; color: var(--text-dark); }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    
    <div class="page-header">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div>
                <h1 class="text-white fw-bold">Barcode Toko (Geolocation)</h1>
                <p class="text-white opacity-90 fw-medium">Exclusive Mode Scanner Engine v5.0</p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="bg-white bg-opacity-20 p-2 rounded-3 px-3 border border-white border-opacity-20">
                    <div class="form-check form-switch mb-0 d-flex align-items-center gap-2">
                        <input class="form-check-input" type="checkbox" id="toggle-tablet">
                        <label class="form-check-label text-white fw-bold mb-0 small" for="toggle-tablet">IP WEBCAM</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 justify-content-center">
        <div class="col-lg-7">
            {{-- Tablet Config --}}
            <div id="panel-tablet-config" class="glass-card mb-4 p-4" style="display: none;">
                <label class="info-label mb-2 d-block">ANDROID IP ADDRESS</label>
                <div class="input-group">
                    <input type="text" id="tablet-ip" class="form-control" placeholder="e.g. 192.168.1.5:8080" style="border-radius:12px 0 0 12px; font-weight:600;">
                    <button class="btn btn-primary fw-bold px-4" id="btn-connect-tablet" type="button" style="border-radius:0 12px 12px 0;">Connect</button>
                </div>
                <div id="tablet-status-text" class="mt-2 small fw-bold text-muted">Disconnected</div>
            </div>

            <div class="glass-card">
                <div class="px-4 py-3 border-bottom d-flex align-items-center justify-content-between bg-light bg-opacity-50">
                    <div id="camera-selection-wrapper" class="d-flex flex-column" style="max-width: 250px;">
                        <div class="info-label text-primary" id="mode-badge">CAMERA: LOCAL</div>
                        <select id="camera-select" class="form-select-custom mt-2">
                            <option value="">Detecting cameras...</option>
                        </select>
                    </div>
                    <div class="status-badge badge-active" id="scanner-status-badge">
                        <span class="spinner-grow spinner-grow-sm"></span> ACTIVE
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

                        <div id="mode-laptop" class="w-100 h-100">
                            <div id="reader"></div>
                        </div>

                        <div id="mode-tablet" class="w-100 h-100" style="display: none; background: #000;">
                            <img id="tablet-stream-img" src="" alt="Stream" style="width:100%; height:100%; display:block; object-fit: cover;">
                        </div>
                        
                        <canvas id="capture-canvas" style="display:none;"></canvas>

                        {{-- Result Overlay --}}
                        <div id="result-overlay" class="result-overlay">
                            <i id="res-icon" class="mdi mdi-check-circle mb-2" style="font-size: 5rem;"></i>
                            <h1 id="res-title" class="fw-bolder mb-0">DITERIMA</h1>
                            <p id="res-msg" class="fs-5 opacity-90 mt-2 text-center px-4"></p>
                            
                            <div class="progress-compact">
                                <div id="reset-bar" class="progress-bar-fill"></div>
                            </div>
                            <p class="small fw-bold mt-2 opacity-75">RESTARTING IN <span id="countdown">10</span>S</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="glass-card p-4 h-100">
                <div class="info-label mb-3">GPS MONITORING</div>
                
                <div id="geo-status" class="geo-status-pill geo-err mb-4">
                    <div class="spinner-border spinner-border-sm" role="status"></div>
                    <span id="geo-text">SEARCHING GPS...</span>
                </div>

                <div class="row g-3">
                    <div class="col-6">
                        <div class="info-card">
                            <div class="info-label">LATITUDE</div>
                            <div id="v-lat" class="info-value">---</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="info-card">
                            <div class="info-label">LONGITUDE</div>
                            <div id="v-lng" class="info-value">---</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="info-card">
                            <div class="info-label">VENDOR ACCURACY</div>
                            <div id="v-acc" class="info-value">0.0m</div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-top" id="toko-info-box" style="display: none;">
                    <div class="info-label mb-3">VERIFIKASI LOKASI: <span id="toko-name" class="text-primary">---</span></div>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="info-card">
                                <div class="info-label">JARAK AKTUAL</div>
                                <div id="res-jarak" class="info-value">0.0m</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-card">
                                <div class="info-label">JARAK TOLERANSI</div>
                                <div id="res-threshold" class="info-value">0.0m</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-auto pt-4 text-center">
                    <div class="p-3 rounded-4 bg-light small fw-bold text-muted border">
                        <i class="mdi mdi-shield-check-outline me-1"></i>
                        Threshold = 50m + Acc Toko + Acc Vendor
                    </div>
                </div>

                {{-- DEBUG CARD --}}
                <div class="mt-4 p-3 rounded-4 bg-dark text-light border border-secondary" id="debug-card" style="font-family: monospace; font-size: 0.85rem;">
                    <div class="text-warning mb-2 fw-bold" style="letter-spacing: 1px;">## DEBUG SCANNER</div>
                    <div class="mb-2">RAW DECODE:<br><span id="debug-raw" class="text-danger fw-bold text-break">---</span></div>
                    <div class="mb-2">CLEAN BARCODE:<br><span id="debug-clean" class="text-success fw-bold text-break">---</span></div>
                    <div class="mb-2">Status:<br><span id="debug-status" class="text-info fw-bold">WAITING</span></div>
                    <div class="mb-0 border-top border-secondary pt-2">AJAX Status:<br><span id="debug-ajax" class="text-muted">---</span></div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="https://unpkg.com/@zxing/library@latest"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const els = {
        cameraSelect: document.getElementById('camera-select'),
        toggleTablet: document.getElementById('toggle-tablet'),
        modeBadge: document.getElementById('mode-badge'),
        statusBadge: document.getElementById('scanner-status-badge'),
        readerDiv: document.getElementById('reader'),
        modeLaptop: document.getElementById('mode-laptop'),
        modeTablet: document.getElementById('mode-tablet'),
        tabletImg: document.getElementById('tablet-stream-img'),
        tabletIp: document.getElementById('tablet-ip'),
        btnConnect: document.getElementById('btn-connect-tablet'),
        tabletStatusText: document.getElementById('tablet-status-text'),
        captureCanvas: document.getElementById('capture-canvas'),
        cameraWrapper: document.getElementById('camera-selection-wrapper'),
        
        geoStatus: document.getElementById('geo-status'),
        geoText: document.getElementById('geo-text'),
        vLat: document.getElementById('v-lat'),
        vLng: document.getElementById('v-lng'),
        vAcc: document.getElementById('v-acc'),
        
        resultOverlay: document.getElementById('result-overlay'),
        resIcon: document.getElementById('res-icon'),
        resTitle: document.getElementById('res-title'),
        resMsg: document.getElementById('res-msg'),
        resetBar: document.getElementById('reset-bar'),
        countdown: document.getElementById('countdown'),
        
        tokoInfoBox: document.getElementById('toko-info-box'),
        tokoName: document.getElementById('toko-name'),
        resJarak: document.getElementById('res-jarak'),
        resThreshold: document.getElementById('res-threshold'),
        
        debugRaw: document.getElementById('debug-raw'),
        debugClean: document.getElementById('debug-clean'),
        debugStatus: document.getElementById('debug-status'),
        debugAjax: document.getElementById('debug-ajax')
    };

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
    let currentCoords = null;

    const codeReader = new ZXing.BrowserMultiFormatReader();

    const SCAN_CONFIG = {
        fps: 10, 
        qrbox: undefined,
        aspectRatio: 1.333334,
        disableFlip: false,
        experimentalFeatures: {
            useBarCodeDetectorIfSupported: true
        }
    };

    const FORMATS = [ 
        Html5QrcodeSupportedFormats.CODE_128
    ];

    const beep = new Audio('/audio/beep.mp3');
    beep.preload = 'auto';

    function playBeep(success) {
        if (isBeeping) return;
        isBeeping = true;
        try {
            beep.pause();
            beep.currentTime = 0;
            const playPromise = beep.play();
            if (playPromise !== undefined) {
                playPromise.then(() => {
                    setTimeout(() => { isBeeping = false; }, 1000);
                }).catch((e) => {
                    console.log("Audio play blocked/failed:", e);
                    isBeeping = false;
                });
            } else {
                setTimeout(() => { isBeeping = false; }, 1000);
            }
        } catch(e) { 
            console.log("Audio exception:", e);
            isBeeping = false; 
        }
    }

    function initGeo() {
        if (!navigator.geolocation) return;
        navigator.geolocation.watchPosition(
            (pos) => {
                currentCoords = pos.coords;
                els.vLat.textContent = currentCoords.latitude.toFixed(6);
                els.vLng.textContent = currentCoords.longitude.toFixed(6);
                els.vAcc.textContent = currentCoords.accuracy.toFixed(1) + 'm';
                if (currentCoords.accuracy <= 50) {
                    els.geoStatus.className = 'geo-status-pill geo-ok';
                    els.geoText.textContent = "GPS TERKUNCI (STABIL)";
                } else {
                    els.geoStatus.className = 'geo-status-pill geo-err';
                    els.geoText.textContent = "AKURASI RENDAH (" + currentCoords.accuracy.toFixed(0) + "m)";
                }
            },
            () => {},
            { enableHighAccuracy: true }
        );
    }

    Html5Qrcode.getCameras().then(devices => {
        cameras = devices;
        els.cameraSelect.innerHTML = '';
        
        if (cameras && cameras.length > 0) {
            cameras.forEach((camera, index) => {
                const option = document.createElement('option');
                option.value = camera.id;
                option.text = camera.label || `Camera ${index + 1}`;
                els.cameraSelect.appendChild(option);
            });

            let selectedId = cameras[0].id;
            
            const external = cameras.find(c => c.label.toLowerCase().includes('usb') || c.label.toLowerCase().includes('external'));
            if (external) selectedId = external.id;
            
            const back = cameras.find(c => c.label.toLowerCase().includes('back') || c.label.toLowerCase().includes('rear'));
            if (back) selectedId = back.id;

            els.cameraSelect.value = selectedId;
            currentCameraId = selectedId;
            
            if (!isTabletMode) startScanner();
        } else {
            els.cameraSelect.innerHTML = '<option value="">No camera detected</option>';
        }
    }).catch(err => {
        console.error("Error getting cameras", err);
        els.cameraSelect.innerHTML = '<option value="">Permission denied</option>';
    });

    els.cameraSelect.addEventListener('change', function() {
        currentCameraId = this.value;
        if (!isTabletMode) {
            stopScanner().then(() => startScanner());
        }
    });

    function startScanner() {
        if (isScanning || isTabletMode || !currentCameraId) return;
        
        if (!html5Qrcode) {
            html5Qrcode = new Html5Qrcode("reader", { formatsToSupport: FORMATS });
        }
        
        els.resultOverlay.style.display = 'none';
        
        html5Qrcode.start(
            currentCameraId, 
            SCAN_CONFIG,
            (decodedText) => {
                if (isScanning) return; 
                handleScanSuccess(decodedText);
            },
            () => {
                console.log("SCAN FAILED");
                els.debugStatus.textContent = "SCAN FAILED";
                els.debugStatus.className = "text-danger fw-bold";
            } 
        ).then(() => {
            setStatusBadge(true);
            const activeCamera = cameras.find(c => c.id === currentCameraId);
            els.modeBadge.textContent = "CAMERA: " + (activeCamera ? activeCamera.label.toUpperCase() : "ACTIVE");
            
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
        const cleanBarcode = decodedText.replace(/[^a-zA-Z0-9]/g, '').trim().toUpperCase();
        
        console.log("RAW:", decodedText);
        console.log("CLEAN:", cleanBarcode);

        els.debugRaw.textContent = "'" + decodedText + "'";
        els.debugClean.textContent = cleanBarcode;
        els.debugStatus.textContent = "BARCODE DETECTED";
        els.debugStatus.className = "text-success fw-bold";

        if (!currentCoords || currentCoords.accuracy > 150) {
            alert("Sinyal GPS belum stabil. Tunggu akurasi lebih baik.");
            return;
        }

        isScanning = true;
        playBeep(true);
        
        if (!isTabletMode) {
            stopScanner().then(() => processKunjungan(cleanBarcode));
        } else {
            stopTabletScan();
            processKunjungan(cleanBarcode);
        }
        setStatusBadge(false);
    }

    els.toggleTablet.addEventListener('change', function () {
        isTabletMode = this.checked;
        document.getElementById('panel-tablet-config').style.display = isTabletMode ? 'block' : 'none';
        els.cameraWrapper.style.display = isTabletMode ? 'none' : 'flex';
        
        if (isTabletMode) {
            stopScanner().then(() => {
                els.modeLaptop.style.display = 'none';
                els.modeTablet.style.display = 'block';
                els.resultOverlay.style.display = 'none';
                els.modeBadge.textContent = 'CAMERA: IP WEBCAM';
            });
        } else {
            stopTabletScan();
            els.modeTablet.style.display = 'none';
            els.modeLaptop.style.display = 'block';
            startScanner();
        }
    });

    const savedIP = localStorage.getItem('tablet_ip_vendor');
    if (savedIP) els.tabletIp.value = savedIP;

    els.btnConnect.addEventListener('click', function () {
        const ip = els.tabletIp.value.trim();
        if (!ip) return;
        localStorage.setItem('tablet_ip_vendor', ip);
        currentTabletIP = ip;
        connectTabletStream(ip);
    });

    function connectTabletStream(ip) {
        const baseUrl = `http://${ip}`;
        els.tabletStatusText.className = 'mt-2 small fw-bold text-muted';
        els.tabletStatusText.textContent = 'Connecting...';
        
        const testImg = new Image();
        testImg.onload = () => {
            els.tabletStatusText.className = 'mt-2 small fw-bold text-success';
            els.tabletStatusText.textContent = 'Connected';
            els.tabletImg.src = `${baseUrl}/video`;
            startTabletScan(`${baseUrl}/shot.jpg`);
        };
        testImg.onerror = () => {
            els.tabletStatusText.className = 'mt-2 small fw-bold text-danger';
            els.tabletStatusText.textContent = 'Connection lost or invalid IP';
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
                els.captureCanvas.width = snap.naturalWidth || 640;
                els.captureCanvas.height = snap.naturalHeight || 480;
                const ctx = els.captureCanvas.getContext('2d');
                ctx.drawImage(snap, 0, 0);
                
                try {
                    codeReader.decodeFromCanvas(els.captureCanvas).then(result => {
                        if (result && !isScanning) {
                            handleScanSuccess(result.text);
                        }
                    }).catch(err => {
                        console.log("SCAN FAILED");
                        els.debugStatus.textContent = "SCAN FAILED";
                        els.debugStatus.className = "text-danger fw-bold";
                    });
                } catch(e) {
                    console.log("SCAN FAILED");
                    els.debugStatus.textContent = "SCAN FAILED";
                    els.debugStatus.className = "text-danger fw-bold";
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
        els.statusBadge.className = active ? 'status-badge badge-active' : 'status-badge badge-waiting';
        els.statusBadge.innerHTML = active ? '<span class="spinner-grow spinner-grow-sm"></span> ACTIVE' : 'IDLE';
    }

    function processKunjungan(barcode) {
        els.debugAjax.textContent = 'SENDING REQUEST...';
        els.debugAjax.className = 'text-warning';

        fetch("{{ route('vendor.kunjungan.store') }}", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body: JSON.stringify({
                barcode: barcode,
                latitude: currentCoords.latitude,
                longitude: currentCoords.longitude,
                accuracy: currentCoords.accuracy
            })
        })
        .then(async r => {
            const res = await r.json().catch(() => ({}));
            console.log("BACKEND RESPONSE:", res);
            
            if (r.ok) {
                els.debugAjax.textContent = 'SUCCESS (' + r.status + '): ' + (res.message || 'OK');
                els.debugAjax.className = 'text-success';
                if (res.success) renderResult(res);
                else showOverlay('ERROR', res.message);
            } else {
                els.debugAjax.textContent = 'AJAX FAILED (' + r.status + '): ' + (res.message || r.statusText);
                els.debugAjax.className = 'text-danger fw-bold';
                showOverlay('ERROR', res.message || 'AJAX FAILED');
            }
        })
        .catch(e => {
            console.error(e);
            els.debugAjax.textContent = 'AJAX FAILED: Network Error';
            els.debugAjax.className = 'text-danger fw-bold';
            showOverlay('ERROR', "Gagal menghubungi server.");
        });
    }

    function renderResult(res) {
        if (!res || !res.data) {
            showOverlay('ERROR', res.message || 'Data kosong dari server');
            return;
        }
        
        const d = res.data;
        els.tokoInfoBox.style.display = 'block';
        els.tokoName.textContent = d.nama_toko || '---';
        els.resJarak.textContent = (d.jarak || 0) + 'm';
        els.resThreshold.textContent = (d.threshold_efektif || 0) + 'm';
        
        const statusStr = d.status || 'ERROR';
        const tokoStr = d.nama_toko || 'Toko';
        showOverlay(statusStr, statusStr === 'DITERIMA' ? `Berhasil presensi di ${tokoStr}` : `Lokasi terlalu jauh dari ${tokoStr}`);
    }

    function showOverlay(status, msg) {
        els.resultOverlay.style.display = 'flex';
        els.resMsg.textContent = msg;
        if (status === 'DITERIMA') {
            els.resultOverlay.className = 'result-overlay overlay-success';
            els.resIcon.className = 'mdi mdi-check-circle mb-2';
            els.resTitle.textContent = "DITERIMA";
            playBeep(true);
        } else {
            els.resultOverlay.className = 'result-overlay overlay-error';
            els.resIcon.className = 'mdi mdi-close-circle mb-2';
            els.resTitle.textContent = status === 'DITOLAK' ? "DITOLAK" : "ERROR";
            playBeep(false);
        }
        
        let sisa = 10;
        els.countdown.textContent = sisa;
        
        els.resetBar.style.transition = 'none';
        els.resetBar.style.width = '100%';
        
        setTimeout(() => {
            els.resetBar.style.transition = 'width 10s linear';
            els.resetBar.style.width = '0%';
        }, 100);

        clearInterval(countdownInterval);
        countdownInterval = setInterval(() => {
            sisa--;
            els.countdown.textContent = sisa;
            if (sisa <= 0) clearInterval(countdownInterval);
        }, 1000);

        clearTimeout(resetTimer);
        resetTimer = setTimeout(restartScanner, 10000);
    }

    function restartScanner() {
        els.resultOverlay.style.display = 'none';
        isScanning = false;
        if (isTabletMode) {
            if (currentTabletIP) startTabletScan(`http://${currentTabletIP}/shot.jpg`);
        } else {
            startScanner();
        }
    }

    initGeo();
});

</script>
@endsection
