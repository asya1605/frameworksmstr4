<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
    <style>
        :root {
            --main:   #f48fb1;
            --accent: #c2185b;
            --purple: #7c3aed;
            --soft:   #fce4ec;
            --light:  #fff0f5;
            --text:   #4a2c3a;
            --glass:  rgba(255,255,255,0.7);
        }

        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #fff0f5 0%, #f3e8ff 50%, #fce4ec 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container { max-width: 960px; margin: auto; }

        /* Header */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--accent);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .page-title span { font-size: 1.6rem; }
        .btn-back {
            background: transparent;
            color: var(--accent);
            border: 2px solid var(--main);
            border-radius: 50px;
            padding: 8px 22px;
            font-size: .82rem;
            font-weight: 600;
            text-decoration: none;
            transition: .25s;
        }
        .btn-back:hover { background: var(--accent); color: #fff; border-color: var(--accent); }

        /* Pesanan card */
        .order-card {
            background: var(--glass);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(244,143,177,.25);
            border-radius: 20px;
            padding: 24px 28px;
            margin-bottom: 20px;
            box-shadow: 0 8px 32px rgba(194,24,91,.08);
            transition: transform .25s, box-shadow .25s;
            animation: fadeUp .4s ease both;
        }
        .order-card:hover { transform: translateY(-3px); box-shadow: 0 14px 36px rgba(194,24,91,.14); }
        @keyframes fadeUp { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:translateY(0)} }

        .order-card:nth-child(1) { animation-delay: .05s; }
        .order-card:nth-child(2) { animation-delay: .10s; }
        .order-card:nth-child(3) { animation-delay: .15s; }

        .order-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .order-id {
            font-size: 1rem;
            font-weight: 700;
            color: var(--purple);
        }
        .order-id small { font-weight:400; font-size:.78rem; color:#999; }

        .order-meta { margin-top: 8px; }
        .order-meta .row-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: .875rem;
            color: var(--text);
            margin-bottom: 6px;
        }
        .order-meta .label { color: #999; min-width: 90px; font-size: .8rem; }
        .order-meta .value { font-weight: 600; }
        .order-meta .value.total { color: var(--accent); font-size: 1rem; }

        /* Badge */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border-radius: 50px;
            padding: 5px 14px;
            font-size: .75rem;
            font-weight: 600;
        }
        .badge-lunas   { background: #dcfce7; color: #166534; }
        .badge-pending { background: #fce4ec; color: #9d174d; }

        /* QR Section */
        .qr-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            min-width: 110px;
        }
        .qr-wrapper {
            background: #fff;
            border-radius: 14px;
            padding: 10px;
            box-shadow: 0 4px 16px rgba(124,58,237,.15);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
        }
        .qr-wrapper canvas { border-radius: 8px; }
        .qr-label {
            font-size: 11px;
            color: #888;
            text-align: center;
            line-height: 1.3;
        }
        .qr-locked {
            width: 100px;
            height: 100px;
            background: #f3e8ff;
            border-radius: 14px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 6px;
            color: #aaa;
            font-size: .72rem;
            text-align: center;
            padding: 10px;
        }
        .qr-locked span { font-size: 2rem; }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: var(--glass);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            border: 1px solid rgba(244,143,177,.2);
        }
        .empty-state .icon { font-size: 4rem; margin-bottom: 16px; }
        .empty-state h5 { color: var(--accent); font-weight: 600; }
        .empty-state p  { color: #aaa; font-size: .88rem; margin-top: 6px; }
        .btn-order {
            display: inline-block;
            margin-top: 20px;
            background: linear-gradient(135deg, var(--main), var(--accent));
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 10px 28px;
            font-size: .88rem;
            font-weight: 600;
            text-decoration: none;
            transition: .25s;
        }
        .btn-order:hover { opacity: .9; transform: translateY(-2px); }

        /* Divider */
        .card-divider {
            border: none;
            border-top: 1px dashed rgba(244,143,177,.3);
            margin: 16px 0;
        }

        @media (max-width: 600px) {
            .order-top { flex-direction: column-reverse; }
            .qr-section { flex-direction: row; }
        }
    </style>
</head>
<body>

<div class="container">

    <div class="page-header">
        <div class="page-title">
            <span>🧾</span> Riwayat Pesanan
        </div>
        <a href="{{ url('/') }}" class="btn-back">← Kembali</a>
    </div>

    @if ($pesanan->count() == 0)

        <div class="empty-state">
            <div class="icon">🛒</div>
            <h5>Belum ada pesanan</h5>
            <p>Anda belum melakukan pesanan apapun.</p>
            <a href="{{ url('/order') }}" class="btn-order">Pesan Sekarang</a>
        </div>

    @else

        @foreach ($pesanan as $idx => $p)
        <div class="order-card" style="animation-delay: {{ $idx * 0.06 }}s;">

            <div class="order-top">

                {{-- Info kiri --}}
                <div class="flex-grow-1">
                    <div class="order-id">
                        Pesanan #{{ $p->idpesanan }}
                        <small style="margin-left:6px;">{{ $p->status_bayar == 1 ? '' : '(menunggu pembayaran)' }}</small>
                    </div>

                    <hr class="card-divider">

                    <div class="order-meta">
                        <div class="row-item">
                            <span class="label">Total</span>
                            <span class="value total">Rp {{ number_format($p->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="row-item">
                            <span class="label">Status</span>
                            <span class="value">
                                @if ($p->status_bayar == 1)
                                    <span class="badge badge-lunas">✅ Lunas</span>
                                @else
                                    <span class="badge badge-pending">⏳ Belum Bayar</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                {{-- QR kanan --}}
                <div class="qr-section">
                    @if ($p->status_bayar == 1)
                        <div class="qr-wrapper">
                            <canvas id="qr-{{ $p->idpesanan }}"></canvas>
                            <div class="qr-label">Scan saat<br>ambil pesanan</div>
                        </div>
                    @else
                        <div class="qr-locked">
                            <span>🔒</span>
                            QR tersedia setelah pembayaran
                        </div>
                    @endif
                </div>

            </div>
        </div>
        @endforeach

    @endif

</div>

<script>
// Generate QR Code di client-side menggunakan qrcode.js
document.addEventListener('DOMContentLoaded', function () {
    @foreach ($pesanan as $p)
        @if ($p->status_bayar == 1)
        QRCode.toCanvas(
            document.getElementById('qr-{{ $p->idpesanan }}'),
            '{{ $p->idpesanan }}',
            {
                width: 100,
                margin: 1,
                color: { dark: '#7c3aed', light: '#ffffff' }
            },
            function (err) { if (err) console.error(err); }
        );
        @endif
    @endforeach
});
</script>

</body>
</html>