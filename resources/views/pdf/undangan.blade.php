
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111;
            background: #fff;
            padding: 30px 60px 40px 60px;
            line-height: 1.6;
        }


        .kop {
            display: table;
            width: 100%;
            border-bottom: 3px solid #111;
            padding-bottom: 10px;
            margin-bottom: 16px;
        }

        .kop-logo {
            display: table-cell;
            width: 80px;
            vertical-align: middle;
        }

        .kop-logo img {
            width: 70px;
            height: 70px;
        }

        .kop-logo-placeholder {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            border: 2px solid #333;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            text-align: center;
            color: #333;
            font-weight: bold;
            line-height: 1.2;
            padding: 6px;
        }

        .kop-text {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }

        .kop-univ {
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #000;
        }

        .kop-fak {
            font-size: 14px;
            font-weight: bold;
            color: #000;
            margin-bottom: 3px;
        }

        .kop-alamat {
            font-size: 9px;
            color: #333;
            line-height: 1.5;
        }

        .meta-table {
            width: 100%;
            margin: 18px 0 6px;
            border-collapse: collapse;
        }

        .meta-table tr td {
            padding: 1.5px 0;
            vertical-align: top;
        }

        .meta-label {
            width: 80px;
            color: #111;
        }

        .meta-sep {
            width: 14px;
            text-align: center;
        }

        .meta-value {
            color: #111;
        }

        .meta-tanggal {
            text-align: right;
            vertical-align: top;
            white-space: nowrap;
        }

        .yth {
            margin-top: 20px;
            margin-bottom: 4px;
        }

        .yth-list {
            margin-left: 20px;
            margin-bottom: 4px;
        }

        .yth-list li {
            margin-bottom: 1px;
        }

        .yth-instansi {
            margin-left: 0;
            margin-bottom: 16px;
        }

        .paragraf {
            text-align: justify;
            margin-bottom: 12px;
            line-height: 1.7;
        }

        .detail-table {
            margin: 10px 0 14px;
            border-collapse: collapse;
        }

        .detail-table tr td {
            padding: 1.5px 0;
            vertical-align: top;
        }

        .detail-label {
            width: 100px;
            color: #111;
        }

        .detail-sep {
            width: 14px;
            text-align: center;
        }

        .ttd-wrapper {
            margin-top: 22px;
            text-align: center;
            float: right;
            width: 240px;
        }

        .ttd-jabatan {
            margin-bottom: 70px; 
        }

        .ttd-nama {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 2px;
        }

        .ttd-nip {
            font-size: 11px;
        }

        .clearfix::after {
            content: '';
            display: table;
            clear: both;
        }
    </style>
</head>
<body>

    {{-- ── KOP SURAT ── --}}
    <div class="kop">

        <div class="kop-logo">
            @php
                $path = public_path('assets/images/logo-unair.jpg');
                if (file_exists($path)) {
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                }
            @endphp

            @if(file_exists($path))
                <img src="{{ $base64 }}" width="70">
            @endif
        </div>

        <div class="kop-text">
            <div class="kop-univ">UNIVERSITAS AIRLANGGA</div>
            <div class="kop-fak">FAKULTAS VOKASI</div>
            <div class="kop-alamat">
                Kampus B Jl. Dharmawangsa Dalam Surabaya 60286 Telp. (031) 5033869 Fax (031) 5053156<br>
                Laman : https://vokasi.unair.ac.id, e-mail : info@vokasi.unair.ac.id
            </div>
        </div>

    </div>


        {{-- META SURAT --}}
        <table class="meta-table">
            <tr>
                <td class="meta-label">Nomor</td>
                <td class="meta-sep">:</td>
                <td>{{ $nomor }}</td>
                <td class="meta-tanggal">{{ $tanggal }}</td>
            </tr>
            <tr>
                <td class="meta-label">Lampiran</td>
                <td class="meta-sep">:</td>
                <td>{{ $lampiran }}</td>
                <td></td>
            </tr>
            <tr>
                <td class="meta-label">Perihal</td>
                <td class="meta-sep">:</td>
                <td>{{ $perihal }}</td>
                <td></td>
            </tr>
        </table>

        {{-- PENERIMA --}}
        <p class="yth">Yth.</p>
        <ol class="yth-list">
            @foreach($penerima as $p)
                <li>{{ trim($p) }}</li>
            @endforeach
        </ol>
        <p class="yth-instansi">Fakultas Vokasi Universitas Airlangga</p>

        {{-- ISI PEMBUKA --}}
        <p class="paragraf">{{ $isi }}</p>

        {{-- DETAIL ACARA --}}
        <table class="detail-table">
            <tr>
                <td class="detail-label">Hari, Tanggal</td>
                <td class="detail-sep">:</td>
                <td>{{ $hari }}</td>
            </tr>
            <tr>
                <td class="detail-label">Waktu</td>
                <td class="detail-sep">:</td>
                <td>{{ $waktu }}</td>
            </tr>
            <tr>
                <td class="detail-label">Tempat</td>
                <td class="detail-sep">:</td>
                <td>{{ $tempat }}</td>
            </tr>
            <tr>
                <td class="detail-label">Agenda</td>
                <td class="detail-sep">:</td>
                <td>{{ $agenda }}</td>
            </tr>
        </table>

        {{-- PENUTUP --}}
        <p class="paragraf">{{ $penutup }}</p>

        {{-- TANDA TANGAN --}}
        <div class="clearfix">
            <div class="ttd-wrapper">
                <p class="ttd-jabatan">{{ $ttd_jabatan }}</p>
                <p class="ttd-nama">{{ $ttd_nama }}</p>
                <p class="ttd-nip">NIP {{ $ttd_nip }}</p>
            </div>
        </div>

</body>
</html>