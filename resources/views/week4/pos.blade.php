@extends('layouts.app')

@section('title','POS Kasir')

@section('content')

<div class="page-header">
    <h3 class="page-title">Point Of Sales</h3>
</div>

<div class="card">
<div class="card-body">

    <!-- ====================== FORM INPUT - ATAS ====================== -->
    <div class="row g-3 align-items-end mb-4">

        <div class="col-md-3">
            <label class="form-label">Kode Barang</label>
            <select id="kode" class="form-control">
                <option value="">-- Pilih Barang --</option>
                @foreach($barang as $b)
                <option
                    value="{{ $b->id_barang }}"
                    data-nama="{{ $b->nama }}"
                    data-harga="{{ $b->harga }}"
                >
                    {{ $b->id_barang }} - {{ $b->nama }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Nama Barang</label>
            <input type="text" id="nama" class="form-control" readonly>
        </div>

        <div class="col-md-2">
            <label class="form-label">Harga</label>
            <input type="text" id="harga" class="form-control" readonly>
        </div>

        <div class="col-md-1">
            <label class="form-label">Jumlah</label>
            <input type="number" id="jumlah" class="form-control" value="1" min="1">
        </div>

        <div class="col-md-3">
            <button id="btnTambah" class="btn w-100" disabled>
                + Tambahkan
            </button>
        </div>

    </div>

    <!-- ====================== TABEL TRANSAKSI - BAWAH ====================== -->
    <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle text-center">
        <thead>
            <tr>
                <th style="width:120px">Kode</th>
                <th>Nama</th>
                <th style="width:110px">Harga</th>
                <th style="width:100px">Jumlah</th>
                <th style="width:120px">Subtotal</th>
                <th style="width:80px">Aksi</th>
            </tr>
        </thead>
        <tbody id="tableBody"></tbody>
    </table>
    </div>

    <hr class="my-3">

    <div class="d-flex justify-content-between align-items-center">
        <button id="btnBayar" class="btn btn-bayar px-5">
            Bayar
        </button>
        <h4 class="mb-0">Total : <span id="total">0</span></h4>
    </div>

</div>
</div>

@endsection


@section('scripts')

<style>

/* === FORM === */
.form-label {
    font-size: 13px;
    font-weight: 500;
    color: #475569;
    margin-bottom: 5px;
    display: block;
}

.form-control {
    font-size: 14px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    padding: 8px 10px;
}

.form-control[readonly] {
    background-color: #f1f5f9;
    color: #94a3b8;
}

.form-control:focus {
    border-color: #a78bfa;
    box-shadow: 0 0 0 3px rgba(167,139,250,0.15);
}

/* === TOMBOL TAMBAHKAN === */
#btnTambah {
    background-color: #a78bfa;
    border: none;
    color: #fff;
    font-weight: 500;
    font-size: 14px;
    padding: 9px;
    border-radius: 8px;
    transition: background 0.2s;
}

#btnTambah:hover:not(:disabled) {
    background-color: #7c3aed;
}

#btnTambah:disabled {
    background-color: #c4b5fd;
    cursor: not-allowed;
}

/* === TOMBOL BAYAR === */
.btn-bayar {
    background-color: #10b981;
    border: none;
    color: #fff;
    font-weight: 500;
    font-size: 14px;
    padding: 9px 32px;
    border-radius: 8px;
    transition: background 0.2s;
}

.btn-bayar:hover {
    background-color: #059669;
    color: #fff;
}

/* === TABEL === */
.table thead th {
    background-color: #1e293b;
    color: #fff;
    font-weight: 500;
    font-size: 13px;
    vertical-align: middle;
    border-color: #334155;
}

.table td, .table th {
    vertical-align: middle;
    font-size: 14px;
}

.table tbody tr:hover {
    background-color: #f0fdf4;
}

/* === INPUT QTY DI TABEL === */
.qty {
    width: 60px !important;
    margin: auto;
    text-align: center;
    font-size: 14px;
    padding: 4px 6px;
    border-radius: 6px;
}

