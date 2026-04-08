<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Fishy Paperie</title>

    <!-- Style Global -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />


    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Style Page -->
    @yield('style')
</head>

<body>
<div class="container-scroller">

    <!-- Navbar -->
    @include('layouts.admin.navbar')

    <div class="container-fluid page-body-wrapper">

        <!-- Sidebar -->
        @include('layouts.admin.sidebar')

        <div class="main-panel">
            <div class="content-wrapper">

                <!-- Content -->
                @yield('content')

            </div>

            <!-- Footer -->
            @include('layouts.admin.footer')

        </div>
    </div>
</div>

{{-- Pro Banner --}}
<div class="row p-0 m-0 proBanner" id="proBanner">
    <div class="col-md-12 p-0 m-0">
        <div class="card-body card-body-padding d-flex align-items-center justify-content-between">
            <div class="ps-lg-3">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="mb-0 font-weight-medium me-3 buy-now-text">
                        Free 24/7 customer support, updates, and more with this template!
                    </p>
                    <a href="https://www.bootstrapdash.com/product/purple-bootstrap-admin-template/"
                       target="_blank"
                       class="btn me-2 buy-now-btn border-0">
                        Buy Now
                    </a>
                </div>
            </div>
            <div>
                <button id="bannerClose" class="btn border-0 p-0">
                    <i class="mdi mdi-close text-white"></i>
                </button>
            </div>
        </div>
    </div>
</div>


<!-- Javascript Global -->
<script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('assets/vendors/chart.js/chart.umd.js') }}"></script>
<script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/off-canvas.js') }}"></script>
<script src="{{ asset('assets/js/misc.js') }}"></script>
<script src="{{ asset('assets/js/settings.js') }}"></script>
<script src="{{ asset('assets/js/todolist.js') }}"></script>
<script src="{{ asset('assets/js/jquery.cookie.js') }}"></script>
<script src="{{ asset('assets/js/dashboard.js') }}"></script>

<!-- jQuery (WAJIB sebelum DataTables) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Javascript Page -->
@yield('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
data-client-key="{{ config('midtrans.client_key') }}"></script>
</body>
</html>
