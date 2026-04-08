@extends('layouts.admin.app')

@section('content')

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-book-plus"></i>
        </span> Tambah Buku
    </h3>

    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('buku.index') }}">Buku</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Tambah
            </li>
        </ul>
    </nav>
</div>

<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Form Tambah Buku</h4>
                <p class="card-description">Masukkan informasi buku baru</p>

                <form action="{{ route('buku.store') }}" method="POST" class="forms-sample">
                    @csrf

                    <div class="form-group">
                        <label>Kode Buku</label>
                        <input type="text"
                               name="kode"
                               class="form-control @error('kode') is-invalid @enderror"
                               placeholder="Masukkan kode buku"
                               value="{{ old('kode') }}"
                               required>

                        @error('kode')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Judul</label>
                        <input type="text"
                               name="judul"
                               class="form-control @error('judul') is-invalid @enderror"
                               placeholder="Masukkan judul buku"
                               value="{{ old('judul') }}"
                               required>

                        @error('judul')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Pengarang</label>
                        <input type="text"
                               name="pengarang"
                               class="form-control @error('pengarang') is-invalid @enderror"
                               placeholder="Masukkan nama pengarang"
                               value="{{ old('pengarang') }}"
                               required>

                        @error('pengarang')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="idkategori" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->idkategori }}"
                                    {{ old('idkategori') == $k->idkategori ? 'selected' : '' }}>
                                    {{ $k->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-gradient-primary me-2">
                        <i class="mdi mdi-content-save"></i> Simpan
                    </button>

                    <a href="{{ route('buku.index') }}" class="btn btn-light">
                        <i class="mdi mdi-arrow-left"></i> Kembali
                    </a>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection
