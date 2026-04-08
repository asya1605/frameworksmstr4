@extends('layouts.admin.app')

@section('title','Studi Kasus 2 & 3')

@section('content')

<style>
#tableBody tr{
cursor:pointer;
}
</style>

<div class="page-header">
<h3 class="page-title">Studi Kasus - Table HTML</h3>
</div>

<div class="card">
<div class="card-body">

<form id="formBarang">

<div class="form-group mb-3">
<label>Nama Barang</label>
<input type="text"
id="nama"
class="form-control"
required>
</div>

<div class="form-group mb-3">
<label>Harga Barang</label>
<input type="number"
id="harga"
class="form-control"
required>
</div>

<button type="button"
id="btnSubmit"
class="btn btn-success">
Submit
</button>

</form>

<hr>

<div class="table-responsive mt-3">

<table class="table table-bordered">

<thead>
<tr>
<th>ID Barang</th>
<th>Nama</th>
<th>Harga</th>
</tr>
</thead>

<tbody id="tableBody">
</tbody>

</table>

</div>

</div>
</div>


<!-- MODAL EDIT -->

<div class="modal fade" id="editModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Edit Barang</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<div class="mb-3">
<label>ID Barang</label>
<input type="text"
id="editId"
class="form-control"
readonly>
</div>

<div class="mb-3">
<label>Nama Barang</label>
<input type="text"
id="editNama"
class="form-control"
required>
</div>

<div class="mb-3">
<label>Harga Barang</label>
<input type="number"
id="editHarga"
class="form-control"
required>
</div>

</div>

<div class="modal-footer">

<button class="btn btn-danger" id="btnDelete">
Hapus
</button>

<button class="btn btn-success" id="btnUpdate">
Ubah
</button>

</div>

</div>
</div>
</div>

@endsection


@section('scripts')

<script>

$(document).ready(function(){

let idBarang = 1;
let selectedRow = null;


/* =========================
   SUBMIT DATA
========================= */

$("#btnSubmit").click(function(){

let form = document.getElementById("formBarang");

if(!form.checkValidity()){
form.reportValidity();
return;
}

$("#btnSubmit").html(
'<span class="spinner-border spinner-border-sm"></span> Processing...'
);

$("#btnSubmit").prop("disabled",true);

let nama = $("#nama").val();
let harga = $("#harga").val();

let row = `
<tr>
<td>${idBarang}</td>
<td>${nama}</td>
<td>${harga}</td>
</tr>
`;

$("#tableBody").append(row);

idBarang++;

$("#nama").val("");
$("#harga").val("");

$("#btnSubmit").html("Submit");
$("#btnSubmit").prop("disabled",false);

});


/* =========================
   CLICK ROW → OPEN MODAL
========================= */

$("#tableBody").on("click","tr",function(){

selectedRow = $(this);

let id = $(this).find("td:eq(0)").text();
let nama = $(this).find("td:eq(1)").text();
let harga = $(this).find("td:eq(2)").text();

$("#editId").val(id);
$("#editNama").val(nama);
$("#editHarga").val(harga);

$("#editModal").modal("show");

});


/* =========================
   UPDATE DATA
========================= */

$("#btnUpdate").click(function(){

if($("#editNama").val()=="" || $("#editHarga").val()==""){
alert("Nama dan Harga harus diisi");
return;
}

selectedRow.find("td:eq(1)").text($("#editNama").val());
selectedRow.find("td:eq(2)").text($("#editHarga").val());

$("#editModal").modal("hide");

});


/* =========================
   DELETE DATA
========================= */

$("#btnDelete").click(function(){

selectedRow.remove();

$("#editModal").modal("hide");

});

});

</script>

@endsection