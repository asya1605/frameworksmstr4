<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">

    {{-- Logo --}}
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <a class="navbar-brand brand-logo" href="{{ route('dashboard') }}">
            <img src="{{ asset('assets/images/logo.svg') }}" alt="logo" />
        </a>
        <a class="navbar-brand brand-logo-mini" href="{{ route('dashboard') }}">
            <img src="{{ asset('assets/images/logo-mini.svg') }}" alt="logo" />
        </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">


        {{-- Tombol toggle sidebar --}}
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>

        {{-- Search bar --}}
        <div class="search-field d-none d-md-block">
            <form class="d-flex align-items-center h-100" action="#">
                <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                        <i class="input-group-text border-0 mdi mdi-magnify"></i>
                    </div>
                    <input type="text" class="form-control bg-transparent border-0" placeholder="Search projects">
                </div>
            </form>
        </div>

        {{-- Menu kanan --}}
        <ul class="navbar-nav navbar-nav-right">

            {{-- Fullscreen --}}
            <li class="nav-item d-none d-lg-block">
                <a class="nav-link" href="#" id="fullscreen-button">
                    <i class="mdi mdi-fullscreen"></i>
                </a>
            </li>

            {{-- Messages --}}
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="mdi mdi-email"></i>
                </a>
            </li>

            {{-- Notifications --}}
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="mdi mdi-bell"></i>
                    <span class="count bg-danger"></span>
                </a>
            </li>

            {{-- Power/Logout --}}
            <li class="nav-item">
                <a class="nav-link" href="#" id="settingsDropdown">
                    <i class="mdi mdi-power"></i>
                </a>
            </li>

            {{-- Menu List --}}
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="mdi mdi-view-grid"></i>
                </a>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>