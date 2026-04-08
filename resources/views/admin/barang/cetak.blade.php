<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>

@page {
    size: A4 portrait;
    margin-top: 12mm;
    margin-left: 8mm;
    margin-right: 8mm;
    margin-bottom: 12mm;
}

body{
    margin:0;
    font-family: Arial, sans-serif;
}

table{
    border-collapse: collapse;
}

td{
    width:38.18mm;
    height:22mm;
    padding:2mm;
    vertical-align:top;
}

.idbarang{
    font-size:9pt;
}

.nama{
    font-size:10pt;
    font-weight:bold;
}

.harga{
    font-size:10pt;
}

</style>
</head>

<body>

@php
$total = 40;
$currentBarang = 0;
@endphp

<table>

@for($row = 0; $row < 8; $row++)
<tr>

@for($col = 0; $col < 5; $col++)

@php
$index = $row * 5 + $col;
@endphp

<td>

@if($index >= $startIndex && isset($barang[$currentBarang]))

<div class="idbarang">
{{ $barang[$currentBarang]->id_barang }}
</div>

<div class="nama">
{{ $barang[$currentBarang]->nama }}
</div>

<div class="harga">
Rp {{ number_format($barang[$currentBarang]->harga,0,',','.') }}
</div>

@php $currentBarang++; @endphp

@endif

</td>

@endfor

</tr>
@endfor

</table>

</body>
</html>