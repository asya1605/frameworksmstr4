@extends('layouts.app')

@section('title', 'Edit Barang')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h3 class="page-title mb-0">Edit Barang</h3>
    <a href="{{ route('barang.index') }}" class="btn-kembali">
        &larr; Kembali
    </a>
</div>

<div class="card">
<div class="card-body">

    <div class="form-wrapper">

        <form action="{{ route('barang.update', $barang) }}" method="POST">
        @csrf
        @method('PUT')

            <div class="form-group mb-4">
                <label class="form-label">ID Barang</label>
                <input type="text"
                       class="form-control"
                       value="{{ $barang->id_barang }}"
                       readonly>
            </div>

            <div class="form-group mb-4">
                <label class="form-label">Nama Barang</label>
                <input type="text"
                       name="nama"
                       class="form-control"
                       value="{{ $barang->nama }}"
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
                           value="{{ $barang->harga }}"
                           placeholder="0"
                           min="0"
                           required>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-update">
                    Update
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

.form-control[readonly] {
    background: #f1f5f9;
    color: #94a3b8;
    cursor: not-allowed;
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

/* === TOMBOL UPDATE === */
.btn-update {
    background: #7c3aed;
    color: #fff;
    font-size: 14px;
    font-weight: 500;
    padding: 9px 28px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    transition: background 0.2s;
}

.btn-update:hover {
    background: #6d28d9;
}

</style>

@endsection