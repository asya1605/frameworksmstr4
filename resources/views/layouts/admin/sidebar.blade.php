<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">

        {{-- Profile --}}
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{ asset('assets/images/faces/face2.jpg') }}" alt="profile"/>
                    <span class="login-status online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">{{ Auth::user()->name ?? 'David Grey. H' }}</span>
                    <span class="text-secondary text-small">Project Manager</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>

        {{-- Dashboard --}}
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <span class="menu-title">Dashboard</span>
            <i class="mdi mdi-home menu-icon"></i>
        </a>
    </li>

        {{-- Kategori --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('kategori.index') }}">
                <span class="menu-title">Kategori</span>
                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
            </a>
        </li>

        {{-- Buku --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('buku.index') }}">
                <span class="menu-title">Buku</span>
                <i class="mdi mdi-book menu-icon"></i>
            </a>
        </li>

        {{-- Generate --}}
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-advanced" aria-expanded="false" aria-controls="ui-advanced">
                <span class="menu-title">Generate</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-monitor-multiple menu-icon"></i>
            </a>
            <div class="collapse" id="ui-advanced">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('form-sertifikat') }}">Sertifikat</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('form-undangan') }}">Undangan</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('sertifikat-statis') }}">Sertifikat Statis</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('undangan-statis') }}">Undangan Statis</a></li>
                </ul>
            </div>
        </li>

    {{-- AJAX MODULE --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('week4.index') }}">
            <span class="menu-title">AJAX Demo</span>
            <i class="mdi mdi-flash menu-icon"></i>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('wilayah') }}">
            <span class="menu-title">Wilayah AJAX</span>
            <i class="mdi mdi-map-marker menu-icon"></i>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('wilayah.axios') }}">
            <span class="menu-title">Wilayah AXIOS</span>
            <i class="mdi mdi-map-marker menu-icon"></i>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('pos') }}">
            <span class="menu-title">POS Kasir</span>
            <i class="mdi mdi-cart menu-icon"></i>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('pos.axios') }}">
            <span class="menu-title">POS AXIOS</span>
            <i class="mdi mdi-cash-register menu-icon"></i>
        </a>
    </li>

        {{-- Barang / Tag Harga --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('barang.index') }}">
                    <span class="menu-title">Tag Harga</span>
                    <i class="mdi mdi-tag-multiple menu-icon"></i>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('scanner.barcode') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('scanner.barcode') }}">
                    <span class="menu-title">Scanner Barcode</span>
                    <i class="mdi mdi-barcode-scan menu-icon"></i>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('admin.toko.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.toko.index') }}">
                    <span class="menu-title">Data Toko</span>
                    <i class="mdi mdi-store menu-icon"></i>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('antrian.admin') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('antrian.admin') }}">
                    <span class="menu-title">Antrian Real-Time</span>
                    <i class="mdi mdi-account-group menu-icon"></i>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('mahasiswa.*') || request()->routeIs('absensi.*') ? 'active' : '' }}">
                <a class="nav-link" data-bs-toggle="collapse" href="#presenceMenu" aria-expanded="false" aria-controls="presenceMenu">
                    <span class="menu-title">Sistem Kehadiran</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-nfc menu-icon"></i>
                </a>
                <div class="collapse {{ request()->routeIs('mahasiswa.*') || request()->routeIs('absensi.*') ? 'show' : '' }}" id="presenceMenu">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}" href="{{ route('mahasiswa.index') }}">
                                Data Mahasiswa
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('absensi.*') ? 'active' : '' }}" href="{{ route('absensi.nfc') }}">
                                Scanner Absensi NFC
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/studi-kasus2-table">
                    <span class="menu-title">Studi Kasus 2</span>
                    <i class="mdi mdi-table-large menu-icon"></i>
                </a>
            </li>

        {{-- Studi Kasus 4 --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('studi.kasus4') }}">
                <span class="menu-title">Studi Kasus 4</span>
                <i class="mdi mdi-map-marker menu-icon"></i>
            </a>
        </li>

        {{-- Customer --}}
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#customerMenu" aria-expanded="false" aria-controls="customerMenu">
            <span class="menu-title">Customer</span>
            <i class="mdi mdi-account-group menu-icon"></i>
        </a>

        <div class="collapse" id="customerMenu">
            <ul class="nav flex-column sub-menu">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customer.index') }}">
                        Data Customer
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customer.createBlob') }}">
                        Tambah Customer 1
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customer.createFile') }}">
                        Tambah Customer 2
                    </a>
                </li>

            </ul>
        </div>
    </li>
<!-- 
        {{-- Dashboard Layouts --}}
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#dashboard-layouts" aria-expanded="false" aria-controls="dashboard-layouts">
                <span class="menu-title">Dashboard Layouts</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-monitor-dashboard menu-icon"></i>
            </a>
            <div class="collapse" id="dashboard-layouts">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="#">Layout 1</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Layout 2</a></li>
                </ul>
            </div>
        </li> -->

        {{-- Page Layouts --}}
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#page-layouts" aria-expanded="false" aria-controls="page-layouts">
                <span class="menu-title">Page Layouts</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-view-grid menu-icon"></i>
            </a>
            <div class="collapse" id="page-layouts">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="#">Page 1</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Page 2</a></li>
                </ul>
            </div>
        </li>

        {{-- Apps --}}
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#apps" aria-expanded="false" aria-controls="apps">
                <span class="menu-title">Apps</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-cart menu-icon"></i>
            </a>
            <div class="collapse" id="apps">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="#">E-commerce</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Calendar</a></li>
                </ul>
            </div>
        </li>

        {{-- Widgets --}}
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#widgets" aria-expanded="false" aria-controls="widgets">
                <span class="menu-title">Widgets</span>
                <span class="badge badge-primary ms-auto">PRO</span>
                <i class="mdi mdi-chart-bar menu-icon"></i>
            </a>
            <div class="collapse" id="widgets">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="#">Widget 1</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Widget 2</a></li>
                </ul>
            </div>
        </li>

        {{-- Sidebar Layouts --}}
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#sidebar-layouts" aria-expanded="false" aria-controls="sidebar-layouts">
                <span class="menu-title">Sidebar Layouts</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-menu menu-icon"></i>
            </a>
            <div class="collapse" id="sidebar-layouts">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="#">Sidebar 1</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Sidebar 2</a></li>
                </ul>
            </div>
        </li>

        {{-- Basic UI Elements --}}
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">Basic UI Elements</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="#">Buttons</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Typography</a></li>
                </ul>
            </div>
        </li>
        
        {{-- Logout --}}
    <li class="nav-item">
        <a class="nav-link" href="#"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <span class="menu-title">Logout</span>
            <i class="mdi mdi-logout menu-icon"></i>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </li>

    </ul>
</nav>