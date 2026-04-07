@extends('layouts.app')

@section('title','Master Vendor')

@section('content')

<div class="page-header">
<h3 class="page-title">Master Vendor</h3>
</div>

<a href="{{ route('vendor.create') }}" class="btn btn-primary mb-3">
Tambah Vendor
</a>

<table class="table table-bordered">

<thead>
<tr>
<th>ID</th>
<th>Nama Vendor</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

@foreach($vendor as $v)

<tr>

<td>{{ $v->idvendor }}</td>
<td>{{ $v->nama_vendor }}</td>

<td>

<a href="{{ route('vendor.edit',$v->idvendor) }}" class="btn btn-warning btn-sm">
Edit
</a>

<form action="{{ route('vendor.destroy',$v->idvendor) }}" method="POST" style="display:inline">

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