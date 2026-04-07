@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-10 grid-margin stretch-card mx-auto">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title text-center mb-4">
                    <i class="mdi mdi-email-outline"></i>
                    Generate Undangan
                </h4>

                <form action="{{ url('/generate-undangan') }}" method="POST">
                    @csrf

                    {{-- === META SURAT ==== --}}
                    <h5 class="mb-3">Informasi Surat</h5>

                    <div class="form-group">
                        <label>Nomor Surat</label>
                        <input type="text" name="nomor" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Lampiran</label>
                        <input type="text" name="lampiran" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Surat</label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Perihal</label>
                        <input type="text" name="perihal" class="form-control" required>
                    </div>

                    <hr>

                    {{-- === PENERIMA === --}}
                    <h5 class="mb-3">Penerima</h5>

                    <div class="form-group">
                        <label>Daftar Penerima (pisahkan dengan koma)</label>
                        <textarea name="penerima" class="form-control" rows="3"
                            placeholder="Contoh: Para Dosen, Para Tendik, Ketua Prodi" required></textarea>
                    </div>

                    <hr>

                    {{-- === ISI SURAT === --}}
                    <h5 class="mb-3">Isi Surat</h5>

                    <div class="form-group">
                        <label>Isi Pembuka</label>
                        <textarea name="isi" class="form-control" rows="4" required></textarea>
                    </div>

                    <hr>

                    {{-- === DETAIL ACARA === --}}
                    <h5 class="mb-3">Detail Acara</h5>

                    <div class="form-group">
                        <label>Tanggal Acara</label>
                        <input type="date" name="tanggal_acara" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Waktu</label>
                        <input type="text" name="waktu" class="form-control" placeholder="Contoh: 10.00 WIB" required>
                    </div>

                    <div class="form-group">
                        <label>Tempat</label>
                        <input type="text" name="tempat" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Agenda</label>
                        <input type="text" name="agenda" class="form-control" required>
                    </div>


                    {{-- === PENUTUP === --}}
                    <h5 class="mb-3">Penutup</h5>

                    <div class="form-group">
                        <textarea name="penutup" class="form-control" rows="3" required></textarea>
                    </div>

                    <hr>

                    {{-- === TANDA TANGAN === --}}
                    <h5 class="mb-3">Tanda Tangan</h5>

                    <div class="form-group">
                        <label>Jabatan Penandatangan</label>
                        <input type="text" name="ttd_jabatan" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Nama Penandatangan</label>
                        <input type="text" name="ttd_nama" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>NIP Penandatangan</label>
                        <input type="text" name="ttd_nip" class="form-control" required>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="mdi mdi-file-pdf-box"></i>
                            Generate PDF
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection
