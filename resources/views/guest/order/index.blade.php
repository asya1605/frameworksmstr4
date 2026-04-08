<!DOCTYPE html>
<html>
<head>
<title>Pemesanan ATK</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head><body>
<div class="container">
<style>
    :root {
        --main:   #f48fb1;
        --light:  #fff0f5;
        --accent: #c2185b;
        --soft:   #fce4ec;
        --text:   #4a2c3a;
        --white:  #ffffff;
    }

    /* ── PAGE HEADER ── */
    .page-header { margin-bottom: 24px; }

    .page-header .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--accent);
        margin: 0;
    }

    /* ── CARD WRAPPER ── */
    .order-card {
        background: var(--white);
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 16px rgba(244, 143, 177, 0.15);
        margin-bottom: 24px;
    }

    /* ── FORM ── */
    .form-label {
        font-weight: 600;
        color: var(--text);
        margin-bottom: 6px;
        display: block;
    }

    .form-control {
        border: 1.5px solid #f8bbd0;
        border-radius: 10px;
        padding: 10px 14px;
        color: var(--text);
        width: 100%;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-control:focus {
        border-color: var(--main);
        box-shadow: 0 0 0 3px rgba(244, 143, 177, 0.2);
        outline: none;
    }

    /* ── DIVIDER ── */
    .pink-divider {
        border: none;
        border-top: 2px solid var(--soft);
        margin: 8px 0 24px;
    }

    /* ── SECTION TITLES ── */
    .section-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--accent);
        margin-bottom: 16px;
    }

    /* ── PRODUCT ITEMS ── */
    .product-item {
        background: var(--soft);
        border-radius: 12px;
        padding: 14px 16px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .product-item-name {
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--text);
    }

    .product-item-price {
        font-size: 0.85rem;
        color: var(--accent);
        margin-top: 2px;
    }

    .btn-tambah {
        background: var(--main);
        color: var(--white);
        border: none;
        border-radius: 20px;
        padding: 6px 16px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
        transition: background 0.2s, transform 0.15s;
    }

    .btn-tambah:hover {
        background: var(--accent);
        transform: translateY(-1px);
    }

    /* ── CART TABLE ── */
    .cart-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }

    .cart-table thead tr {
        background: var(--main);
        color: var(--white);
    }

    .cart-table thead th {
        padding: 10px 12px;
        font-weight: 600;
        text-align: center;
    }

    .cart-table thead th:first-child { border-radius: 10px 0 0 0; }
    .cart-table thead th:last-child  { border-radius: 0 10px 0 0; }

    .cart-table tbody td {
        padding: 10px 12px;
        text-align: center;
        border-bottom: 1px solid var(--soft);
        color: var(--text);
    }

    .cart-table tbody tr:hover { background: var(--light); }

    /* ── CART FOOTER ── */
    .cart-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 20px;
        margin-top: 16px;
        flex-wrap: wrap;
    }

    .total-label {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text);
        margin: 0;
    }

    .total-label span { color: var(--accent); }

    .btn-hapus {
        background: transparent;
        color: var(--accent);
        border: 1.5px solid var(--main);
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s, color 0.2s;
    }

    .btn-hapus:hover {
        background: var(--accent);
        color: var(--white);
        border-color: var(--accent);
    }

    .btn-checkout {
        background: var(--accent);
        color: var(--white);
        border: none;
        border-radius: 25px;
        padding: 10px 28px;
        font-size: 0.95rem;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s;
    }

    .btn-checkout:hover {
        background: #880e4f;
        transform: translateY(-2px);
    }


    body{
    font-family:'Poppins',sans-serif;
    background:linear-gradient(135deg,#fff0f5,#ffe4ec);
    padding:40px;
}

/* container */
.container{
    max-width:1100px;
    margin:auto;
}

/* hover produk */
.product-item{
    background:var(--soft);
    border-radius:12px;
    padding:12px 14px;
    margin-bottom:10px;
    display:flex;
    align-items:center;
    gap:12px;
    justify-content:space-between;
}

.product-item:hover{
    transform:translateY(-3px);
    box-shadow:0 6px 14px rgba(0,0,0,0.08);
}

/* animasi add to cart */
@keyframes cartFlash{
    0%{background:#fce4ec;}
    50%{background:#f8bbd0;}
    100%{background:#fce4ec;}
}

.flash{
    animation:cartFlash 0.5s ease;
}

/* tombol tambah animasi */
.btn-tambah:active{
    transform:scale(0.95);
}

.fadeItem{
    animation:fadeIn .4s ease;
}

@keyframes fadeIn{
    from{
        opacity:0;
        transform:translateY(10px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

.product-img{
    width:60px;
    height:60px;
    object-fit:cover;
    border-radius:10px;
    background:white;
    padding:4px;
}

.product-info{
    flex:1;
}
</style>


<!-- PAGE HEADER -->
<div class="page-header">
    <h3 class="page-title">Pemesanan Alat Tulis</h3>
</div>


<!-- PILIH VENDOR -->
<div class="order-card">
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Pilih Vendor</label>
                <select id="vendor" class="form-control">
                    <option value="">-- Pilih Vendor --</option>
                    @foreach($vendor as $v)
                        <option value="{{ $v->idvendor }}">{{ $v->nama_vendor }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<hr class="pink-divider">


<!-- PRODUK & KERANJANG -->
<div class="row g-4">

    <!-- PRODUK -->
    <div class="col-md-6">
        <div class="order-card" style="min-height: 300px;">
            <p class="section-title">Produk</p>
            <div id="menuList">
                <p style="color: #bbb; font-size: 0.9rem;">Pilih vendor terlebih dahulu.</p>
            </div>
        </div>
    </div>

    <!-- KERANJANG -->
    <div class="col-md-6">
        <div class="order-card">
            <p class="section-title">Keranjang</p>

            <table class="cart-table">
                <thead>
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

            <div class="cart-footer">
                <p class="total-label">Total : <span id="total">Rp 0</span></p>
                <button type="button" id="checkout" class="btn-checkout">Checkout</button>
            </div>
        </div>
    </div>

</div>




<!-- MIDTRANS SNAP -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    let cart  = [];
    let total = 0;


    /* ── LOAD MENU BERDASARKAN VENDOR ── */
    $("#vendor").change(function () {
        const id = $(this).val();

        if (!id) {
            $("#menuList").html('<p style="color:#bbb;font-size:0.9rem;">Pilih vendor terlebih dahulu.</p>');
            return;
        }

        $.get("/get-menu/" + id, function (data) {
            let html = "";

            data.forEach(function (item) {
            html += `
            <div class="product-item">

                <img class="product-img"
                    src="/images/${item.path_gambar}"
                    alt="${item.nama_menu}">

                <div class="product-info">
                    <div class="product-item-name">${item.nama_menu}</div>
                    <div class="product-item-price">
                        Rp ${Number(item.harga).toLocaleString('id-ID')}
                    </div>
                </div>

                <button class="btn-tambah addCart"
                    data-id="${item.idmenu}"
                    data-nama="${item.nama_menu}"
                    data-harga="${item.harga}">
                    + Tambah
                </button>

            </div>
            `;
            });

            $("#menuList").html(html);
        });
    });


    /* ── TAMBAH KE CART ── */
    $(document).on("click", ".addCart", function () {

    const btn = $(this);

    const id    = btn.data("id");
    const nama  = btn.data("nama");
    const harga = btn.data("harga");

    const existing = cart.find(item => item.id == id);

    if (existing) {
        existing.qty++;
    } else {
        cart.push({ id, nama, harga, qty: 1 });
    }

    renderCart();

    /* animasi keranjang */
    $(".cart-table").addClass("flash");

    setTimeout(()=>{
        $(".cart-table").removeClass("flash");
    },500);

});



    /* ── HAPUS ITEM ── */
    $(document).on("click", ".removeCart", function () {
        cart.splice($(this).data("index"), 1);
        renderCart();
    });


    /* ── RENDER CART ── */
    function renderCart() {
        let html = "";
        total = 0;

        cart.forEach(function (item, index) {
            const subtotal = item.harga * item.qty;
            total += subtotal;

            html += `
                <tr>
                    <td>${item.nama}</td>
                    <td>Rp ${Number(item.harga).toLocaleString('id-ID')}</td>
                    <td>${item.qty}</td>
                    <td>Rp ${subtotal.toLocaleString('id-ID')}</td>
                    <td>
                        <button class="btn-hapus removeCart" data-index="${index}">Hapus</button>
                    </td>
                </tr>
            `;
        });

        $("#cart").html(html);
        $("#total").text("Rp " + total.toLocaleString('id-ID'));
    }


    /* ── CHECKOUT ── */
    $("#checkout").click(function () {
        if (cart.length === 0) {
            alert("Keranjang masih kosong.");
            return;
        }

        $.ajax({
            url:  "/checkout",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                items:  cart,
                total:  total
            },
            success: function (res) {
                console.log("Checkout Response:", res);

                $.get("/payment/" + res.order_id, function (response) {
                    console.log("Payment Response:", response);

                    snap.pay(response.snap_token, {
                        onSuccess: function (result) {
                            alert("Pembayaran berhasil!");
                            location.reload();
                        },
                        onPending: function (result) {
                            alert("Menunggu pembayaran.");
                        },
                        onError: function (result) {
                            alert("Pembayaran gagal. Coba lagi.");
                        }
                    });
                });
            }
        });
    });
</script>

