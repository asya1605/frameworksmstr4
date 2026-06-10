@extends('layouts.admin.app')

@section('style')
<style>
    :root {
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: rgba(255, 255, 255, 0.4);
        --primary-gradient: linear-gradient(135deg, #7c3aed, #ec4899);
        --pink-gradient: linear-gradient(135deg, #ff0080, #ff8c00);
    }

    .page-header {
        background: var(--primary-gradient);
        border-radius: 16px;
        padding: 24px 30px;
        color: white;
        margin-bottom: 24px;
        box-shadow: 0 10px 20px -10px rgba(124, 58, 237, 0.5);
    }

    .page-header h1 {
        font-weight: 800;
        margin-bottom: 5px;
        color: white;
    }

    .page-header p {
        opacity: 0.9;
        margin-bottom: 0;
        font-size: 0.95rem;
    }

    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.05);
        overflow: hidden;
    }

    .glass-card .card-header {
        background: transparent;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding: 20px 24px;
    }

    .table-modern th {
        border-top: none;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #6b7280;
        font-weight: 700;
        background: #f9fafb;
    }

    .table-modern td {
        vertical-align: middle;
        border-bottom: 1px solid #f3f4f6;
    }

    /* Barcode Sizing */
    .barcode-wrapper {
        display: inline-block;
        background: white;
        padding: 8px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        transform-origin: center center;
    }

    .barcode-img {
        width: auto !important;
        height: 80px !important;
        max-width: none !important;
        image-rendering: pixelated;
        object-fit: contain;
    }

    .btn-gradient-primary {
        background: var(--primary-gradient);
        border: none;
        color: white;
        transition: all 0.3s ease;
    }
    .btn-gradient-primary:hover {
        opacity: 0.9;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
    }

    /* Custom Badges */
    .acc-badge {
        padding: 6px 12px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    .acc-green { background: #dcfce7; color: #166534; }
    .acc-yellow { background: #fef08a; color: #854d0e; }
    .acc-red { background: #fee2e2; color: #991b1b; }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.8rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.2s ease;
        text-decoration: none !important;
    }
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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

    /* Ensure text only buttons look clean */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0 !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    
    {{-- Modern Header --}}
    <div class="page-header d-flex flex-column flex-md-row align-items-md-center justify-content-between">
        <div>
            <h1 class="h3">Data Toko</h1>
            <p>Kelola lokasi toko dan barcode kunjungan vendor</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('admin.toko.create') }}" class="btn btn-light rounded-pill px-4 shadow-sm font-weight-bold text-primary">
                Tambah Toko
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">x</span>
            </button>
        </div>
    @endif

    <div class="card glass-card">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold" style="color: #4f46e5;">Daftar Toko & Koordinat</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern table-hover mb-0" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th class="text-center" width="15%">Barcode</th>
                            <th width="20%">Nama Toko</th>
                            <th width="25%">Alamat & Koordinat</th>
                            <th class="text-center" width="10%">Accuracy</th>
                            <th class="text-center" width="25%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($toko as $index => $item)
                        <tr>
                            <td class="text-center text-muted font-weight-bold">{{ $index + 1 }}</td>
                            <td class="text-center">
                                @php
                                    $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
                                @endphp
                                <div class="barcode-wrapper mb-1">
                                    <img class="barcode-img" src="data:image/png;base64,{!! base64_encode($generator->getBarcode($item->barcode, $generator::TYPE_CODE_128, 3, 80)) !!}" data-barcode="{{ $item->barcode }}">
                                </div>
                                <div class="font-weight-bold text-dark small" style="letter-spacing: 1px;">{{ $item->barcode }}</div>
                            </td>
                            <td>
                                <div class="font-weight-bold text-dark mb-1" style="font-size: 1.05rem;">{{ $item->nama_toko }}</div>
                            </td>
                            <td>
                                <div class="text-muted small mb-2">{{ $item->alamat }}</div>
                                <div class="d-flex gap-2">
                                    <span class="badge bg-light text-dark border"><small>Lat: {{ $item->latitude }}</small></span>
                                    <span class="badge bg-light text-dark border"><small>Lng: {{ $item->longitude }}</small></span>
                                </div>
                            </td>
                            <td class="text-center">
                                @if($item->accuracy <= 50)
                                    <span class="acc-badge acc-green">{{ $item->accuracy }} m</span>
                                @elseif($item->accuracy <= 100)
                                    <span class="acc-badge acc-yellow">{{ $item->accuracy }} m</span>
                                @else
                                    <span class="acc-badge acc-red">{{ $item->accuracy }} m</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <a href="{{ route('admin.toko.edit', $item->idtoko) }}" class="btn btn-warning rounded-pill px-3 action-btn text-dark">
                                        Edit
                                    </a>
                                    <a href="{{ route('admin.toko.delete', $item->idtoko) }}" class="btn btn-danger rounded-pill px-3 action-btn" onclick="return confirm('Yakin ingin menghapus toko ini?')">
                                        Hapus
                                    </a>
                                    <button onclick="printBarcode('{{ $item->barcode }}', '{{ $item->nama_toko }}')" class="btn btn-gradient-primary rounded-pill px-3 action-btn">
                                        Cetak Barcode
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        
                        @if($toko->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <h5 class="text-muted">Belum ada data toko.</h5>
                                <a href="{{ route('admin.toko.create') }}" class="btn btn-sm btn-outline-primary mt-2 rounded-pill">Tambah Sekarang</a>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Hidden Print Area --}}
<div id="print-area" style="display:none;">
    <div style="text-align:center; padding:20px; border:1px solid #ccc; width:300px; margin:0 auto;">
        <h3 id="print-nama"></h3>
        <div id="print-barcode-img"></div>
        <p id="print-code" style="font-weight:bold; margin-top:10px;"></p>
    </div>
</div>

@endsection

@section('scripts')
<script>
function printBarcode(code, nama) {
    const printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Cetak Barcode</title>');
    printWindow.document.write('<style>body{font-family:"Inter", sans-serif;text-align:center;padding:40px; margin:0;} h2{margin-bottom:20px; color:#1e1b4b;}</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write('<h2>' + nama + '</h2>');
    
    // Using bwip-js API for clear printed barcode
    const barcodeUrl = "https://bwipjs-api.metafloor.com/?bcid=code128&text=" + code + "&scale=3&includetext=true&textxalign=center";
    printWindow.document.write('<img src="' + barcodeUrl + '" style="max-width:100%; border:1px dashed #ccc; padding:20px;">');
    
    printWindow.document.write('<script>window.onload = function() { setTimeout(()=>{ window.print(); window.close(); }, 500); };<\/script>');
    printWindow.document.write('</body></html>');
    printWindow.document.close();
}
</script>
@endsection
