<!doctype html>
<html>

<head>
    <meta charset="utf-8">

    <style>

        @page {
            size: 210mm 297mm;
            margin: 0;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 210mm;
            height: 297mm;
            font-family: Arial, sans-serif;
        }

        .page {
            position: relative;
            width: 210mm;
            height: 297mm;
        }

        .labels-table {
            position: absolute;
            top: 3mm;     /* offset atas */
            left: 2mm;    /* offset kiri */
            border-collapse: separate;
            border-spacing: 3mm 2mm; /* jarak antar label */
        }

        .labels-table td {
            padding: 0;
            margin: 0;
        }

        /* ukuran label */
        .label-cell {
            width: 38mm;
            height: 18mm;
            overflow: hidden;
        }

        /* isi label */
        .label-content {
            width: 100%;
            height: 18mm;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding-left: 2mm;
        }

        /* barcode */
        .label-barcode img {
            width: 75%;
            max-height: 6mm;
            margin: 0 auto 1px;
        }

        /* text */
        .label-id {
            font-size: 5pt;
        }

        .label-name {
            font-size: 7pt;
            font-weight: bold;
            line-height: 1.1;
        }

        .label-price {
            font-size: 7pt;
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }

    </style>
</head>

<body>

@foreach ($pages as $pIndex => $page)

    <div class="page">

        <table class="labels-table">

            @for ($r = 0; $r < 8; $r++)
                <tr>

                    @for ($c = 0; $c < 5; $c++)

                        @php
                            $slotIndex = $r * 5 + $c;
                            $item = $page[$slotIndex] ?? null;
                        @endphp

                        <td>

                            <div class="label-cell">

                                @if ($item)

                                    <div class="label-content">

                                        <div class="label-barcode">
                                            <img src="data:image/png;base64,{{ $item->barcode }}">
                                        </div>

                                        <div class="label-id">
                                            {{ $item->id_barang }}
                                        </div>

                                        <div class="label-name">
                                            {{ $item->nama }}
                                        </div>

                                        <div class="label-price">
                                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                                        </div>

                                    </div>

                                @endif

                            </div>

                        </td>

                    @endfor

                </tr>
            @endfor

        </table>

    </div>

    @if ($pIndex < count($pages) - 1)
        <div class="page-break"></div>
    @endif

@endforeach

</body>
</html>