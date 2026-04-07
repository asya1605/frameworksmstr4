@extends('layouts.app')

@section('title','Detail Transaksi')

@section('content')

<div class="page-header">
<h3 class="page-title">Detail Transaksi</h3>
</div>

<div class="card">
<div class="card-body">

<h5>Customer : {{ $pesanan->nama_customer }}</h5>
<h5>Total : Rp {{ number_format($pesanan->total) }}</h5>

<hr>

<table class="table table-bordered">

<thead class="table-dark">
<tr>
<th>Menu</th>
<th>Harga</th>
<th>Qty</th>
<th>Subtotal</th>
</tr>
</thead>

<tbody>

@foreach($detail as $d)

<tr>
<td>{{ $d->nama_menu }}</td>
<td>{{ $d->harga }}</td>
<td>{{ $d->jumlah }}</td>
<td>{{ $d->subtotal }}</td>
</tr>

@endforeach

</tbody>

</table>

</div>
</div>

@endsection