/* === TOMBOL HAPUS === */
.btnHapus {
    font-size: 12px;
    padding: 4px 10px;
    border-radius: 6px;
}

/* === TOTAL === */
#total {
    color: #059669;
    font-weight: 700;
}

/* === DIVIDER === */
hr.my-3 {
    border-color: #e2e8f0;
}

</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

/* ======================
PILIH BARANG
====================== */

$("#kode").change(function(){

let selected=$(this).find(":selected");

let nama=selected.data("nama");
let harga=selected.data("harga");

if(nama){

$("#nama").val(nama);
$("#harga").val(harga);
$("#jumlah").val(1);

$("#btnTambah").prop("disabled",false);

}else{

$("#nama").val("");
$("#harga").val("");

$("#btnTambah").prop("disabled",true);

}

});


/* ======================
TAMBAH KE TABEL
====================== */

$("#btnTambah").click(function(){

let kode=$("#kode").val();
let nama=$("#nama").val();
let harga=parseInt($("#harga").val());
let jumlah=parseInt($("#jumlah").val());

if(jumlah<=0){

Swal.fire("Error","Jumlah harus lebih dari 0","error");
return;

}

let subtotal=harga*jumlah;

let found=false;

$("#tableBody tr").each(function(){

let kodeTable=$(this).find(".kode").text();

if(kodeTable==kode){

let qty=parseInt($(this).find(".qty").val());

qty+=jumlah;

let sub=harga*qty;

$(this).find(".qty").val(qty);
$(this).find(".subtotal").text(sub);

found=true;

}

});

if(!found){

let row=`

<tr>

<td class="kode">${kode}</td>

<td class="text-start">${nama}</td>

<td class="text-end">${harga}</td>

<td>
<input type="number"
class="form-control qty text-center"
value="${jumlah}"
min="1"
style="width:60px;margin:auto">
</td>

<td class="subtotal text-end">${subtotal}</td>

<td>
<button class="btn btn-danger btn-sm btnHapus">
Hapus
</button>
</td>

</tr>

`;

$("#tableBody").append(row);

}

updateTotal();
resetForm();

});


/* ======================
RESET FORM
====================== */

function resetForm(){

$("#kode").val("");
$("#nama").val("");
$("#harga").val("");
$("#jumlah").val(1);

$("#btnTambah").prop("disabled",true);

}


/* ======================
UPDATE TOTAL
====================== */

function updateTotal(){

let total=0;

$(".subtotal").each(function(){

total+=parseInt($(this).text());

});

$("#total").text(total);

}


/* ======================
EDIT QTY
====================== */

$(document).on("change",".qty",function(){

let row=$(this).closest("tr");

let harga=parseInt(row.find("td:eq(2)").text());
let qty=parseInt($(this).val());

if(qty<=0){

$(this).val(1);
qty=1;

}

let subtotal=harga*qty;

row.find(".subtotal").text(subtotal);

updateTotal();

});


/* ======================
HAPUS BARANG
====================== */

$(document).on("click",".btnHapus",function(){

$(this).closest("tr").remove();

updateTotal();

});


/* ======================
BAYAR
====================== */

$("#btnBayar").click(function(){

if($("#tableBody tr").length==0){

Swal.fire("Warning","Belum ada transaksi","warning");
return;

}

let items=[];

$("#tableBody tr").each(function(){

let item={

kode:$(this).find(".kode").text(),
nama:$(this).find("td:eq(1)").text(),
harga:$(this).find("td:eq(2)").text(),
jumlah:$(this).find(".qty").val(),
subtotal:$(this).find(".subtotal").text()

};

items.push(item);

});

let total=$("#total").text();

$.ajax({

url:"{{ route('bayar') }}",
type:"POST",

data:{
_token:"{{ csrf_token() }}",
items:items,
total:total
},

success:function(response){

Swal.fire(
"Success",
response.message,
"success"
);

$("#tableBody").html("");
$("#total").text(0);

}

});

});

</script>

@endsection