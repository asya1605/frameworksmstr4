@extends('layouts.admin.app')

@push('styles')
<style>
.icon-square {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-danger {
    background: linear-gradient(135deg, #ffa585 0%, #ffeda0 50%, #fb88b4 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #5fc3e4 0%, #e55d87 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #81FBB8 0%, #28C76F 100%);
}

.card-img-holder {
    position: relative;
    overflow: hidden;
}

.card-img-absolute {
    position: absolute;
    top: 0;
    right: 0;
    height: 100%;
    opacity: 0.3;
}

.stretch-card {
    display: flex;
    align-items: stretch;
    justify-content: stretch;
}

.stretch-card > .card {
    width: 100%;
    min-width: 100%;
}

.card-img-holder .card-body {
    position: relative;
    z-index: 1;
}
</style>
@endpush

@section('content')

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-home"></i>
        </span> Dashboard
    </h3>
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
            </li>
        </ul>
    </nav>
</div>

<div class="row">

    {{-- Total Buku --}}
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-danger card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Total Buku 
                    <i class="mdi mdi-book-multiple mdi-24px float-end"></i>
                </h4>
                <h2 class="mb-5">{{ number_format($totalBuku) }}</h2>
                <h6 class="card-text">Koleksi Perpustakaan</h6>
            </div>
        </div>
    </div>

    {{-- Total Kategori --}}
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-info card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Total Kategori 
                    <i class="mdi mdi-bookmark-outline mdi-24px float-end"></i>
                </h4>
                <h2 class="mb-5">{{ number_format($totalKategori) }}</h2>
                <h6 class="card-text">Jenis Kategori Buku</h6>
            </div>
        </div>
    </div>

    {{-- Statistik Tambahan --}}
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-success card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Status Sistem 
                    <i class="mdi mdi-check-circle mdi-24px float-end"></i>
                </h4>
                <h2 class="mb-5">Active</h2>
                <h6 class="card-text">Sistem Berjalan Normal</h6>
            </div>
        </div>
    </div>

</div>

{{-- Quick Actions --}}
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">
                    <i class="mdi mdi-flash text-warning"></i> Quick Actions
                </h4>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('buku.create') }}" class="btn btn-gradient-primary btn-lg btn-block">
                            <i class="mdi mdi-plus-circle"></i> Tambah Buku
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('kategori.create') }}" class="btn btn-gradient-info btn-lg btn-block">
                            <i class="mdi mdi-plus-circle"></i> Tambah Kategori
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('buku.index') }}" class="btn btn-gradient-success btn-lg btn-block">
                            <i class="mdi mdi-format-list-bulleted"></i> Lihat Buku
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('kategori.index') }}" class="btn btn-gradient-warning btn-lg btn-block">
                            <i class="mdi mdi-format-list-bulleted"></i> Lihat Kategori
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Detail Statistics --}}
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">
                        <i class="mdi mdi-chart-line text-primary"></i> Detail Statistik
                    </h4>
                    <a href="#" class="btn btn-sm btn-outline-primary">
                        <i class="mdi mdi-reload"></i> Refresh
                    </a>
                </div>
                <p class="text-muted mb-4">Data perpustakaan terkini</p>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                            <div class="icon-square bg-gradient-danger text-white me-3">
                                <i class="mdi mdi-book-multiple"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1">Total Buku</p>
                                <h3 class="text-primary mb-0">{{ number_format($totalBuku) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                            <div class="icon-square bg-gradient-info text-white me-3">
                                <i class="mdi mdi-bookmark-outline"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1">Total Kategori</p>
                                <h3 class="text-primary mb-0">{{ number_format($totalKategori) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                            <div class="icon-square bg-gradient-success text-white me-3">
                                <i class="mdi mdi-check-circle"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1">Status Sistem</p>
                                <h3 class="text-success mb-0">Active</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection