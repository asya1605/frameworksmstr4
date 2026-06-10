<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">

        {{-- Dashboard --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('vendor.dashboard') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>

        {{-- Menu Vendor --}}
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#menu-vendor" aria-expanded="false">
                <span class="menu-title">Menu</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-food menu-icon"></i>
            </a>

            <div class="collapse" id="menu-vendor">
                <ul class="nav flex-column sub-menu">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('menu.index') }}">
                            Daftar Menu
                        </a>
                    </li>

                </ul>
            </div>
        </li>

        {{-- Transaksi --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('vendor.transaksi') }}">
                <span class="menu-title">Transaksi</span>
                <i class="mdi mdi-cash-register menu-icon"></i>
            </a>
        </li>

        {{-- Scanner QR Customer --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('vendor.scanner.qr') }}">
                <span class="menu-title">Scanner QR Customer</span>
                <i class="mdi mdi-qrcode-scan menu-icon"></i>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('vendor.kunjungan.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('vendor.kunjungan.index') }}">
                <span class="menu-title">Kunjungan Toko</span>
                <i class="mdi mdi-map-marker-radius menu-icon"></i>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('antrian.papan') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('antrian.papan') }}">
                <span class="menu-title">Papan Antrian</span>
                <i class="mdi mdi-monitor-dashboard menu-icon"></i>
            </a>
        </li>

    </ul>
</nav>