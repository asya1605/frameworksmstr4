@extends('layouts.vendor.vendor')

@section('title', 'Master Menu')

@section('style')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    body, .vendor-content { font-family: 'Plus Jakarta Sans', sans-serif; }

    /* ── HEADER ── */
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
    .btn-add-menu {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #534ab7;
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 8px;
        border: none;
        text-decoration: none;
        transition: background 0.2s;
    }
    .btn-add-menu:hover { background: #3c3489; color: #fff; text-decoration: none; }

    /* ── TOOLBAR ── */
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
    .search-wrap input:focus { border-color: #afa9ec; }

    /* ── TABLE CARD ── */
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
    .menu-table thead tr { background: #f8f7ff; }
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
    .menu-table tbody tr:last-child td { border-bottom: none; }
    .menu-table tbody tr:hover td { background: #faf9ff; }

    /* Name cell */
    .menu-name-cell { display: flex; align-items: center; gap: 10px; }
    .menu-thumb {
        width: 34px; height: 34px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
        background: #f3f0fb;
        overflow: hidden;
    }
    .menu-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .menu-name-strong { font-weight: 600; color: #1f1a2e; }

    /* Price */
    .price-text { font-weight: 700; color: #0f6e56; }

    /* Vendor badge */
    .vendor-badge {
        display: inline-block;
        font-size: 11px;
        font-weight: 600;
        padding: 3px 9px;
        border-radius: 20px;
        background: #eeedfe;
        color: #534ab7;
    }

    /* Action buttons */
    .action-cell { display: flex; align-items: center; justify-content: center; gap: 6px; }
    .btn-edit-sm {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: 11px; font-weight: 600;
        padding: 5px 11px; border-radius: 7px;
        border: 1px solid #afa9ec;
        background: #eeedfe; color: #534ab7;
        text-decoration: none;
        transition: background 0.15s;
    }
    .btn-edit-sm:hover { background: #cecbf6; color: #3c3489; text-decoration: none; }
    .btn-del-sm {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: 11px; font-weight: 600;
        padding: 5px 11px; border-radius: 7px;
        border: 1px solid #f09595;
        background: #fcebeb; color: #a32d2d;
        cursor: pointer;
        transition: background 0.15s;
    }
    .btn-del-sm:hover { background: #f7c1c1; }

    /* Empty state */
    .empty-state { text-align: center; padding: 40px; color: #9ca3af; font-size: 13px; }

    /* Paginator */
    .table-paginator {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px 0;
        flex-wrap: wrap;
        gap: 8px;
    }
    .page-info-text { font-size: 12px; color: #9ca3af; }
</style>
@endsection

@section('content')

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-pill"></span>
        Master Menu
    </h3>
    <a href="{{ route('menu.create') }}" class="btn-add-menu">
        <i class="mdi mdi-plus"></i> Tambah Menu
    </a>
</div>

<!-- TOOLBAR -->
<div class="menu-toolbar">
    <div class="search-wrap">
        <i class="mdi mdi-magnify search-icon"></i>
        <input type="text" id="searchMenu" placeholder="Cari nama menu...">
    </div>
</div>

<!-- TABLE -->
<div class="table-card">
    <table class="menu-table" id="menuTable">
        <thead>
            <tr>
                <th style="width:52px">#</th>
                <th>Nama Menu</th>
                <th>Harga</th>
                <th>Vendor</th>
                <th style="text-align:center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($menu as $m)
            <tr>
                <td style="color:#9ca3af;font-size:12px">{{ str_pad($m->idmenu, 3, '0', STR_PAD_LEFT) }}</td>
                <td>
                    <div class="menu-name-cell">
                        <div class="menu-thumb">
                            @if(!empty($m->foto))
                                <img src="{{ asset('storage/'.$m->foto) }}" alt="{{ $m->nama_menu }}">
                            @else
                                <i class="mdi mdi-food" style="font-size:18px;color:#afa9ec"></i>
                            @endif
                        </div>
                        <span class="menu-name-strong">{{ $m->nama_menu }}</span>
                    </div>
                </td>
                <td>
                    <span class="price-text">Rp {{ number_format($m->harga, 0, ',', '.') }}</span>
                </td>
                <td>
                    <span class="vendor-badge">{{ $m->nama_vendor }}</span>
                </td>
                <td>
                    <!-- <div class="action-cell">
                        <a href="{{ route('menu.edit', $m->idmenu) }}" class="btn-edit-sm">
                            <i class="mdi mdi-pencil" style="font-size:12px"></i> Edit
                        </a> -->
                        <form action="{{ route('menu.destroy', $m->idmenu) }}" method="POST"
                              onsubmit="return confirm('Hapus menu {{ addslashes($m->nama_menu) }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-del-sm">
                                <i class="mdi mdi-delete" style="font-size:12px"></i> Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">
                    <div class="empty-state">
                        <i class="mdi mdi-food-off" style="font-size:32px;display:block;margin-bottom:8px;color:#e5e1f8"></i>
                        Belum ada menu tersedia
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($menu instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="table-paginator">
        <span class="page-info-text">
            Menampilkan {{ $menu->firstItem() }}–{{ $menu->lastItem() }} dari {{ $menu->total() }} menu
        </span>
        <div>{{ $menu->links('pagination::bootstrap-4') }}</div>
    </div>
    @endif
</div>

@endsection

@section('script')
<script>
document.getElementById('searchMenu').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#menuTable tbody tr').forEach(row => {
        const name = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() ?? '';
        row.style.display = name.includes(q) ? '' : 'none';
    });
});
</script>
@endsection