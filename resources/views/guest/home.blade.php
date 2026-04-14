<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fishy Paperie — Stationery Store</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --main:    #f48fb1;
            --light:   #fff0f5;
            --accent:  #c2185b;
            --soft:    #fce4ec;
            --text:    #4a2c3a;
            --white:   #ffffff;
        }

        /* ── RESET & BASE ── */
        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background: var(--light);
            color: var(--text);
        }

        a { text-decoration: none; }

        /* ── NAVBAR ── */
        .nav {
            background: var(--white);
            box-shadow: 0 2px 12px rgba(244, 143, 177, 0.15);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .nav-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 40px;
        }

        .brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--accent);
        }

        .brand span { color: var(--main); }

        .links a {
            margin: 0 15px;
            font-weight: 600;
            color: var(--text);
            transition: color 0.2s;
        }

        .links a:hover { color: var(--main); }

        .links .btn {
            background: var(--main);
            color: var(--white);
            padding: 8px 18px;
            border-radius: 20px;
            transition: background 0.2s;
        }

        .links .btn:hover { background: var(--accent); }

        /* ── HERO ── */
        .hero {
            position: relative;
            text-align: center;
            color: var(--white);
        }

        .hero-bg {
            width: 100%;
            height: 80vh;
            object-fit: cover;
            filter: brightness(65%);
            display: block;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: rgba(194, 24, 91, 0.25);
        }

        .hero-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 600px;
            width: 90%;
        }

        .hero-content h1 {
            font-size: 3rem;
            margin: 0 0 12px;
            text-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }

        .hero-content p {
            margin: 0 0 24px;
            font-size: 1.05rem;
            opacity: 0.92;
        }

        /* ── CTA BUTTON ── */
        .cta {
            display: inline-block;
            background: var(--main);
            color: var(--white);
            padding: 12px 28px;
            border-radius: 30px;
            font-weight: 600;
            transition: background 0.2s, transform 0.2s;
        }

        .cta:hover {
            background: var(--accent);
            transform: translateY(-2px);
        }

        /* ── PRODUCTS SECTION ── */
        .products {
            padding: 80px 20px;
            text-align: center;
            background: var(--white);
        }

        .products h2 {
            color: var(--accent);
            font-size: 1.8rem;
            margin-bottom: 8px;
        }

        .products > p {
            color: var(--text);
            opacity: 0.75;
            margin-bottom: 0;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 25px;
            padding: 40px;
        }

        .product-card {
            background: var(--soft);
            border-radius: 15px;
            padding: 15px;
            box-shadow: 0 4px 12px rgba(244, 143, 177, 0.15);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(244, 143, 177, 0.25);
        }

        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }

        .product-card h3 {
            margin: 10px 0 4px;
            font-size: 1rem;
        }

        .product-card p {
            margin: 0 0 12px;
            font-weight: 600;
            color: var(--accent);
        }

        /* ── FOOTER ── */
        .footer {
            background: var(--main);
            color: var(--white);
            text-align: center;
            padding: 16px;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <header class="nav">
        <div class="nav-inner">
            <div class="brand">Fishy<span>Paperie</span></div>
            <nav class="links">

                <a href="/home">Home</a>
                <a href="/order">Order</a>

                @auth
                    <a href="{{ route('order.history') }}">Riwayat Pesanan</a>

                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="btn" type="submit">Logout</button>
                    </form>
                @endauth

                @guest
                    <a class="btn" href="{{ route('login') }}">Login</a>
                @endguest

            </nav>
        </div>
    </header>


    <!-- HERO -->
    <section class="hero">
        <img class="hero-bg" src="{{ asset('images/fishy.jpg') }}" alt="Hero Fishy Paperie">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Lengkapi Kebutuhan ATK Kamu</h1>
            <p>Pensil, buku tulis, sticky notes, hingga perlengkapan kantor terbaik.</p>
            <a href="#products" class="cta">Lihat Produk</a>
        </div>
    </section>


    <!-- PRODUK -->
    <section id="products" class="products">
        <h2>Produk ATK Terpopuler</h2>
        <p>Temukan berbagai alat tulis berkualitas untuk sekolah, kampus, dan kantor.</p>

        <div class="product-grid">
            @foreach($menus as $menu)
                <div class="product-card">
                    <img src="{{ asset('images/' . $menu->path_gambar) }}" alt="{{ $menu->nama_menu }}">
                    <h3>{{ $menu->nama_menu }}</h3>
                    <p>Rp {{ number_format($menu->harga) }}</p>
                    <a href="/order" class="cta">Order</a>
                </div>
            @endforeach
        </div>
    </section>


    <!-- FOOTER -->
    <footer class="footer">
        © 2026 Fishy Paperie | Stationery Store
    </footer>

</body>
</html>