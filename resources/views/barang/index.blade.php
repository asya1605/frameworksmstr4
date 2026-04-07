@extends('layouts.app')

@section('title', 'Data Barang')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h3 class="page-title mb-0">Data Barang</h3>
    <a href="{{ route('barang.create') }}" class="btn-tambah">
        + Tambah Barang
    </a>
</div>

<div class="card">
<div class="card-body">

    {{-- FORM CETAK --}}
    <form id="formCetak" action="{{ route('barang.cetak') }}" method="POST">
        @csrf
    </form>

    <div class="table-responsive">
        <table id="barangTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th width="40" class="text-center">
                        <input type="checkbox" id="checkAll">
                    </th>
                    <th>ID Barang</th>
                    <th>Nama</th>
                    <th width="150">Harga</th>
                    <th width="150" class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($barang as $b)
                <tr>

                    <td class="text-center">
                        <input type="checkbox"
                               name="barang[]"
                               value="{{ $b->id_barang }}"
                               form="formCetak">
                    </td>

                    <td>{{ $b->id_barang }}</td>

                    <td>{{ $b->nama }}</td>

                    <td>Rp {{ number_format($b->harga,0,',','.') }}</td>

                    <td class="text-center">

                        <a href="{{ route('barang.edit',$b->id_barang) }}"
                           class="btn-aksi btn-edit">
                            Edit
                        </a>

                        <form action="{{ route('barang.destroy',$b->id_barang) }}"
                              method="POST"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn-aksi btn-hapus"
                                    onclick="return confirm('Yakin hapus?')">
                                Hapus
                            </button>
                        </form>

                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- POSISI LABEL --}}
    <div class="cetak-area">

        <div class="cetak-title">
            <span class="cetak-icon">&#128438;</span>
            Cetak Tag Harga
        </div>

        <div class="cetak-body">

            <div class="cetak-field">
                <label class="form-label">Kolom (X)</label>
                <input type="number"
                       name="x"
                       min="1"
                       max="5"
                       class="form-control"
                       placeholder="1–5"
                       form="formCetak"
                       required>
                <span class="form-hint">Maks. 5 kolom</span>
            </div>

            <div class="cetak-field">
                <label class="form-label">Baris (Y)</label>
                <input type="number"
                       name="y"
                       min="1"
                       max="8"
                       class="form-control"
                       placeholder="1–8"
                       form="formCetak"
                       required>
                <span class="form-hint">Maks. 8 baris</span>
            </div>

            <div class="cetak-field cetak-submit">
                <button type="submit"
                        class="btn-cetak"
                        form="formCetak">
                    Cetak Tag Harga
                </button>
            </div>

        </div>

    </div>

</div>
</div>

@endsection


@section('scripts')

<style>

/* === TOMBOL TAMBAH === */
.btn-tambah {
    background: #7c3aed;
    color: #fff;
    font-size: 14px;
    font-weight: 500;
    padding: 8px 18px;
    border-radius: 8px;
    text-decoration: none;
    transition: background 0.2s;
}

.btn-tambah:hover {
    background: #6d28d9;
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

.table td {
    vertical-align: middle;
    font-size: 14px;
    color: #1e293b;
}

.table tbody tr:hover {
    background-color: #f5f3ff;
}

/* === TOMBOL AKSI === */
.btn-aksi {
    display: inline-block;
    font-size: 12px;
    font-weight: 500;
    padding: 4px 12px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: opacity 0.2s;
}

.btn-aksi:hover {
    opacity: 0.85;
}

.btn-edit {
    background: #f59e0b;
    color: #fff;
    margin-right: 4px;
}

.btn-hapus {
    background: #ef4444;
    color: #fff;
}

/* === AREA CETAK === */
.cetak-area {
    margin-top: 1.5rem;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    overflow: hidden;
}

.cetak-title {
    background: #1e293b;
    color: #fff;
    font-size: 14px;
    font-weight: 500;
    padding: 11px 18px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.cetak-icon {
    font-size: 15px;
}

.cetak-body {
    display: flex;
    align-items: flex-end;
    gap: 16px;
    padding: 1.25rem 1.5rem;
    background: #f8fafc;
    flex-wrap: wrap;
}

.cetak-field {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.cetak-submit {
    padding-bottom: 2px;
}

/* === FORM ELEMENTS === */
.form-label {
    font-size: 13px;
    font-weight: 500;
    color: #475569;
    margin-bottom: 0;
}

.form-hint {
    font-size: 11px;
    color: #94a3b8;
}

.form-control {
    font-size: 14px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    padding: 8px 12px;
    width: 120px;
    color: #1e293b;
    background: #fff;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.form-control:focus {
    border-color: #a78bfa;
    box-shadow: 0 0 0 3px rgba(167,139,250,0.15);
    outline: none;
}

/* === TOMBOL CETAK === */
.btn-cetak {
    background: #10b981;
    color: #fff;
    font-size: 14px;
    font-weight: 500;
    padding: 9px 20px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    transition: background 0.2s;
    white-space: nowrap;
}

.btn-cetak:hover {
    background: #059669;
}

</style>

<script>

$(document).ready(function(){

    // DATATABLE
    $('#barangTable').DataTable();

    // CHECK ALL
    $('#checkAll').on('click', function(){
        $('input[name="barang[]"]').prop('checked', this.checked);
    });

    // UPDATE HEADER CHECKBOX
    $(document).on('click', 'input[name="barang[]"]', function(){
        let total = $('input[name="barang[]"]').length;
        let checked = $('input[name="barang[]"]:checked').length;
        $('#checkAll').prop('checked', total === checked);
    });

});

</script>

@endsection