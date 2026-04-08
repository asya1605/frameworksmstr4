@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-10 grid-margin stretch-card mx-auto">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title text-center mb-4">
                    <i class="mdi mdi-certificate-outline"></i>
                    Generate Sertifikat
                </h4>

                <form action="{{ url('/generate-sertifikat') }}" method="POST">
                    @csrf

                    {{-- === DATA PESERTA === --}}
                    <h5 class="mb-3">Data Peserta</h5>

                    <div class="form-group">
                        <label>Nomor Sertifikat</label>
                        <input type="text" name="nomor" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Jabatan</label>
                        <input type="text" name="jabatan" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Nama Acara</label>
                        <input type="text" name="acara" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Penyelenggara</label>
                        <input type="text" name="penyelenggara" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Acara</label>
                        <input type="date" name="tanggal_acara" class="form-control" required>
                    </div>

                    <hr>

                    {{-- === DATA PENANDATANGAN === --}}
                    <h5 class="mb-3">Data Penandatangan</h5>

                    {{-- DEKAN --}}
                    <div class="form-group">
                        <label>Label Jabatan Dekan</label>
                        <input type="text" name="label_dekan" class="form-control" 
                               placeholder="Contoh: Dekan FIKKIA UNAIR" required>
                    </div>

                    <div class="form-group">
                        <label>Nama Dekan</label>
                        <input type="text" name="nama_dekan" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>NIP Dekan</label>
                        <input type="text" name="nip_dekan" class="form-control" required>
                    </div>

                    {{-- KOORDINATOR --}}
                    <div class="form-group">
                        <label>Label Jabatan Koordinator</label>
                        <textarea name="label_koordinator" class="form-control" rows="2"
                            placeholder="Bisa enter untuk baris baru" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Nama Koordinator</label>
                        <input type="text" name="nama_koordinator" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>NIP Koordinator</label>
                        <input type="text" name="nip_koordinator" class="form-control" required>
                    </div>

                    {{-- KETUA --}}
                    <div class="form-group">
                        <label>Label Jabatan Ketua</label>
                        <input type="text" name="label_ketua" class="form-control" 
                               placeholder="Contoh: Ketua Pelaksana" required>
                    </div>

                    <div class="form-group">
                        <label>Nama Ketua</label>
                        <input type="text" name="nama_ketua" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>NIM Ketua</label>
                        <input type="text" name="nim_ketua" class="form-control" required>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="mdi mdi-file-pdf"></i>
                            Generate PDF
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection
