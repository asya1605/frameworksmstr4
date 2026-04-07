@extends('layouts.app')

@section('title','Data Transaksi')

@section('content')

<div class="page-header">
<h3 class="page-title">Data Transaksi</h3>
</div>

<div class="card">
<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered table-striped">

<thead class="table-dark text-center">
<tr>
<th>ID</th>
<th>Customer</th>
<th>Total</th>
<th>Metode</th>
<th>Status</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

@if($data && count($data) > 0)

@foreach($data as $t)

<tr>

<td class="text-center">
{{ $t->idpesanan }}
</td>

<td>
{{ $t->nama_customer }}
</td>

<td>
Rp {{ number_format($t->total,0,',','.') }}
</td>

<td class="text-center">
{{ $t->metode_bayar }}
</td>

<td class="text-center">

@if($t->status_bayar == 0)

<span class="badge bg-warning">
Pending
</span>

@else

<span class="badge bg-success">
Paid
</span>

@endif

</td>

<td class="text-center">

<a href="{{ url('/transaksi/detail/'.$t->idpesanan) }}"
class="btn btn-sm btn-info">

Detail

</a>

</td>

</tr>

@endforeach

@else

<tr>
<td colspan="6" class="text-center">
Tidak ada transaksi
</td>
</tr>

@endif

</tbody>

</table>

</div>
</div>
</div>

@endsection