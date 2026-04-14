@extends('layouts.vendor.vendor')

@section('title', 'Data Transaksi')

@section('style')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>

body,
.vendor-content {
    font-family: 'Plus Jakarta Sans', sans-serif;
}

/* HEADER */
.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 22px;
}

.page-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--vp-deeper);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.page-title-pill {
    width: 5px;
    height: 26px;
    background: var(--vp-main);
    border-radius: 4px;
}

/* TOOLBAR */
.menu-toolbar {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 16px;
    flex-wrap: wrap;
}

.search-wrap {
    position: relative;
    flex: 1;
    max-width: 300px;
}

.search-wrap .search-icon {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 14px;
}

.search-wrap input {
    width: 100%;
    padding: 7px 10px 7px 32px;
    border: 1px solid #e5e1f8;
    border-radius: 8px;
    font-size: 12px;
    font-family: inherit;
    outline: none;
}

.search-wrap input:focus {
    border-color: #afa9ec;
}

/* TABLE CARD */
.table-card {
    background: #fff;
    border: 1px solid #e5e1f8;
    border-radius: 14px;
    overflow: hidden;
}

.menu-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 0;
}

.menu-table thead tr {
    background: #f8f7ff;
}

.menu-table th {
    padding: 11px 16px;
    font-size: 11px;
    font-weight: 700;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    text-align: left;
    border-bottom: 1px solid #e5e1f8;
}

.menu-table td {
    padding: 13px 16px;
    font-size: 13px;
    color: #1f1a2e;
    border-bottom: 1px solid #f3f0fb;
    vertical-align: middle;
}

.menu-table tbody tr:last-child td {
    border-bottom: none;
}

.menu-table tbody tr:hover td {
    background: #faf9ff;
}

/* STATUS BADGE */
.badge-pending {
    background: #fff3cd;
    color: #856404;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

.badge-paid {
    background: #d1f7e4;
    color: #0f6e56;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

/* BUTTON */
.btn-detail {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    font-weight: 600;
    padding: 5px 11px;
    border-radius: 7px;
    border: 1px solid #afa9ec;
    background: #eeedfe;
    color: #534ab7;
    text-decoration: none;
}

.btn-detail:hover {
    background: #cecbf6;
    color: #3c3489;
    text-decoration: none;
}

/* EMPTY */
.empty-state {
    text-align: center;
    padding: 40px;
    color: #9ca3af;
    font-size: 13px;
}

</style>

@endsection


@section('content')

<div class="page-header">

    <h3 class="page-title">
        <span class="page-title-pill"></span>
        Data Transaksi
    </h3>

</div>


<!-- TOOLBAR -->

<div class="menu-toolbar">

    <div class="search-wrap">

        <i class="mdi mdi-magnify search-icon"></i>

        <input
            type="text"
            id="searchTransaksi"
            placeholder="Cari customer..."
        >

    </div>

</div>


<!-- TABLE -->

<div class="table-card">

    <table class="menu-table" id="transaksiTable">

        <thead>
            <tr>
                <th style="width:80px">ID</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Metode</th>
                <th>Status</th>
                <th style="text-align:center">Aksi</th>
            </tr>
        </thead>

        <tbody>

            @if ($data && count($data) > 0)

                @foreach ($data as $t)

                    <tr>

                        <td style="color:#9ca3af;font-size:12px">
                            {{ str_pad($t->idpesanan, 3, '0', STR_PAD_LEFT) }}
                        </td>

                        <td>
                            {{ $t->nama_customer }}
                        </td>

                        <td>
                            <strong>
                                Rp {{ number_format($t->total, 0, ',', '.') }}
                            </strong>
                        </td>

                        <td>
                            {{ $t->metode_bayar }}
                        </td>

                        <td>

                            @if ($t->status_bayar == 0)
                                <span class="badge-pending">
                                    Pending
                                </span>
                            @else
                                <span class="badge-paid">
                                    Paid
                                </span>
                            @endif

                        </td>

                        <td style="text-align:center">

                            <a
                                href="{{ route('vendor.transaksi.detail', $t->idpesanan) }}"
                                class="btn-detail"
                            >
                                <i class="mdi mdi-eye"></i> Detail
                            </a>

                        </td>

                    </tr>

                @endforeach

            @else

                <tr>
                    <td colspan="6">

                        <div class="empty-state">

                            <i
                                class="mdi mdi-cart-off"
                                style="font-size:32px;display:block;margin-bottom:8px;color:#e5e1f8"
                            ></i>

                            Tidak ada transaksi

                        </div>

                    </td>
                </tr>

            @endif

        </tbody>

    </table>

</div>

@endsection



@section('script')

<script>

document.getElementById('searchTransaksi').addEventListener('input', function () {

    const q = this.value.toLowerCase();

    document.querySelectorAll('#transaksiTable tbody tr').forEach(row => {

        const name = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() ?? '';

        row.style.display = name.includes(q) ? '' : 'none';

    });

});

</script>

@endsection