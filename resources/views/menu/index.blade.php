@extends('layouts.app')

@section('title','Master Menu')

@section('content')

<div class="page-header">
<h3 class="page-title">Master Menu</h3>
</div>

<a href="{{ route('menu.create') }}" class="btn btn-primary mb-3">
Tambah Menu
</a>

<table class="table table-bordered">

<thead>
<tr>
<th>ID</th>
<th>Nama Menu</th>
<th>Harga</th>
<th>Vendor</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

@foreach($menu as $m)

<tr>

<td>{{ $m->idmenu }}</td>
<td>{{ $m->nama_menu }}</td>
<td>{{ $m->harga }}</td>
<td>{{ $m->nama_vendor }}</td>

<td>

<form action="{{ route('menu.destroy',$m->idmenu) }}" method="POST">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">
Delete
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

@endsection