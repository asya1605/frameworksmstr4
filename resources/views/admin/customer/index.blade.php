@extends('layouts.admin.app')

@section('title','Data Customer')

@section('content')

<div class="page-header">
    <h3 class="page-title">Data Customer</h3>
</div>

<div class="card">
<div class="card-body">

<div class="d-flex justify-content-between align-items-center mb-3">

<div>
<a href="{{ route('customer.createBlob') }}" class="btn btn-primary btn-sm">
    Tambah Customer 1
</a>

<a href="{{ route('customer.createFile') }}" class="btn btn-success btn-sm">
    Tambah Customer 2
</a>
</div>

</div>


<div class="table-responsive">

<table class="table table-bordered table-striped align-middle text-center">

<thead>
<tr>
<th style="width:200px">Nama</th>
<th>Alamat</th>
<th style="width:120px">Foto</th>
</tr>
</thead>

<tbody>

@foreach($customer as $c)

<tr>

<td class="text-start">{{ $c->nama }}</td>

<td class="text-start">{{ $c->alamat }}</td>

<td>

{{-- Jika foto disimpan sebagai BLOB --}}
@if(!empty($c->foto_blob))
<img src="data:image/png;base64,{{ base64_encode($c->foto_blob) }}"
width="80"
class="img-customer"
alt="Foto Customer">

{{-- Jika foto disimpan sebagai FILE --}}
@elseif(!empty($c->foto_path))
<img src="{{ asset($c->foto_path) }}"
width="80"
class="img-customer"
alt="Foto Customer">

{{-- Jika tidak ada foto --}}
@else
<span class="text-muted">Tidak ada foto</span>
@endif

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>
</div>

@endsection



@section('scripts')

<style>

/* === TABEL HEADER === */
.table thead th {
    background-color: #1e293b;
    color: #fff;
    font-weight: 500;
    font-size: 13px;
    vertical-align: middle;
    border-color: #334155;
}

/* === TABEL BODY === */
.table td, .table th {
    vertical-align: middle;
    font-size: 14px;
}

/* === HOVER ROW === */
.table tbody tr:hover {
    background-color: #f0fdf4;
}

/* === FOTO CUSTOMER === */
.img-customer {
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    padding: 2px;
    background: #fff;
}

/* === BUTTON === */
.btn-primary {
    background-color: #a78bfa;
    border: none;
}

.btn-primary:hover {
    background-color: #7c3aed;
}

.btn-success {
    background-color: #10b981;
    border: none;
}

.btn-success:hover {
    background-color: #059669;
}

</style>

@endsection