@extends('layouts.app')

@section('title','Tambah Menu')

@section('content')

<div class="page-header">
<h3 class="page-title">Tambah Menu</h3>
</div>

<form action="{{ route('menu.store') }}" method="POST">

@csrf

<div class="form-group mb-3">
<label>Nama Menu</label>
<input type="text" name="nama_menu" class="form-control">
</div>

<div class="form-group mb-3">
<label>Harga</label>
<input type="number" name="harga" class="form-control">
</div>

<div class="form-group mb-3">
<label>Vendor</label>

<select name="idvendor" class="form-control">

@foreach($vendor as $v)

<option value="{{ $v->idvendor }}">
{{ $v->nama_vendor }}
</option>

@endforeach

</select>

</div>

<button class="btn btn-primary">Simpan</button>

</form>

@endsection