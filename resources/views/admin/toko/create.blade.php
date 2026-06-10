@extends('layouts.admin.app')

@section('style')
<style>
    :root {
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: rgba(255, 255, 255, 0.4);
        --primary-gradient: linear-gradient(135deg, #7c3aed, #ec4899);
        --purple-glow: 0 0 0 0.25rem rgba(124, 58, 237, 0.15);
    }

    .page-header {
        background: var(--primary-gradient);
        border-radius: 20px;
        padding: 30px;
        color: white;
        margin-bottom: 24px;
        box-shadow: 0 10px 25px -10px rgba(124, 58, 237, 0.5);
    }

    .page-header h1 {
        font-weight: 800;
        margin-bottom: 8px;
        color: white;
    }

    .page-header p {
        opacity: 0.9;
        margin-bottom: 0;
        font-size: 1rem;
    }

    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.05);
        padding: 30px;
    }

    .form-label {
        font-weight: 700;
        color: #4b5563;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: 12px;
        padding: 12px 16px;
        border: 1px solid #e5e7eb;
        background: rgba(255, 255, 255, 0.8);
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #7c3aed;
        box-shadow: var(--purple-glow);
        background: white;
    }

    .btn-gradient-primary {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 700;
        border-radius: 50px;
        padding: 12px 24px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.2);
    }

    .btn-gradient-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(124, 58, 237, 0.3);
        color: white;
        opacity: 0.9;
    }

    .btn-outline-custom {
        border: 2px solid #7c3aed;
        color: #7c3aed;
        font-weight: 700;
        border-radius: 50px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .btn-outline-custom:hover {
        background: #7c3aed;
        color: white;
    }

    .btn-location {
        background: #f0fdf4;
        border: 2px dashed #22c55e;
        color: #15803d;
        font-weight: 700;
        border-radius: 16px;
        padding: 15px;
        transition: all 0.3s ease;
        width: 100%;
        text-align: center;
    }

    .btn-location:hover {
        background: #dcfce7;
        transform: scale(1.01);
    }

    /* TOTAL CLEANUP: Remove all potential pseudo-icons and foreign characters */
    *::before, *::after {
        content: none !important;
        display: none !important;
    }
    
    .fas, .fa, .mdi, [class*="fa-"], [class*="mdi-"], .material-icons {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
        overflow: hidden !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    
    {{-- Hero Header --}}
    <div class="page-header d-flex flex-column flex-md-row align-items-md-center justify-content-between">
        <div>
            <h1>Tambah Toko Baru</h1>
            <p>Tambahkan toko dan koordinat GPS untuk validasi kunjungan vendor</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('admin.toko.index') }}" class="btn btn-light rounded-pill px-4 shadow-sm font-weight-bold text-primary">
                Kembali
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="glass-card">
                <form action="{{ route('admin.toko.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-5 mb-4">
                            <label class="form-label">Barcode Toko</label>
                            <div class="input-group">
                                <input type="text" name="barcode" id="barcode" class="form-control @error('barcode') is-invalid @enderror" value="{{ old('barcode') }}" required placeholder="TKOXXXXX">
                                <button type="button" class="btn btn-outline-custom ms-2" onclick="generateBarcode()">Auto</button>
                            </div>
                            @error('barcode') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-7 mb-4">
                            <label class="form-label">Nama Toko</label>
                            <input type="text" name="nama_toko" class="form-control @error('nama_toko') is-invalid @enderror" value="{{ old('nama_toko') }}" required placeholder="Contoh: Toko Berkah Jaya">
                            @error('nama_toko') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" required placeholder="Masukkan alamat lengkap toko..."></textarea>
                        @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label class="form-label">Latitude</label>
                            <input type="text" name="latitude" id="lat" class="form-control @error('latitude') is-invalid @enderror" value="{{ old('latitude') }}" required readonly placeholder="0.000000">
                            @error('latitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label">Longitude</label>
                            <input type="text" name="longitude" id="lng" class="form-control @error('longitude') is-invalid @enderror" value="{{ old('longitude') }}" required readonly placeholder="0.000000">
                            @error('longitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label">Accuracy (Meter)</label>
                            <input type="text" name="accuracy" id="acc" class="form-control @error('accuracy') is-invalid @enderror" value="{{ old('accuracy') }}" required readonly placeholder="0">
                            @error('accuracy') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <button type="button" onclick="getLocation()" class="btn-location">
                            Ambil Lokasi Saat Ini
                        </button>
                        <p class="text-center mt-2 mb-0"><small class="text-muted">*Pastikan Anda berada di depan toko saat mengambil lokasi agar data akurat.</small></p>
                    </div>

                    <hr class="my-4" style="opacity: 0.1;">
                    
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn-gradient-primary px-5">Simpan Toko</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function generateBarcode() {
    const timestamp = Date.now().toString().slice(-8);
    const random = Math.floor(Math.random() * 100).toString().padStart(2, '0');
    document.getElementById('barcode').value = 'TKO' + timestamp + random;
}

function getLocation() {
    if (navigator.geolocation) {
        const latInput = document.getElementById('lat');
        const lngInput = document.getElementById('lng');
        const accInput = document.getElementById('acc');
        
        latInput.value = "Mengambil...";
        lngInput.value = "Mengambil...";
        accInput.value = "Mengambil...";

        navigator.geolocation.getCurrentPosition(function(position) {
            latInput.value = position.coords.latitude;
            lngInput.value = position.coords.longitude;
            accInput.value = Math.round(position.coords.accuracy);
        }, function(error) {
            alert("Gagal mengambil lokasi: " + error.message);
            latInput.value = "";
            lngInput.value = "";
            accInput.value = "";
        }, {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        });
    } else {
        alert("Geolocation tidak didukung oleh browser ini.");
    }
}
</script>
@endsection
