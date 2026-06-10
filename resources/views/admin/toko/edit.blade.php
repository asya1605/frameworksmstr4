@extends('layouts.admin.app')

@section('style')
<style>
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

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0 !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Toko</h1>
        <a href="{{ route('admin.toko.index') }}" class="btn btn-secondary shadow-sm">
            Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Toko</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.toko.update', $toko->idtoko) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Barcode Toko</label>
                        <input type="text" name="barcode" class="form-control @error('barcode') is-invalid @enderror" value="{{ old('barcode', $toko->barcode) }}" required>
                        @error('barcode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Nama Toko</label>
                        <input type="text" name="nama_toko" class="form-control @error('nama_toko') is-invalid @enderror" value="{{ old('nama_toko', $toko->nama_toko) }}" required>
                        @error('nama_toko') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label>Alamat Lengkap</label>
                    <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" required>{{ old('alamat', $toko->alamat) }}</textarea>
                    @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Latitude</label>
                        <input type="text" name="latitude" id="lat" class="form-control @error('latitude') is-invalid @enderror" value="{{ old('latitude', $toko->latitude) }}" required>
                        @error('latitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Longitude</label>
                        <input type="text" name="longitude" id="lng" class="form-control @error('longitude') is-invalid @enderror" value="{{ old('longitude', $toko->longitude) }}" required>
                        @error('longitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Accuracy (Meter)</label>
                        <input type="text" name="accuracy" id="acc" class="form-control @error('accuracy') is-invalid @enderror" value="{{ old('accuracy', $toko->accuracy) }}" required>
                        @error('accuracy') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <button type="button" onclick="getLocation()" class="btn btn-info btn-block">
                        Update Lokasi Baru
                    </button>
                </div>

                <hr>
                <button type="submit" class="btn btn-primary px-4">Update Toko</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function getLocation() {
    if (navigator.geolocation) {
        document.getElementById('lat').value = "Mengambil...";
        document.getElementById('lng').value = "Mengambil...";
        document.getElementById('acc').value = "Mengambil...";

        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById('lat').value = position.coords.latitude;
            document.getElementById('lng').value = position.coords.longitude;
            document.getElementById('acc').value = position.coords.accuracy;
        }, function(error) {
            alert("Gagal mengambil lokasi: " + error.message);
        }, {
            enableHighAccuracy: true
        });
    } else {
        alert("Geolocation tidak didukung oleh browser ini.");
    }
}
</script>
@endsection
