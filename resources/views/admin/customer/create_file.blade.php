@extends('layouts.admin.app')

@section('content')

<style>
*{box-sizing:border-box}
.form-wrap{max-width:620px;margin:2rem auto;padding:0 1rem}
.form-card{background:#fff;border:0.5px solid #e5e7eb;border-radius:12px;padding:1.75rem;box-shadow:0 1px 3px rgba(0,0,0,.05)}
.form-title{font-size:18px;font-weight:500;margin-bottom:1.5rem;color:#111827}
.field{display:flex;flex-direction:column;gap:5px;margin-bottom:12px}
.field label{font-size:12px;color:#6b7280;font-weight:500;letter-spacing:.02em}
.field input,.field select{padding:9px 12px;border:0.5px solid #d1d5db;border-radius:8px;background:#f9fafb;color:#111827;font-size:14px;outline:none;transition:border .15s}
.field input:focus,.field select:focus{border-color:#9ca3af;background:#fff}
.grid-2{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.divider{border:none;border-top:0.5px solid #f0f0f0;margin:1.5rem 0}
.section-label{font-size:12px;font-weight:500;color:#6b7280;letter-spacing:.04em;text-transform:uppercase;margin-bottom:12px}
.cam-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.cam-label{font-size:13px;color:#6b7280;margin-bottom:8px}
.cam-box{background:#f3f4f6;border:0.5px solid #e5e7eb;border-radius:8px;aspect-ratio:4/3;overflow:hidden;display:flex;align-items:center;justify-content:center;position:relative}
.cam-box video,.cam-box img{width:100%;height:100%;object-fit:cover}
.cam-placeholder{display:flex;flex-direction:column;align-items:center;gap:6px}
.cam-placeholder span{font-size:12px;color:#9ca3af}
.btn-row{display:flex;gap:10px;margin-top:1.5rem;flex-wrap:wrap}
.btn-capture{flex:1;padding:10px 14px;border:0.5px solid #d1d5db;border-radius:8px;background:#f9fafb;color:#374151;font-size:14px;cursor:pointer;transition:background .15s;min-width:120px}
.btn-capture:hover{background:#f3f4f6}
.btn-submit{flex:2;padding:10px 14px;border:none;border-radius:8px;background:#111827;color:#fff;font-size:14px;font-weight:500;cursor:pointer;transition:opacity .15s}
.btn-submit:hover{opacity:.85}

/* Tablet panel */
.tablet-panel{background:#f0f7ff;border:1px solid #bfdbfe;border-radius:10px;padding:12px 14px;margin-bottom:14px}
.tablet-panel .row-input{display:flex;gap:8px;align-items:center;flex-wrap:wrap;margin-top:10px}
.tablet-panel input[type=text]{flex:1;min-width:180px;padding:8px 12px;border:1px solid #93c5fd;border-radius:8px;font-size:13px;outline:none;background:#fff}
.tablet-panel .btn-connect{padding:8px 16px;background:#1d4ed8;color:#fff;border:none;border-radius:8px;font-size:13px;cursor:pointer;white-space:nowrap}
.tablet-panel .btn-connect:hover{background:#1e40af}
.tablet-guide{margin-top:10px;padding:10px 12px;background:#fff;border-radius:8px;border:1px solid #dbeafe}
.tablet-guide ol{padding-left:1.2rem;margin:4px 0 0;font-size:12px;color:#4b5563;line-height:1.8}
#tab-status-badge-file{font-size:11px;padding:3px 10px;border-radius:20px;font-weight:600;display:none}
.badge-connecting{background:#fef3c7;color:#92400e}
.badge-ok{background:#d1fae5;color:#065f46}
.badge-fail{background:#fee2e2;color:#991b1b}

#tablet-stream-img-file{width:100%;height:100%;object-fit:cover;display:none}
</style>

<div class="form-wrap">
  <div class="form-card">

    <p class="form-title">Tambah Customer</p>

    <form method="POST" action="{{ route('customer.storeFile') }}" enctype="multipart/form-data">
      @csrf

      <div class="field">
        <label>Nama</label>
        <input type="text" name="nama" placeholder="Masukkan nama lengkap">
      </div>

      <div class="field">
        <label>Alamat</label>
        <input type="text" name="alamat" placeholder="Masukkan alamat">
      </div>

      <div class="grid-2">
        <div class="field">
          <label>Provinsi</label>
          <select id="province" name="provinsi">
            <option value="">Pilih Provinsi</option>
            @foreach($provinces as $p)
              <option value="{{ $p->id }}">{{ $p->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="field">
          <label>Kota</label>
          <select id="city" name="kota">
            <option value="">Pilih Kota</option>
          </select>
        </div>
        <div class="field">
          <label>Kecamatan</label>
          <select id="district" name="kecamatan">
            <option value="">Pilih Kecamatan</option>
          </select>
        </div>
        <div class="field">
          <label>Kelurahan</label>
          <select id="village" name="kelurahan">
            <option value="">Pilih Kelurahan</option>
          </select>
        </div>
        <div class="field">
          <label>Kode Pos</label>
          <input type="text" name="kodepos" placeholder="Masukkan kode pos">
        </div>
      </div>

      <hr class="divider">

      <p class="section-label">Foto Customer</p>

      {{-- ===== PANEL TABLET TOGGLE ===== --}}
      <div class="tablet-panel">
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
          <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" id="toggle-tablet-file" style="width:40px;height:20px;cursor:pointer;">
            <label class="form-check-label" for="toggle-tablet-file" style="font-size:13px;font-weight:600;color:#1d4ed8;margin-left:6px;">
              📱 Gunakan Kamera Tablet (IP Webcam)
            </label>
          </div>
          <span id="tab-status-badge-file"></span>
        </div>

        <div id="tablet-ip-row-file" style="display:none;">
          <div class="row-input">
            <span style="font-size:13px;color:#374151;">IP Tablet:</span>
            <input type="text" id="tablet-ip-file" placeholder="Contoh: 192.168.1.5:8080">
            <button type="button" class="btn-connect" id="btn-connect-file">🔌 Hubungkan</button>
          </div>
          <div class="tablet-guide">
            <strong style="font-size:12px;color:#1d4ed8;">📋 Cara Pakai:</strong>
            <ol>
              <li>Install <strong>IP Webcam</strong> di tablet (Play Store)</li>
              <li>Buka app → tekan <strong>"Start server"</strong></li>
              <li>Pastikan tablet & laptop di <strong>WiFi yang sama</strong></li>
              <li>Masukkan IP yang muncul di layar tablet, lalu klik <strong>Hubungkan</strong></li>
            </ol>
          </div>
        </div>
      </div>
      {{-- ===== END PANEL TABLET ===== --}}

      <div class="cam-grid">
        <div>
          <p class="cam-label" id="label-kamera-file">Kamera Laptop</p>
          <div class="cam-box">
            <video id="video" autoplay playsinline style="display:none;width:100%;height:100%;object-fit:cover"></video>
            <img id="tablet-stream-img-file" src="" alt="Stream Tablet">
            <div class="cam-placeholder" id="camPlaceholder">
              <span>📷</span>
              <span>Kamera tidak aktif</span>
            </div>
          </div>
        </div>
        <div>
          <p class="cam-label">Hasil Foto</p>
          <div class="cam-box">
            <img id="preview" style="display:none;width:100%;height:100%;object-fit:cover">
            <div class="cam-placeholder" id="previewPlaceholder">
              <span>🖼️</span>
              <span>Belum ada foto</span>
            </div>
          </div>
        </div>
      </div>

      <canvas id="canvas" style="display:none"></canvas>
      <input type="hidden" name="foto" id="foto">

      <div class="btn-row">
        <button type="button" class="btn-capture" id="toggleBtn" onclick="toggleCamera()">Aktifkan Kamera</button>
        <button type="button" class="btn-capture" id="captureBtn" onclick="ambilFoto()" style="display:none">Ambil Foto</button>
        <button type="submit" class="btn-submit">Simpan Customer</button>
      </div>

    </form>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// =============================
// STATE
// =============================
let streaming    = false;
let isTabletMode = false;
let currentTabletIP = '';
let streamPollTimer = null;

// =============================
// ELEMEN
// =============================
const video              = document.getElementById('video');
const canvas             = document.getElementById('canvas');
const preview            = document.getElementById('preview');
const camPlaceholder     = document.getElementById('camPlaceholder');
const previewPlaceholder = document.getElementById('previewPlaceholder');
const toggleBtn          = document.getElementById('toggleBtn');
const captureBtn         = document.getElementById('captureBtn');
const tabletStreamImg    = document.getElementById('tablet-stream-img-file');
const toggleTablet       = document.getElementById('toggle-tablet-file');
const tabletIpRow        = document.getElementById('tablet-ip-row-file');
const tabletIpInput      = document.getElementById('tablet-ip-file');
const btnConnect         = document.getElementById('btn-connect-file');
const tabStatusBadge     = document.getElementById('tab-status-badge-file');
const labelKamera        = document.getElementById('label-kamera-file');

// Restore saved IP
const savedIP = localStorage.getItem('tablet_ip');
if (savedIP) tabletIpInput.value = savedIP;

// =============================
// TOGGLE TABLET SWITCH
// =============================
toggleTablet.addEventListener('change', function () {
  isTabletMode = this.checked;

  if (isTabletMode) {
    tabletIpRow.style.display = 'block';
    labelKamera.textContent   = 'Kamera Tablet';

    if (streaming) {
      video.srcObject?.getTracks().forEach(t => t.stop());
      video.style.display          = 'none';
      camPlaceholder.style.display = 'flex';
      captureBtn.style.display     = 'none';
      streaming = false;
    }
    toggleBtn.textContent = 'Kamera Tablet Aktif';
    toggleBtn.disabled    = true;

  } else {
    tabletIpRow.style.display    = 'none';
    tabStatusBadge.style.display = 'none';
    labelKamera.textContent      = 'Kamera Laptop';
    toggleBtn.textContent        = 'Aktifkan Kamera';
    toggleBtn.disabled           = false;

    stopTabletStream();
    captureBtn.textContent = 'Ambil Foto';
  }
});

// =============================
// HUBUNGKAN TABLET
// =============================
btnConnect.addEventListener('click', connectTablet);
tabletIpInput.addEventListener('keydown', e => { if (e.key === 'Enter') connectTablet(); });

function connectTablet() {
  const ip = tabletIpInput.value.trim();
  if (!ip) { alert('Masukkan IP tablet terlebih dahulu.'); return; }
  localStorage.setItem('tablet_ip', ip);
  currentTabletIP = ip;

  setStatus('connecting', '⏳ Menghubungkan...');

  const snapshotUrl = `http://${ip}/shot.jpg`;
  const streamUrl   = `http://${ip}/video`;

  camPlaceholder.style.display  = 'none';
  tabletStreamImg.style.display = 'block';

  tabletStreamImg.src     = streamUrl;
  tabletStreamImg.onerror = function () {
    tabletStreamImg.src   = '';
    tabletStreamImg.onerror = null;
    startSnapshotPolling(snapshotUrl);
  };
  tabletStreamImg.onload = function () {
    setStatus('ok', '✅ Terhubung');
    captureBtn.style.display  = 'block';
    captureBtn.textContent    = '📸 Ambil Foto';
    tabletStreamImg.onload    = null;
  };

  setTimeout(() => {
    if (tabStatusBadge.classList.contains('badge-connecting')) {
      setStatus('fail', '❌ Gagal');
      tabletStreamImg.src           = '';
      tabletStreamImg.style.display = 'none';
      camPlaceholder.style.display  = 'flex';
      alert('Tidak bisa terhubung ke kamera tablet. Pastikan IP Webcam aktif dan IP benar.');
    }
  }, 6000);
}

function startSnapshotPolling(snapshotUrl) {
  let connected = false;

  function poll() {
    const ts  = Date.now();
    const tmp = new Image();
    tmp.onload = function () {
      if (!connected) {
        connected = true;
        setStatus('ok', '✅ Terhubung');
        captureBtn.style.display = 'block';
        captureBtn.textContent   = '📸 Ambil Foto';
      }
      tabletStreamImg.src           = `${snapshotUrl}?t=${ts}`;
      tabletStreamImg.style.display = 'block';
      camPlaceholder.style.display  = 'none';
      streamPollTimer = setTimeout(poll, 250);
    };
    tmp.onerror = function () {
      if (!connected) setStatus('fail', '❌ Gagal');
    };
    tmp.src = `${snapshotUrl}?t=${ts}`;
  }
  poll();
}

function stopTabletStream() {
  clearTimeout(streamPollTimer);
  tabletStreamImg.src           = '';
  tabletStreamImg.style.display = 'none';
  camPlaceholder.style.display  = 'flex';
  captureBtn.style.display      = 'none';
  currentTabletIP = '';
}

function setStatus(type, text) {
  tabStatusBadge.style.display = 'inline-block';
  tabStatusBadge.className     = `badge-${type}`;
  tabStatusBadge.textContent   = text;
}

// =============================
// AMBIL FOTO
// =============================
function ambilFoto() {
  if (isTabletMode) {
    const ip = currentTabletIP || tabletIpInput.value.trim();
    if (!ip) { alert('Hubungkan kamera tablet terlebih dahulu.'); return; }

    const snapUrl = `http://${ip}/shot.jpg?t=${Date.now()}`;
    const tmp = new Image();
    tmp.crossOrigin = 'anonymous';
    tmp.onload = function () {
      canvas.width  = tmp.naturalWidth  || 640;
      canvas.height = tmp.naturalHeight || 480;
      canvas.getContext('2d').drawImage(tmp, 0, 0);
      const image = canvas.toDataURL('image/png');
      document.getElementById('foto').value   = image;
      preview.src                             = image;
      preview.style.display                   = 'block';
      previewPlaceholder.style.display        = 'none';
    };
    tmp.onerror = function () {
      alert('Gagal mengambil foto dari tablet. Pastikan IP Webcam aktif.');
    };
    tmp.src = snapUrl;

  } else {
    canvas.width  = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0);
    const image = canvas.toDataURL('image/png');
    document.getElementById('foto').value   = image;
    preview.src                             = image;
    preview.style.display                   = 'block';
    previewPlaceholder.style.display        = 'none';
  }
}

// =============================
// MODE KAMERA LAPTOP
// =============================
function toggleCamera() {
  if (isTabletMode) return;

  if (!streaming) {
    navigator.mediaDevices.getUserMedia({ video: true })
      .then(stream => {
        video.srcObject              = stream;
        video.style.display          = 'block';
        camPlaceholder.style.display = 'none';
        captureBtn.style.display     = 'block';
        toggleBtn.textContent        = 'Matikan Kamera';
        streaming = true;
      })
      .catch(() => { toggleBtn.textContent = 'Kamera tidak tersedia'; });
  } else {
    video.srcObject?.getTracks().forEach(t => t.stop());
    video.style.display          = 'none';
    camPlaceholder.style.display = 'flex';
    captureBtn.style.display     = 'none';
    toggleBtn.textContent        = 'Aktifkan Kamera';
    streaming = false;
  }
}

// =============================
// WILAYAH (jQuery AJAX)
// =============================
$('#province').change(function () {
  const province_id = $(this).val();
  $('#city,#district,#village').html((i) =>
    `<option value="">${['Pilih Kota','Pilih Kecamatan','Pilih Kelurahan'][i]}</option>`
  );
  if (!province_id) return;
  $.post("{{ route('get.cities') }}", { _token: "{{ csrf_token() }}", province_id }, data => {
    $.each(data, (k, v) => $('#city').append(`<option value="${v.id}">${v.name}</option>`));
  });
});

$('#city').change(function () {
  const city_id = $(this).val();
  $('#district,#village').html((i) =>
    `<option value="">${['Pilih Kecamatan','Pilih Kelurahan'][i]}</option>`
  );
  if (!city_id) return;
  $.post("{{ route('get.districts') }}", { _token: "{{ csrf_token() }}", city_id }, data => {
    $.each(data, (k, v) => $('#district').append(`<option value="${v.id}">${v.name}</option>`));
  });
});

$('#district').change(function () {
  const district_id = $(this).val();
  $('#village').html('<option value="">Pilih Kelurahan</option>');
  if (!district_id) return;
  $.post("{{ route('get.villages') }}", { _token: "{{ csrf_token() }}", district_id }, data => {
    $.each(data, (k, v) => $('#village').append(`<option value="${v.id}">${v.name}</option>`));
  });
});
</script>

@endsection