@extends('layouts.app')

@section('title', 'Tambah Barang')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h3 class="page-title mb-0">Tambah Barang</h3>
    <a href="{{ route('barang.index') }}" class="btn-kembali">
        &larr; Kembali
    </a>
</div>

<div class="card">
<div class="card-body">

    <div class="form-wrapper">

        <form id="formBarang" action="{{ route('barang.store') }}" method="POST">
        @csrf

            <div class="form-group mb-4">
                <label class="form-label">Nama Barang</label>
                <input type="text"
                       name="nama"
                       class="form-control"
                       placeholder="Masukkan nama barang"
                       required>
            </div>

            <div class="form-group mb-4">
                <label class="form-label">Harga</label>
                <div class="input-prefix-wrapper">
                    <span class="input-prefix">Rp</span>
                    <input type="number"
                           name="harga"
                           class="form-control with-prefix"
                           placeholder="0"
                           min="0"
                           required>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" id="btnSubmit" class="btn-simpan">
                    Simpan
                </button>
            </div>

        </form>

    </div>

</div>
</div>

@endsection


@section('scripts')

<style>

/* === TOMBOL KEMBALI === */
.btn-kembali {
    font-size: 13px;
    font-weight: 500;
    color: #64748b;
    text-decoration: none;
    padding: 7px 14px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    background: #fff;
    transition: all 0.2s;
}

.btn-kembali:hover {
    background: #f1f5f9;
    color: #1e293b;
}

/* === FORM WRAPPER === */
.form-wrapper {
    max-width: 480px;
}

/* === LABEL === */
.form-label {
    font-size: 13px;
    font-weight: 500;
    color: #475569;
    margin-bottom: 6px;
    display: block;
}

/* === INPUT === */
.form-control {
    font-size: 14px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    padding: 9px 12px;
    width: 100%;
    color: #1e293b;
    background: #fff;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.form-control:focus {
    border-color: #a78bfa;
    box-shadow: 0 0 0 3px rgba(167,139,250,0.15);
    outline: none;
}

/* === INPUT PREFIX (Rp) === */
.input-prefix-wrapper {
    display: flex;
    align-items: center;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    overflow: hidden;
    transition: border-color 0.2s, box-shadow 0.2s;
    background: #fff;
}

.input-prefix-wrapper:focus-within {
    border-color: #a78bfa;
    box-shadow: 0 0 0 3px rgba(167,139,250,0.15);
}

.input-prefix {
    padding: 9px 12px;
    background: #f1f5f9;
    color: #64748b;
    font-size: 14px;
    font-weight: 500;
    border-right: 1px solid #cbd5e1;
    white-space: nowrap;
}

.form-control.with-prefix {
    border: none;
    border-radius: 0;
    box-shadow: none;
    flex: 1;
}

.form-control.with-prefix:focus {
    border: none;
    box-shadow: none;
    outline: none;
}

/* === FORM ACTIONS === */
.form-actions {
    display: flex;
    gap: 10px;
    margin-top: 0.5rem;
}

/* === TOMBOL SIMPAN === */
.btn-simpan {
    background: #10b981;
    color: #fff;
    font-size: 14px;
    font-weight: 500;
    padding: 9px 28px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    transition: background 0.2s;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-simpan:hover:not(:disabled) {
    background: #059669;
}

.btn-simpan:disabled {
    background: #6ee7b7;
    cursor: not-allowed;
}

</style>

<script>

$(document).ready(function(){

    $("#btnSubmit").click(function(){

        let form = document.getElementById("formBarang");

        if(!form.checkValidity()){
            form.reportValidity();
            return;
        }

        $("#btnSubmit").html(
            '<span class="spinner-border spinner-border-sm"></span> Menyimpan...'
        );

        $("#btnSubmit").prop("disabled", true);

        form.submit();

    });

});

</script>

@endsection