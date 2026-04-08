@extends('layouts.vendor.vendor')

@section('title','Detail Transaksi')

@section('style')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>

body, .vendor-content {
font-family: 'Plus Jakarta Sans', sans-serif;
}

/* HEADER */

.page-header{
display:flex;
align-items:center;
justify-content:space-between;
margin-bottom:22px;
}

.page-title{
font-size:1.2rem;
font-weight:700;
color:var(--vp-deeper);
margin:0;
display:flex;
align-items:center;
gap:10px;
}

.page-title-pill{
width:5px;
height:26px;
background:var(--vp-main);
border-radius:4px;
}

/* INFO CARD */

.info-card{
background:#fff;
border:1px solid #e5e1f8;
border-radius:14px;
padding:18px;
margin-bottom:18px;
}

.info-row{
display:flex;
justify-content:space-between;
margin-bottom:6px;
font-size:14px;
}

.info-label{
color:#9ca3af;
}

.info-value{
font-weight:600;
color:#1f1a2e;
}

/* TABLE CARD */

.table-card{
background:#fff;
border:1px solid #e5e1f8;
border-radius:14px;
overflow:hidden;
}

.menu-table{
width:100%;
border-collapse:collapse;
margin-bottom:0;
}

.menu-table thead tr{
background:#f8f7ff;
}

.menu-table th{
padding:11px 16px;
font-size:11px;
font-weight:700;
color:#9ca3af;
text-transform:uppercase;
letter-spacing:0.6px;
text-align:left;
border-bottom:1px solid #e5e1f8;
}

.menu-table td{
padding:13px 16px;
font-size:13px;
color:#1f1a2e;
border-bottom:1px solid #f3f0fb;
vertical-align:middle;
}

.menu-table tbody tr:last-child td{
border-bottom:none;
}

.menu-table tbody tr:hover td{
background:#faf9ff;
}

.total-text{
font-weight:700;
color:#0f6e56;
}

</style>

@endsection



@section('content')

<div class="page-header">

<h3 class="page-title">
<span class="page-title-pill"></span>
Detail Transaksi
</h3>

</div>


<!-- INFO PESANAN -->

<div class="info-card">

<div class="info-row">
<span class="info-label">Customer</span>
<span class="info-value">{{ $pesanan->nama_customer }}</span>
</div>

<div class="info-row">
<span class="info-label">Total</span>
<span class="info-value total-text">
Rp {{ number_format($pesanan->total,0,',','.') }}
</span>
</div>

</div>


<!-- DETAIL MENU -->

<div class="table-card">

<table class="menu-table">

<thead>

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

<td>
<strong>{{ $d->nama_menu }}</strong>
</td>

<td>
Rp {{ number_format($d->harga,0,',','.') }}
</td>

<td>
{{ $d->jumlah }}
</td>

<td class="total-text">
Rp {{ number_format($d->subtotal,0,',','.') }}
</td>

</tr>

@endforeach

</tbody>

</table>

</div>

@endsection