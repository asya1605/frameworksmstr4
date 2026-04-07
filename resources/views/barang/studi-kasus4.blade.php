@extends('layouts.app')

@section('title','Studi Kasus 4')

@section('content')

<div class="page-header">
<h3 class="page-title">Studi Kasus 4</h3>
</div>


<div class="row">

<!-- CARD SELECT BIASA -->

<div class="col-md-6">

<div class="card">

<div class="card-header">
<h4>Select</h4>
</div>

<div class="card-body">

<div class="mb-3">
<label>Kota :</label>
<input type="text" id="kotaInput" class="form-control">
</div>

<button class="btn btn-success mb-3" id="btnTambah">
Tambahkan
</button>

<div class="mb-3">
<label>Select Kota :</label>
<select id="selectKota" class="form-control">
<option value="">-- pilih kota --</option>
</select>
</div>

<div>
<label>Kota Terpilih :</label>
<p id="hasilKota"></p>
</div>

</div>
</div>

</div>



<!-- CARD SELECT2 -->

<div class="col-md-6">

<div class="card">

<div class="card-header">
<h4>Select2</h4>
</div>

<div class="card-body">

<div class="mb-3">
<label>Kota :</label>
<input type="text" id="kotaInput2" class="form-control">
</div>

<button class="btn btn-success mb-3" id="btnTambah2">
Tambahkan
</button>

<div class="mb-3">
<label>Select Kota :</label>
<select id="selectKota2" class="form-control">
<option value="">-- pilih kota --</option>
</select>
</div>

<div>
<label>Kota Terpilih :</label>
<p id="hasilKota2"></p>
</div>

</div>
</div>

</div>

</div>

@endsection


@section('scripts')

<!-- SELECT2 -->

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

$(document).ready(function(){

/* =========================
   SELECT BIASA
========================= */

$("#btnTambah").click(function(){

let kota = $("#kotaInput").val();

if(kota==""){
alert("Isi kota terlebih dahulu");
return;
}

$("#selectKota").append(
`<option value="${kota}">${kota}</option>`
);

$("#kotaInput").val("");

});

$("#selectKota").change(function(){

$("#hasilKota").text($(this).val());

});


/* =========================
   SELECT2
========================= */

$("#selectKota2").select2();

$("#btnTambah2").click(function(){

let kota = $("#kotaInput2").val();

if(kota==""){
alert("Isi kota terlebih dahulu");
return;
}

$("#selectKota2").append(
`<option value="${kota}">${kota}</option>`
).trigger('change');

$("#kotaInput2").val("");

});

$("#selectKota2").change(function(){

$("#hasilKota2").text($(this).val());

});

});

</script>

@endsection