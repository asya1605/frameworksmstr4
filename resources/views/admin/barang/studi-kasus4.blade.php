@extends('layouts.admin.app')

@section('title', 'Studi Kasus 4')

@section('content')

<div class="page-header">
    <h3 class="page-title">Studi Kasus 4</h3>
</div>

<div class="card">
    <div class="card-body">

        <div class="select-wrapper">

            <!-- ================= LEFT ================= -->
            <div class="select-left">

                <div class="section-title">Select Biasa</div>

                <div class="form-group mb-3">
                    <label class="form-label">Kota</label>
                    <input
                        type="text"
                        id="kotaInput"
                        class="form-control"
                        placeholder="Masukkan nama kota"
                    >
                </div>

                <button
                    class="btn btn-success mb-4"
                    id="btnTambah"
                >
                    Tambahkan
                </button>

                <div class="form-group mb-3">
                    <label class="form-label">Select Kota</label>
                    <select id="selectKota" class="form-control">
                        <option value="">-- pilih kota --</option>
                    </select>
                </div>

                <div class="result-box">
                    <label>Kota Terpilih</label>
                    <div class="result-value" id="hasilKota">
                        Belum dipilih
                    </div>
                </div>

            </div>

            <div class="select-divider"></div>

            <!-- ================= RIGHT ================= -->
            <div class="select-right">

                <div class="section-title">Select2</div>

                <div class="form-group mb-3">
                    <label class="form-label">Kota</label>
                    <input
                        type="text"
                        id="kotaInput2"
                        class="form-control"
                        placeholder="Masukkan nama kota"
                    >
                </div>

                <button
                    class="btn btn-success mb-4"
                    id="btnTambah2"
                >
                    Tambahkan
                </button>

                <div class="form-group mb-3">
                    <label class="form-label">Select Kota</label>
                    <select id="selectKota2" class="form-control">
                        <option value="">-- pilih kota --</option>
                    </select>
                </div>

                <div class="result-box">
                    <label>Kota Terpilih</label>
                    <div class="result-value" id="hasilKota2">
                        Belum dipilih
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection


@section('scripts')

<link
    href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
    rel="stylesheet"
/>

<style>

/* WRAPPER */
.select-wrapper {
    display: flex;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    overflow: hidden;
}

/* LEFT */
.select-left {
    flex: 1;
    padding: 24px;
    background: #fff;
}

/* RIGHT */
.select-right {
    flex: 1;
    padding: 24px;
    background: #f8fafc;
}

/* DIVIDER */
.select-divider {
    width: 1px;
    background: #e2e8f0;
}

/* TITLE */
.section-title {
    font-size: 13px;
    font-weight: 600;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: .08em;
    margin-bottom: 20px;
}

/* LABEL */
.form-label {
    font-size: 13px;
    font-weight: 500;
    color: #475569;
    margin-bottom: 5px;
}

/* INPUT */
.form-control {
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    padding: 9px 12px;
    font-size: 14px;
}

/* RESULT */
.result-box {
    margin-top: 10px;
}

.result-box label {
    font-size: 12px;
    color: #94a3b8;
}

.result-value {
    margin-top: 4px;
    font-weight: 500;
    color: #1e293b;
}

</style>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

$(document).ready(function () {

    /* SELECT BIASA */

    $("#btnTambah").click(function () {

        let kota = $("#kotaInput").val();

        if (kota == "") {
            alert("Isi kota terlebih dahulu");
            return;
        }

        $("#selectKota").append(
            `<option value="${kota}">${kota}</option>`
        );

        $("#kotaInput").val("");

    });

    $("#selectKota").change(function () {

        let val = $(this).val();

        $("#hasilKota").text(val == "" ? "Belum dipilih" : val);

    });


    /* SELECT2 */

    $("#selectKota2").select2();

    $("#btnTambah2").click(function () {

        let kota = $("#kotaInput2").val();

        if (kota == "") {
            alert("Isi kota terlebih dahulu");
            return;
        }

        $("#selectKota2")
            .append(`<option value="${kota}">${kota}</option>`)
            .trigger('change');

        $("#kotaInput2").val("");

    });

    $("#selectKota2").change(function () {

        let val = $(this).val();

        $("#hasilKota2").text(val == "" ? "Belum dipilih" : val);

    });

});

</script>

@endsection