<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Login') - Fishy Paperie</title>
    
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
<style>
    :root {
        --pink: #f8a5c2;
        --soft-pink: #fbd6e3;
        --peach: #f7a77f;
        --cream: #f6ede7;
        --text-dark: #5c3a3a;
        --input-bg: #f4ebe6;
    }

    body {
        margin: 0;
    }

    .auth-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f6c1d7 0%, #f3e0d6 100%);
        position: relative;
        overflow: hidden;
    }

    /* floating soft hearts effect */
    .auth-page::before {
        content: "";
        position: absolute;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.4), transparent 60%);
        animation: float 30s linear infinite;
    }

    @keyframes float {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .auth-form-light {
        background: #ffffff;
        border-radius: 28px;
        padding: 45px 40px;
        width: 420px;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.08);
        position: relative;
        z-index: 2;
        border-top: 6px solid var(--pink);
    }

    .brand-logo {
        text-align: center;
        margin-bottom: 25px;
    }

    .brand-logo img {
        max-width: 85px;
        margin-bottom: 10px;
    }

    .brand-logo h2 {
        color: var(--text-dark);
        font-weight: 700;
        font-size: 22px;
        margin: 0;
    }

    .auth-form-light label {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 14px;
    }

    .auth-form-light .form-control {
        background: var(--input-bg);
        border: 2px solid #f1d4df;
        border-radius: 15px;
        height: 52px;
        padding: 0 15px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .auth-form-light .form-control:focus {
        border-color: var(--pink);
        box-shadow: 0 0 0 0.2rem rgba(248,165,194,0.3);
        background: #fff;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .alert {
        border-radius: 15px;
        background: #ffe3ea;
        color: #c45a7a;
        border: none;
        font-size: 14px;
    }

    .auth-link {
        color: var(--pink);
        font-weight: 600;
        text-decoration: none;
        font-size: 13px;
    }

    .auth-link:hover {
        color: var(--peach);
        text-decoration: underline;
    }

    .auth-form-btn {
        margin: 25px auto 15px;
        height: 55px;
        border-radius: 18px;
        font-weight: 700;
        letter-spacing: 0.5px;
        font-size: 15px;
        border: none;
        color: white;
        background: linear-gradient(to right, var(--pink), var(--peach));
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .auth-form-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(248,165,194,0.4);
    }

    .text-muted {
        font-size: 13px;
        color: #b08b8b !important;
    }

    hr {
        opacity: 0.2;
    }
</style>
    
    @stack('styles')
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth-page">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 col-md-6 col-sm-8 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Plugins JS -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/misc.js') }}"></script>
    
    @stack('scripts')
</body>
</html>