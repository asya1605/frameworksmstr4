@extends('layouts.admin.app')

@section('content')

<style>
*{box-sizing:border-box}
.form-wrap{max-width:580px;margin:2rem auto;padding:0 1rem}
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
.cam-box{background:#f3f4f6;border:0.5px solid #e5e7eb;border-radius:8px;aspect-ratio:4/3;overflow:hidden;display:flex;align-items:center;justify-content:center}
.cam-box video,.cam-box img{width:100%;height:100%;object-fit:cover}
.cam-placeholder{display:flex;flex-direction:column;align-items:center;gap:6px}
.cam-placeholder span{font-size:12px;color:#9ca3af}
.btn-row{display:flex;gap:10px;margin-top:1.5rem}
.btn-capture{flex:1;padding:10px 14px;border:0.5px solid #d1d5db;border-radius:8px;background:#f9fafb;color:#374151;font-size:14px;cursor:pointer;transition:background .15s}
.btn-capture:hover{background:#f3f4f6}
.btn-submit{flex:2;padding:10px 14px;border:none;border-radius:8px;background:#111827;color:#fff;font-size:14px;font-weight:500;cursor:pointer;transition:opacity .15s}
.btn-submit:hover{opacity:.85}
</style>

<div class="form-wrap">
  <div class="form-card">

    <p class="form-title">Tambah Customer</p>

    <form method="POST" action="{{ route('customer.storeFile') }}">
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

      <div class="cam-grid">
        <div>
          <p class="cam-label">Kamera</p>
          <div class="cam-box">
            <video id="video" autoplay playsinline style="display:none;width:100%;height:100%;object-fit:cover"></video>
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
let streaming = false;
const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const preview = document.getElementById('preview');
const camPlaceholder = document.getElementById('camPlaceholder');
const previewPlaceholder = document.getElementById('previewPlaceholder');
const toggleBtn = document.getElementById('toggleBtn');
const captureBtn = document.getElementById('captureBtn');

function toggleCamera() {
  if (!streaming) {
    navigator.mediaDevices.getUserMedia({ video: true })
      .then(stream => {
        video.srcObject = stream;
        video.style.display = 'block';
        camPlaceholder.style.display = 'none';
        captureBtn.style.display = 'block';
        toggleBtn.textContent = 'Matikan Kamera';
        streaming = true;
      })
      .catch(() => { toggleBtn.textContent = 'Kamera tidak tersedia'; });
  } else {
    video.srcObject?.getTracks().forEach(t => t.stop());
    video.style.display = 'none';
    camPlaceholder.style.display = 'flex';
    captureBtn.style.display = 'none';
    toggleBtn.textContent = 'Aktifkan Kamera';
    streaming = false;
  }
}

function ambilFoto() {
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  canvas.getContext('2d').drawImage(video, 0, 0);
  const image = canvas.toDataURL('image/png');
  document.getElementById('foto').value = image;
  preview.src = image;
  preview.style.display = 'block';
  previewPlaceholder.style.display = 'none';
}

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