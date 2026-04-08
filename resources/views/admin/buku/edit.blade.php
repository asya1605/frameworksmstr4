@extends('layouts.admin.app')

@section('content')

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-book-edit"></i>
        </span> Edit Buku
    </h3>

    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('buku.index') }}">Buku</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Edit
            </li>
        </ul>
    </nav>
</div>

<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Form Edit Buku</h4>
                <p class="card-description">Perbarui informasi buku</p>

                <form action="{{ route('buku.update', $buku->idbuku) }}" method="POST" class="forms-sample">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Kode Buku</label>
                        <input type="text" 
                               name="kode" 
                               class="form-control"
                               value="{{ $buku->kode }}" 
                               required>
                    </div>

                    <div class="form-group">
                        <label>Judul</label>
                        <input type="text" 
                               name="judul" 
                               class="form-control"
                               value="{{ $buku->judul }}" 
                               required>
                    </div>

                    <div class="form-group">
                        <label>Pengarang</label>
                        <input type="text" 
                               name="pengarang" 
                               class="form-control"
                               value="{{ $buku->pengarang }}" 
                               required>
                    </div>

                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="idkategori" class="form-control" required>
                            @foreach($kategori as $k)
                                <option value="{{ $k->idkategori }}"
                                    {{ $buku->idkategori == $k->idkategori ? 'selected' : '' }}>
                                    {{ $k->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-gradient-success me-2">
                        <i class="mdi mdi-check"></i> Update
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
