@extends('layouts.app')

@section('title','Pemesanan ATK')

@section('content')

<div class="page-header">
    <h3 class="page-title">Pemesanan Alat Tulis</h3>
</div>

<div class="row">

<div class="col-md-4">

<div class="form-group mb-3">

<label>Pilih Vendor</label>

<select id="vendor" class="form-control">

<option value="">-- Pilih Vendor --</option>

@foreach($vendor as $v)

<option value="{{ $v->idvendor }}">
{{ $v->nama_vendor }}
</option>

@endforeach

</select>

</div>

</div>

</div>

<hr>

<div class="row">

<!-- PRODUK -->
<div class="col-md-6">

<h5>Produk</h5>

<div id="menuList"></div>

</div>


<!-- KERANJANG -->
<div class="col-md-6">

<h5>Keranjang</h5>

<table class="table table-bordered text-center">

<thead class="table-dark">

<tr>
<th>Nama</th>
<th>Harga</th>
<th>Qty</th>
<th>Subtotal</th>
<th>Aksi</th>
</tr>

</thead>

<tbody id="cart"></tbody>

</table>

<div class="text-end">

<h4>Total : <span id="total">0</span></h4>

<button type="button" id="checkout" class="btn btn-success mt-2">
Checkout
</button>

</div>

</div>

</div>

@endsection


@section('scripts')

<!-- SCRIPT MIDTRANS (WAJIB ADA) -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>

let cart=[];
let total=0;


/* =========================
LOAD MENU BERDASARKAN VENDOR
========================= */

$("#vendor").change(function(){

let id=$(this).val();

if(!id){
$("#menuList").html("");
return;
}

$.get("/get-menu/"+id,function(data){

let html="";

data.forEach(function(item){

html+=`

<div class="card mb-2 p-2">

<b>${item.nama_menu}</b>

<br>

Harga : ${item.harga}

<br>

<button class="btn btn-sm btn-primary mt-2 addCart"
data-id="${item.idmenu}"
data-nama="${item.nama_menu}"
data-harga="${item.harga}">

Tambah

</button>

</div>

`;

});

$("#menuList").html(html);

});

});


/* =========================
TAMBAH KE CART
========================= */

$(document).on("click",".addCart",function(){

let id=$(this).data("id");
let nama=$(this).data("nama");
let harga=$(this).data("harga");

let found=false;

cart.forEach(function(item){

if(item.id==id){
item.qty++;
found=true;
}

});

if(!found){

cart.push({
id:id,
nama:nama,
harga:harga,
qty:1
});

}

renderCart();

});


/* =========================
HAPUS ITEM
========================= */

$(document).on("click",".removeCart",function(){

let index=$(this).data("index");

cart.splice(index,1);

renderCart();

});


/* =========================
RENDER CART
========================= */

function renderCart(){

let html="";
total=0;

cart.forEach(function(item,index){

let subtotal=item.harga*item.qty;

total+=subtotal;

html+=`

<tr>

<td>${item.nama}</td>
<td>${item.harga}</td>
<td>${item.qty}</td>
<td>${subtotal}</td>

<td>

<button class="btn btn-danger btn-sm removeCart"
data-index="${index}">
Hapus
</button>

</td>

</tr>

`;

});

$("#cart").html(html);
$("#total").text(total);

}


/* =========================
CHECKOUT
========================= */

$("#checkout").click(function(){

if(cart.length==0){

alert("Keranjang kosong");
return;

}

$.ajax({

url:"/checkout",
type:"POST",

data:{
_token:"{{ csrf_token() }}",
items:cart,
total:total
},

success:function(res){

console.log("Checkout Response:",res);

let order_id = res.order_id;

/* =========================
REQUEST SNAP TOKEN
========================= */

$.get("/payment/"+order_id,function(response){

console.log("Payment Response:",response);

snap.pay(response.snap_token,{

onSuccess:function(result){
alert("Pembayaran berhasil");
location.reload();
},

onPending:function(result){
alert("Menunggu pembayaran");
},

onError:function(result){
alert("Pembayaran gagal");
}

});

});

}

});

});

</script>

@endsection