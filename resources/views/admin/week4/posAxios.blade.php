@extends('layouts.admin.app')

@section('title', 'POS Kasir AXIOS')

@section('content')

<div class="page-header">
    <h3 class="page-title">Point Of Sales (AXIOS)</h3>
</div>

<div class="card">
    <div class="card-body">

        <!-- ====================== FORM INPUT ====================== -->
        <div class="row g-3 align-items-end mb-4">

            <div class="col-md-3">
                <label class="form-label">Kode Barang</label>

                <select id="kode" class="form-control">
                    <option value="">-- Pilih Barang --</option>

                    @foreach ($barang as $b)
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
                <input
                    type="text"
                    id="nama"
                    class="form-control"
                    readonly
                >
            </div>

            <div class="col-md-2">
                <label class="form-label">Harga</label>
                <input
                    type="text"
                    id="harga"
                    class="form-control"
                    readonly
                >
            </div>

            <div class="col-md-1">
                <label class="form-label">Jumlah</label>
                <input
                    type="number"
                    id="jumlah"
                    class="form-control"
                    value="1"
                    min="1"
                >
            </div>

            <div class="col-md-3">
                <button
                    id="btnTambah"
                    class="btn w-100"
                    disabled
                >
                    + Tambahkan
                </button>
            </div>

        </div>


        <!-- ====================== TABEL ====================== -->
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

            <h4 class="mb-0">
                Total : <span id="total">0</span>
            </h4>

        </div>

    </div>
</div>

@endsection



@section('scripts')

<style>

.form-label {
    font-size: 13px;
    font-weight: 500;
    color: #475569;
    margin-bottom: 5px;
}

.form-control {
    border-radius: 8px;
}

.form-control[readonly] {
    background: #f1f5f9;
}

#btnTambah {
    background: #a78bfa;
    color: white;
    border: none;
    border-radius: 8px;
}

#btnTambah:disabled {
    background: #c4b5fd;
}

.btn-bayar {
    background: #10b981;
    color: white;
    border: none;
    border-radius: 8px;
}

.qty {
    color: #000 !important;
    -webkit-text-fill-color: #000 !important;
    opacity: 1 !important;
    background: #fff !important;
    border: 1px solid #ccc !important;
}


#total {
    color: #059669;
    font-weight: 700;
}

</style>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


<script>

// PILIH BARANG

$("#kode").change(function () {

    let selected = $(this).find(":selected");

    let nama = selected.data("nama");
    let harga = selected.data("harga");

    if (nama) {

        $("#nama").val(nama);
        $("#harga").val(harga);
        $("#jumlah").val(1);

        $("#btnTambah").prop("disabled", false);

    } else {

        $("#nama").val("");
        $("#harga").val("");

        $("#btnTambah").prop("disabled", true);

    }

});


// TAMBAH BARANG

$("#btnTambah").click(function () {

    let kode = $("#kode").val();
    let nama = $("#nama").val();
    let harga = parseInt($("#harga").val());
    let jumlah = parseInt($("#jumlah").val());

    if (jumlah <= 0) {

        Swal.fire("Error", "Jumlah harus lebih dari 0", "error");
        return;

    }

    let subtotal = harga * jumlah;

    let found = false;

    $("#tableBody tr").each(function () {

        let kodeTable = $(this).find(".kode").text();

        if (kodeTable == kode) {

            let qty = parseInt($(this).find(".qty").val());

            qty += jumlah;

            let hargaTable = parseInt($(this).find(".harga").text());

            let sub = hargaTable * qty;

            $(this).find(".qty").val(qty);
            $(this).find(".subtotal").text(sub);

            found = true;

        }

    });

    if (!found) {

        let row = `
        <tr>
            <td class="kode">${kode}</td>
            <td class="text-start">${nama}</td>
            <td class="harga text-end">${harga}</td>
            <td>
                <input
                    type="number"
                    class="form-control qty"
                    value="${jumlah}"
                    min="1"
                >
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


// RESET FORM

function resetForm() {

    $("#kode").val("");
    $("#nama").val("");
    $("#harga").val("");
    $("#jumlah").val(1);

    $("#btnTambah").prop("disabled", true);

}


// UPDATE TOTAL

function updateTotal() {

    let total = 0;

    $(".subtotal").each(function () {
        total += parseInt($(this).text());
    });

    $("#total").text(total);

}


// UPDATE SUBTOTAL SAAT QTY DIUBAH

$(document).on("change", ".qty", function () {

    let row = $(this).closest("tr");

    let harga = parseInt(row.find(".harga").text());
    let qty = parseInt($(this).val());

    if (qty <= 0) {
        $(this).val(1);
        qty = 1;
    }

    let subtotal = harga * qty;

    row.find(".subtotal").text(subtotal);

    updateTotal();

});


// HAPUS BARIS

$(document).on("click", ".btnHapus", function () {

    $(this).closest("tr").remove();

    updateTotal();

});


// BAYAR

$("#btnBayar").click(function () {

    if ($("#tableBody tr").length == 0) {

        Swal.fire("Warning", "Belum ada transaksi", "warning");
        return;

    }

    let items = [];

    $("#tableBody tr").each(function () {

        let item = {
            kode: $(this).find(".kode").text(),
            nama: $(this).find("td:eq(1)").text(),
            harga: parseInt($(this).find(".harga").text()),
            jumlah: parseInt($(this).find(".qty").val()),
            subtotal: parseInt($(this).find(".subtotal").text())
        };

        items.push(item);

    });

    let total = parseInt($("#total").text());

    axios.post("{{ route('bayar') }}", {
        items: items,
        total: total
    }, {
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    })

    .then(function (response) {

        Swal.fire(
            "Success",
            response.data.message,
            "success"
        );

        $("#tableBody").html("");
        $("#total").text(0);

    })

    .catch(function (error) {

        Swal.fire("Error", "Transaksi gagal", "error");

    });

});

</script>

@endsection