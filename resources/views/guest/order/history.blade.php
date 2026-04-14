<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>

        :root {
            --main: #f48fb1;
            --accent: #c2185b;
            --soft: #fce4ec;
            --light: #fff0f5;
            --text: #4a2c3a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #fff0f5, #ffe4ec);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 4px 16px rgba(244, 143, 177, .15);
        }

        .card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .page-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--accent);
        }

        .btn-back {
            background: transparent;
            color: var(--accent);
            border: 1.5px solid var(--main);
            border-radius: 20px;
            padding: 6px 18px;
            font-size: .82rem;
            font-weight: 600;
            text-decoration: none;
            transition: .2s;
        }

        .btn-back:hover {
            background: var(--accent);
            color: #fff;
            border-color: var(--accent);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: .9rem;
        }

        thead tr {
            background: var(--main);
        }

        thead th {
            padding: 10px 14px;
            color: #fff;
            font-weight: 600;
            text-align: left;
        }

        thead th:first-child {
            border-radius: 10px 0 0 0;
        }

        thead th:last-child {
            border-radius: 0 10px 0 0;
        }

        tbody td {
            padding: 14px;
            border-bottom: 1px solid var(--soft);
            color: var(--text);
            vertical-align: middle;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover {
            background: var(--light);
        }

        .badge {
            display: inline-block;
            border-radius: 20px;
            padding: 4px 12px;
            font-size: .75rem;
            font-weight: 600;
        }

        .badge-lunas {
            background: #dcfce7;
            color: #166534;
        }

        .badge-belum {
            background: #fce4ec;
            color: #9d174d;
        }

        /* QR CARD */

        .qr-box {
            background: #fff;
            padding: 10px;
            border-radius: 10px;
            display: inline-block;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .qr-img {
            width: 90px;
            height: 90px;
            border-radius: 6px;
        }

        .qr-label {
            font-size: 11px;
            margin-top: 4px;
            color: #777;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #777;
        }

    </style>
</head>

<body>

<div class="container">
    <div class="card">

        <div class="card-top">
            <h3 class="page-title">Riwayat Pesanan</h3>
            <a href="{{ url('/') }}" class="btn-back">← Kembali</a>
        </div>

        <table>

            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>QR Code</th>
                </tr>
            </thead>

            <tbody>

                @if ($pesanan->count() == 0)

                    <tr>
                        <td colspan="4" class="empty">
                            Belum ada pesanan
                        </td>
                    </tr>

                @else

                    @foreach ($pesanan as $p)

                        <tr>

                            <td>#{{ $p->idpesanan }}</td>

                            <td>
                                Rp {{ number_format($p->total, 0, ',', '.') }}
                            </td>

                            <td>
                                @if ($p->status_bayar == 1)
                                    <span class="badge badge-lunas">
                                        Lunas
                                    </span>
                                @else
                                    <span class="badge badge-belum">
                                        Belum Bayar
                                    </span>
                                @endif
                            </td>

                            <td>

                                @if ($p->status_bayar == 1)

                                    <div class="qr-box">
                                        <img
                                            class="qr-img"
                                            src="data:image/png;base64,{{ $p->qrCode }}"
                                        >
                                        <div class="qr-label">
                                            Scan saat ambil
                                        </div>
                                    </div>

                                @else
                                    -
                                @endif

                            </td>

                        </tr>

                    @endforeach

                @endif

            </tbody>

        </table>

    </div>
</div>

</body>
</html>