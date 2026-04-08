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

    </ul>
</nav>