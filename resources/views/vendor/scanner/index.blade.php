@extends('layouts.vendor.vendor')

@section('style')
<style>
    :root {
        --glass-bg: rgba(255, 255, 255, 0.95);
        --glass-border: rgba(0, 0, 0, 0.1);
        --primary-gradient: linear-gradient(135deg, #7c3aed, #db2777);
        --accent-color: #ec4899;
        --text-main: #1f2937;
        --text-sub: #4b5563;
        --text-muted: #6b7280;
        --text-dark: #111827;
    }

    body {
        background: radial-gradient(circle at top right, #2d1b4e, #1a1a2e);
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
        font-size: 2.2rem;
        letter-spacing: -1px;
        text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    .page-header p {
        color: rgba(255, 255, 255, 0.9);
        margin-top: 8px;
        margin-bottom: 0;
        font-size: 1rem;
        font-weight: 500;
    }

    .glass-card {
        background: #ffffff;
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
        overflow: hidden;
    }

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
        letter-spacing: 1.5px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .pulse-dot {
        width: 10px; height: 10px;
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
    }

    .progress-compact {
        height: 8px;
        background: #f1f5f9;
        border-radius: 10px;
        overflow: hidden;
    }

    .label-accent {
        color: #4b5563;
        font-weight: 800;
        letter-spacing: 1px;
        font-size: 0.75rem;
    }

    .text-accent { color: #7c3aed; }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    
    <div class="page-header">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div>
                <h1 class="text-white fw-bold">QR Customer Scanner</h1>
                <p class="text-white opacity-90 fw-medium">Verifikasi pesanan customer secara instan & otomatis</p>
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

    <div class="scanner-wrapper">
        
        {{-- Tablet Config --}}
        <div id="panel-tablet-config" class="glass-card mb-4 p-4" style="display: none;">
            <div class="row g-3 align-items-center">
                <div class="col">
                    <label class="label-accent text-uppercase mb-2 d-block">ANDROID IP ADDRESS</label>
                    <input type="text" id="tablet-ip" class="form-control" placeholder="e.g. 192.168.1.5:8080" style="border-radius:12px; font-weight:600;">
                </div>
                <div class="col-auto align-self-end">
                    <button class="btn btn-primary fw-bold px-4" id="btn-connect-tablet" type="button" style="border-radius:12px;">Connect</button>
                </div>
                <div class="col-auto align-self-end">
                    <span id="tablet-status" class="status-badge badge-waiting">Disconnected</span>
                </div>
            </div>
        </div>

        <div class="glass-card">
            <div class="px-4 py-3 border-bottom d-flex align-items-center justify-content-between bg-light bg-opacity-50">
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
                            <button class="btn btn-primary fw-bold" onclick="location.reload()" style="border-radius:12px;">Retry</button>
                        </div>
                    </div>
                    
                    <canvas id="capture-canvas" style="display:none;"></canvas>
                </div>

                {{-- Result Panel --}}
                <div id="scan-result-container" class="result-panel" style="display: none;">
                    <div class="d-flex align-items-start justify-content-between mb-4">
                        <div>
                            <div class="badge bg-success bg-opacity-10 text-success border border-success mb-2 px-3 py-2" style="font-size: 0.7rem; font-weight: 800;">VERIFIED SUCCESSFUL</div>
                            <h2 id="res-nama" class="m-0 fw-bold text-dark">Customer Name</h2>
                            <p id="res-id" class="text-muted fw-bold mb-0">#ORDER-ID</p>
                        </div>
                        <div class="text-end">
                            <div class="label-accent text-uppercase opacity-50">TOTAL</div>
                            <div id="res-total" class="fs-2 fw-bold text-accent">Rp 0</div>
                        </div>
                    </div>
                    
                    <div class="table-responsive mb-4 rounded-3 border">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="label-accent ps-3">ITEM</th>
                                    <th class="label-accent text-center">QTY</th>
                                    <th class="label-accent text-end pe-3">SUBTOTAL</th>
                                </tr>
                            </thead>
                            <tbody id="res-items" class="fw-bold text-dark"></tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-2" style="font-size: 0.85rem;">
                            <span class="text-secondary fw-medium">Auto-restarting in <span id="countdown" class="fw-bold text-dark">10</span>s</span>
                            <span id="countdown-percent" class="text-secondary fw-bold">100%</span>
                        </div>
                        <div class="progress-compact">
                            <div id="reset-progress" class="progress-bar bg-accent" style="width:100%; transition: none;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 text-center opacity-50 text-white" style="font-size: 0.75rem; letter-spacing: 3px; font-weight: 700;">
            PRO SCAN ENGINE V4.0 • VENDOR EDITION
        </div>
    </div>
</div>

{{-- Loading --}}
<div id="loading-overlay" class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-white bg-opacity-80" style="display: none !important; z-index: 9999;">
    <div class="text-center">
        <div class="spinner-border text-primary" role="status"></div>
        <p class="mt-2 fw-bold text-primary">PROCESSING...</p>
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
    const elements = {
        beep: document.getElementById('beep-sound'),
        resultContainer: document.getElementById('scan-result-container'),
        loading: document.getElementById('loading-overlay'),
        resId: document.getElementById('res-id'),
        resNama: document.getElementById('res-nama'),
        resTotal: document.getElementById('res-total'),
        resItems: document.getElementById('res-items'),
        modeBadge: document.getElementById('mode-badge'),
        statusBadge: document.getElementById('scanner-status-badge'),
        countdown: document.getElementById('countdown'),
        countdownPct: document.getElementById('countdown-percent'),
        resetProgress: document.getElementById('reset-progress'),
        modeLaptop: document.getElementById('mode-laptop'),
        modeTablet: document.getElementById('mode-tablet'),
        toggleTablet: document.getElementById('toggle-tablet'),
        tabletIp: document.getElementById('tablet-ip'),
        btnConnect: document.getElementById('btn-connect-tablet'),
        tabletStatus: document.getElementById('tablet-status'),
        tabletImg: document.getElementById('tablet-stream-img'),
        tabletError: document.getElementById('tablet-error'),
        captureCanvas: document.getElementById('capture-canvas'),
        cameraSelect: document.getElementById('camera-select')
    };

    let isTabletMode = false;
    let isScanning = false;
    let html5Qrcode = null;
    let currentCameraId = null;
    let cameras = [];
    let tabletTimer = null;
    let countdownInterval = null;
    let resetTimer = null;
    let isBeeping = false;

    const SCAN_CONFIG = {
        fps: 25,
        qrbox: (w, h) => {
            const s = Math.floor(Math.min(w, h) * 0.7);
            return { width: s, height: s * 0.65 };
        },
        aspectRatio: 1.333334,
        experimentalFeatures: { useBarCodeDetectorIfSupported: true }
    };

    function playBeep() {
        if (isBeeping) return;
        isBeeping = true;
        try {
            elements.beep.pause();
            elements.beep.currentTime = 0;
            elements.beep.play().then(() => {
                setTimeout(() => { isBeeping = false; }, 1000);
            }).catch(() => { isBeeping = false; });
        } catch(e) { isBeeping = false; }
    }

    // Camera Init (Admin Pattern)
    Html5Qrcode.getCameras().then(devices => {
        cameras = devices;
        elements.cameraSelect.innerHTML = '';
        
        if (cameras && cameras.length > 0) {
            cameras.forEach((c, i) => {
                const opt = document.createElement('option');
                opt.value = c.id;
                opt.text = c.label || `Camera ${i + 1}`;
                elements.cameraSelect.appendChild(opt);
            });

            let selected = cameras[0].id;
            const ext = cameras.find(c => c.label.toLowerCase().includes('usb') || c.label.toLowerCase().includes('external'));
            if (ext) selected = ext.id;
            const back = cameras.find(c => c.label.toLowerCase().includes('back') || c.label.toLowerCase().includes('rear'));
            if (back) selected = back.id;

            elements.cameraSelect.value = selected;
            currentCameraId = selected;
            
            if (!isTabletMode) startScanner();
        } else {
            elements.cameraSelect.innerHTML = '<option value="">No camera detected</option>';
        }
    }).catch(err => {
        console.error("Camera error", err);
        elements.cameraSelect.innerHTML = '<option value="">Permission denied</option>';
    });

    elements.cameraSelect.addEventListener('change', function() {
        currentCameraId = this.value;
        if (!isTabletMode) stopScanner().then(() => startScanner());
    });

    async function cleanupTracks() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ video: true }).catch(() => null);
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                console.log("[LIFECYCLE] All tracks stopped manually.");
            }
        } catch(e) {}
    }

    async function startScanner() {
        if (isScanning || isTabletMode || !currentCameraId) return;
        
        console.log("[LIFECYCLE] Starting scanner...");
        if (!html5Qrcode) html5Qrcode = new Html5Qrcode("reader");
        
        elements.resultContainer.style.display = 'none';
        
        try {
            await html5Qrcode.start(
                currentCameraId, 
                SCAN_CONFIG,
                (txt) => { if (isScanning) return; handleScanSuccess(txt); },
                () => {}
            );
            setStatusBadge(true);
            const active = cameras.find(c => c.id === currentCameraId);
            elements.modeBadge.textContent = "CAMERA: " + (active ? active.label : "ACTIVE");
        } catch (err) {
            console.error("Start error", err);
            setStatusBadge(false);
            if (err.name === 'NotReadableError') {
                console.log("[LIFECYCLE] Conflict! Cleaning up tracks and retrying...");
                await cleanupTracks();
                setTimeout(startScanner, 1000);
            }
        }
    }

    async function stopScanner() {
        console.log("[LIFECYCLE] Stopping scanner...");
        if (html5Qrcode && html5Qrcode.isScanning) {
            try {
                await html5Qrcode.stop();
                await html5Qrcode.clear();
                console.log("[LIFECYCLE] Scanner stopped and cleared.");
            } catch (err) { console.warn("Stop error", err); }
        }
        html5Qrcode = null; // Destroy instance as requested
        await cleanupTracks();
        return Promise.resolve();
    }

    function handleScanSuccess(txt) {
        isScanning = true;
        playBeep();
        
        if (!isTabletMode) {
            stopScanner().then(() => {
                setTimeout(() => processScanResult(txt), 500);
            });
        } else {
            stopTabletScan();
            processScanResult(txt);
        }
        setStatusBadge(false);
    }

    // IP Webcam Handling (Admin Pattern)
    elements.toggleTablet.addEventListener('change', function () {
        isTabletMode = this.checked;
        document.getElementById('panel-tablet-config').style.display = isTabletMode ? 'block' : 'none';
        elements.modeBadge.textContent = isTabletMode ? 'CAMERA: IP WEBCAM' : 'CAMERA: LOCAL';
        
        if (isTabletMode) {
            stopScanner().then(() => {
                elements.modeLaptop.style.display = 'none';
                elements.modeTablet.style.display = 'block';
                elements.resultContainer.style.display = 'none';
            });
        } else {
            stopTabletScan();
            elements.modeTablet.style.display = 'none';
            elements.modeLaptop.style.display = 'block';
            startScanner();
        }
    });

    elements.btnConnect.addEventListener('click', function () {
        const ip = elements.tabletIp.value.trim();
        if (!ip) return;
        localStorage.setItem('tablet_ip_vendor', ip);
        connectTabletStream(ip);
    });

    const savedIP = localStorage.getItem('tablet_ip_vendor');
    if (savedIP) elements.tabletIp.value = savedIP;

    function connectTabletStream(ip) {
        const baseUrl = `http://${ip}`;
        elements.tabletStatus.className = 'status-badge badge-waiting';
        elements.tabletStatus.textContent = 'Connecting...';
        elements.tabletError.style.display = 'none';
        
        const testImg = new Image();
        testImg.onload = () => {
            elements.tabletStatus.className = 'status-badge badge-active';
            elements.tabletStatus.textContent = 'Connected';
            elements.tabletImg.src = `${baseUrl}/video`;
            startTabletScan(`${baseUrl}/shot.jpg`);
        };
        testImg.onerror = () => {
            elements.tabletStatus.className = 'status-badge badge-waiting';
            elements.tabletStatus.textContent = 'Error';
            elements.tabletError.style.display = 'flex';
        };
        testImg.src = `${baseUrl}/shot.jpg?t=${Date.now()}`;
    }

    function startTabletScan(url) {
        stopTabletScan();
        isScanning = false;
        setStatusBadge(true);
        tabletTimer = setInterval(() => {
            if (isScanning) return;
            const snap = new Image();
            snap.crossOrigin = 'anonymous';
            snap.onload = () => {
                elements.captureCanvas.width = snap.naturalWidth || 640;
                elements.captureCanvas.height = snap.naturalHeight || 480;
                const ctx = elements.captureCanvas.getContext('2d');
                ctx.drawImage(snap, 0, 0);
                const data = ctx.getImageData(0, 0, elements.captureCanvas.width, elements.captureCanvas.height);
                const code = jsQR(data.data, data.width, data.height, { inversionAttempts: 'dontInvert' });
                if (code && !isScanning) handleScanSuccess(code.data);
            };
            snap.src = `${url}?t=${Date.now()}`;
        }, 400); 
    }

    function stopTabletScan() { clearInterval(tabletTimer); tabletTimer = null; }

    function setStatusBadge(active) {
        elements.statusBadge.className = active ? 'status-badge badge-active' : 'status-badge badge-waiting';
        elements.statusBadge.innerHTML = active ? '<span class="pulse-dot"></span> Active' : 'Idle';
    }

    function processScanResult(id) {
        elements.loading.style.setProperty('display', 'flex', 'important');
        
        fetch("{{ route('vendor.scanner.qr.get') }}", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body: JSON.stringify({ idpesanan: id })
        })
        .then(r => r.json())
        .then(res => {
            elements.loading.style.setProperty('display', 'none', 'important');
            if (res.success) {
                const p = res.pesanan;
                elements.resId.innerText = "#" + p.idpesanan;
                elements.resNama.innerText = p.nama_customer;
                elements.resTotal.innerText = "Rp " + Number(p.total).toLocaleString('id-ID');
                
                elements.resItems.innerHTML = '';
                res.detail.forEach(d => {
                    elements.resItems.innerHTML += `<tr><td class="ps-3">${d.nama_menu}</td><td class="text-center">${d.jumlah}x</td><td class="text-end pe-3">Rp ${Number(d.subtotal).toLocaleString('id-ID')}</td></tr>`;
                });

                elements.resultContainer.style.display = 'block';
                startCountdown();
            } else {
                console.warn("Order not found:", id);
                restartScanner();
            }
        })
        .catch(() => {
            elements.loading.style.setProperty('display', 'none', 'important');
            restartScanner();
        });
    }

    function startCountdown() {
        let sisa = 10;
        elements.countdown.textContent = sisa;
        elements.countdownPct.textContent = "100%";
        elements.resetProgress.style.transition = 'none';
        elements.resetProgress.style.width = '100%';
        
        setTimeout(() => {
            elements.resetProgress.style.transition = 'width 10s linear';
            elements.resetProgress.style.width = '0%';
        }, 100);

        clearInterval(countdownInterval);
        countdownInterval = setInterval(() => {
            sisa--;
            elements.countdown.textContent = sisa;
            elements.countdownPct.textContent = Math.round((sisa / 10) * 100) + "%";
            if (sisa <= 0) clearInterval(countdownInterval);
        }, 1000);

        clearTimeout(resetTimer);
        resetTimer = setTimeout(restartScanner, 10000);
    }

    function restartScanner() {
        console.log("[LIFECYCLE] Restarting scanner...");
        elements.resultContainer.style.display = 'none';
        isScanning = false;
        
        if (isTabletMode) {
            if (elements.tabletIp.value) connectTabletStream(elements.tabletIp.value);
        } else {
            // Apply mandatory delay before restart
            setTimeout(() => startScanner(), 800);
        }
    }
});
</script>
@endsection
