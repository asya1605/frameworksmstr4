@extends('layouts.app')

@section('title','Tambah Vendor')

@section('content')

<div class="page-header">
<h3 class="page-title">Tambah Vendor</h3>
</div>

<form action="{{ route('vendor.store') }}" method="POST">

@csrf

<div class="form-group mb-3">
<label>Nama Vendor</label>
<input type="text" name="nama_vendor" class="form-control" required>
</div>

<button type="submit" class="btn btn-primary">
Simpan
</button>

<a href="{{ route('vendor.index') }}" class="btn btn-secondary">
Kembali
</a>

</form>

@endsection