@extends('layouts.vendor.vendor')

@section('title', 'Dashboard Vendor')

@section('style')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    body, .vendor-content { font-family: 'Plus Jakarta Sans', sans-serif; }

    /* ── PAGE HEADER ── */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
    }
    .page-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--vp-deeper);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .page-title-pill {
        width: 6px;
        height: 28px;
        background: var(--vp-main);
        border-radius: 4px;
        flex-shrink: 0;
    }
    .page-date-badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 20px;
        background: #f5f3ff;
        color: #534ab7;
        border: 1px solid #ede7f6;
    }

    /* ── STAT CARDS ── */
    .stats-row { row-gap: 14px; }

    .stat-card {
        background: #fff;
        border-radius: 14px;
        padding: 18px 20px;
        border: 1px solid #ede8f8;
        position: relative;
        overflow: hidden;
        height: 100%;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(106,63,160,0.10);
    }
    .stat-card::before {
        content: '';
        position: absolute;
        right: -18px; top: -18px;
        width: 72px; height: 72px;
        border-radius: 50%;
        opacity: 0.09;
    }
    .stat-card.purple::before { background: #7f77dd; }
    .stat-card.teal::before   { background: #1d9e75; }
    .stat-card.amber::before  { background: #ef9f27; }
    .stat-card.rose::before   { background: #d4537e; }

    .stat-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
    }
    .stat-icon {
        width: 38px; height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    .stat-icon.purple { background: #eeedfe; color: #534ab7; }
    .stat-icon.teal   { background: #e1f5ee; color: #0f6e56; }
    .stat-icon.amber  { background: #faeeda; color: #854f0b; }
    .stat-icon.rose   { background: #fbeaf0; color: #993556; }

    .stat-trend {
        font-size: 11px;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 20px;
    }
    .stat-trend.up   { background: #eaf3de; color: #3b6d11; }
    .stat-trend.neu  { background: #f3f4f6; color: #6b7280; }

    .stat-label {
        font-size: 11px;
        font-weight: 600;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        margin-bottom: 5px;
    }
    .stat-value {
        font-size: 1.4rem;
        font-weight: 700;
        line-height: 1;
    }
    .stat-value.sm { font-size: 1.05rem; }
    .stat-card.purple .stat-value { color: #534ab7; }
    .stat-card.teal   .stat-value { color: #0f6e56; }
    .stat-card.amber  .stat-value { color: #854f0b; }
    .stat-card.rose   .stat-value { color: #993556; }

    /* ── PANELS ── */
    .panel {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #ede8f8;
        padding: 20px 22px;
        height: 100%;
    }
    .panel-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }
    .panel-title {
        font-size: 13px;
        font-weight: 700;
        color: #1f1a2e;
    }
    .panel-link {
        font-size: 11px;
        color: #534ab7;
        font-weight: 600;
        text-decoration: none;
    }

    /* ── ORDER TABLE ── */
    .order-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 9px 0;
        border-bottom: 1px solid #f3f0fb;
    }
    .order-row:last-child { border-bottom: none; }
    .order-avatar {
        width: 34px; height: 34px;
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 700;
        flex-shrink: 0;
    }
    .order-info { flex: 1; min-width: 0; }
    .order-name {
        font-size: 13px; font-weight: 600;
        color: #1f1a2e;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .order-meta { font-size: 11px; color: #9ca3af; margin-top: 1px; }
    .order-right { text-align: right; flex-shrink: 0; }
    .order-amt { font-size: 13px; font-weight: 700; color: #1f1a2e; }

    .status-badge {
        font-size: 10px; font-weight: 600;
        padding: 2px 8px; border-radius: 20px;
        margin-top: 3px; display: inline-block;
    }
    .s-done    { background: #eaf3de; color: #3b6d11; }
    .s-process { background: #faeeda; color: #854f0b; }
    .s-cancel  { background: #fcebeb; color: #a32d2d; }

    /* ── MENU BARS ── */
    .menu-row {
        display: flex; align-items: center; gap: 10px;
        padding: 8px 0; border-bottom: 1px solid #f3f0fb;
    }
    .menu-row:last-child { border-bottom: none; }
    .menu-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .menu-name { font-size: 13px; color: #1f1a2e; flex: 1; font-weight: 500; }
    .menu-bar-wrap {
        width: 80px; height: 5px;
        background: #f3f0fb; border-radius: 4px; overflow: hidden;
    }
    .menu-bar { height: 100%; border-radius: 4px; }
    .menu-count { font-size: 12px; font-weight: 600; color: #9ca3af; min-width: 22px; text-align: right; }
</style>
@endsection

@section('content')

<!-- PAGE HEADER -->
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-pill"></span>
        Dashboard Vendor
    </h3>
    <span class="page-date-badge">{{ now()->translatedFormat('l, d F Y') }}</span>
</div>

<!-- STAT CARDS -->
<div class="row stats-row mb-4">

    <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
        <div class="stat-card purple">
            <div class="stat-card-top">
                <div class="stat-icon purple"><i class="mdi mdi-food-fork-drink"></i></div>
                <span class="stat-trend neu">—</span>
            </div>
            <div class="stat-label">Total Menu</div>
            <div class="stat-value">{{ $totalMenu }}</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
        <div class="stat-card teal">
            <div class="stat-card-top">
                <div class="stat-icon teal"><i class="mdi mdi-clipboard-list-outline"></i></div>
                <span class="stat-trend up">+12%</span>
            </div>
            <div class="stat-label">Total Order</div>
            <div class="stat-value">{{ $totalOrder }}</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
        <div class="stat-card amber">
            <div class="stat-card-top">
                <div class="stat-icon amber"><i class="mdi mdi-cash-multiple"></i></div>
                <span class="stat-trend up">+8%</span>
            </div>
            <div class="stat-label">Total Pendapatan</div>
            <div class="stat-value sm">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="stat-card rose">
            <div class="stat-card-top">
                <div class="stat-icon rose"><i class="mdi mdi-chart-line"></i></div>
                <span class="stat-trend up">Hari ini</span>
            </div>
            <div class="stat-label">Penjualan Hari Ini</div>
            <div class="stat-value sm">Rp {{ number_format($penjualanHariIni, 0, ',', '.') }}</div>
        </div>
    </div>

</div>

<!-- BOTTOM PANELS -->
<div class="row">

    <!-- Pesanan Terbaru -->
    <div class="col-md-7 mb-4">
        <div class="panel">
            <div class="panel-head">
                <span class="panel-title">Pesanan Terbaru</span>
                <a href="{{ route('vendor.transaksi') }}" class="panel-link">Lihat semua →</a>            </div>

            @forelse($pesananTerbaru ?? [] as $p)
            <div class="order-row">
                <div class="order-avatar" style="background:{{ ['#eeedfe','#e1f5ee','#faeeda','#fbeaf0','#e6f1fb'][$loop->index % 5] }};color:{{ ['#534ab7','#0f6e56','#854f0b','#993556','#185fa5'][$loop->index % 5] }}">
                    {{ strtoupper(substr($p->nama_pembeli ?? 'U', 0, 2)) }}
                </div>
                <div class="order-info">
                    <div class="order-name">{{ $p->nama_pembeli ?? 'Customer' }}</div>
                    <div class="order-meta">{{ $p->ringkasan_menu ?? '-' }}</div>
                </div>
                <div class="order-right">
                    <div class="order-amt">Rp {{ number_format($p->total ?? 0, 0, ',', '.') }}</div>
                    @if(($p->status ?? '') === 'selesai')
                        <span class="status-badge s-done">Selesai</span>
                    @elseif(($p->status ?? '') === 'diproses')
                        <span class="status-badge s-process">Diproses</span>
                    @else
                        <span class="status-badge s-cancel">Dibatalkan</span>
                    @endif
                </div>
            </div>
            @empty
            <p style="font-size:13px;color:#9ca3af;text-align:center;padding:20px 0">Belum ada pesanan</p>
            @endforelse
        </div>
    </div>

    <!-- Menu Terlaris -->
    <div class="col-md-5 mb-4">
        <div class="panel">
            <div class="panel-head">
                <span class="panel-title">Menu Terlaris</span>
                <a href="{{ route('menu.index') }}" class="panel-link">Detail →</a>
            </div>

            @php
                $colors = ['#7f77dd','#1d9e75','#ef9f27','#d4537e','#378add'];
                $maxJual = ($menuTerlaris ?? collect())->max('total_terjual') ?? 1;
            @endphp

            @forelse($menuTerlaris ?? [] as $menu)
            <div class="menu-row">
                <div class="menu-dot" style="background:{{ $colors[$loop->index % 5] }}"></div>
                <span class="menu-name">{{ $menu->nama_menu }}</span>
                <div class="menu-bar-wrap">
                    <div class="menu-bar" style="width:{{ ($menu->total_terjual / $maxJual * 100) }}%;background:{{ $colors[$loop->index % 5] }}"></div>
                </div>
                <span class="menu-count">{{ $menu->total_terjual }}</span>
            </div>
            @empty
            <p style="font-size:13px;color:#9ca3af;text-align:center;padding:20px 0">Belum ada data menu</p>
            @endforelse
        </div>
    </div>

</div>

@endsection