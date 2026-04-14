<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f3f4f6;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 3rem 1rem;
        }
        .card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            padding: 2rem 2.5rem;
            max-width: 460px;
            width: 100%;
            text-align: center;
            box-shadow: 0 1px 8px rgba(0,0,0,0.06);
        }
        .icon-wrap {
            width: 56px; height: 56px;
            border-radius: 50%;
            background: #dcfce7;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }
        h2 { font-size: 20px; font-weight: 600; margin-bottom: 0.25rem; color: #111827; }
        .subtitle { font-size: 14px; color: #6b7280; margin-bottom: 1.5rem; }
        .id-row {
            background: #f9fafb;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            border: 1px solid #e5e7eb;
        }
        .id-row span:first-child { font-size: 13px; color: #6b7280; }
        .id-row span:last-child { font-size: 13px; font-weight: 600; color: #111827; }
        .qr-box {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
        }
        .qr-label {
            font-size: 11px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .qr-box img {
            display: block;
            padding: 10px;
            background: #fff;
            border: 1px solid #f3f4f6;
            border-radius: 6px;
        }
        .qr-note { font-size: 13px; color: #6b7280; }
        .btn-back {
            display: block;
            margin-top: 1.5rem;
            padding: 0.625rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            color: #374151;
            text-decoration: none;
            transition: background 0.15s;
        }
        .btn-back:hover { background: #f9fafb; }
    </style>
</head>
<body>
    <div class="card">

        <div class="icon-wrap">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none"
                 stroke="#16a34a" stroke-width="2.5"
                 stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
        </div>

        <h2>Pembayaran Berhasil</h2>
        <p class="subtitle">Terima kasih! Pesanan Anda telah dikonfirmasi.</p>

        <div class="id-row">
            <span>ID Pesanan</span>
            <span>#{{ $pesanan->idpesanan }}</span>
        </div>

        <div class="qr-box">
            <p class="qr-label">QR Code Pesanan</p>
            <img src="data:image/png;base64,{{ $qrCode }}" width="160" alt="QR Code Pesanan">
            <p class="qr-note">Tunjukkan QR code ini saat mengambil pesanan</p>
        </div>

        <a href="{{ url('/') }}" class="btn-back">Kembali ke beranda</a>

    </div>
</body>
</html>