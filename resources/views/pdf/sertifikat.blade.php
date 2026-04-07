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
    }

    
    .page {
        width: 297mm;
        height: 210mm;
        position: relative;
        background-image: url('{{ public_path("assets/images/template-sertifikat.png") }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }


    .content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 65%;
        text-align: center;
    }


    .title {
        font-size: 52px;
        font-weight: bold;
        letter-spacing: 8px;
        margin-bottom: 10px;
    }

    .nomor {
        font-size: 13px;
        margin-bottom: 25px;
    }


    .label {
        font-size: 14px;
        margin: 10px 0;
    }

    .nama {
        font-size: 38px;
        font-weight: bold;
        margin: 10px 0;
    }

    .label-jabatan {
        font-size: 13px;
        margin-top: 15px;
    }

    .jabatan {
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .acara {
        font-size: 11px;
        line-height: 1.7;
        margin-top: 15px;
    }


    .ttd-table {
        margin-top: 60px;
        width: 100%;
    }

    .ttd-table td {
        width: 33.33%;
        text-align: center;
    }

    .ttd-label {
        font-size: 11px;
        font-weight: bold;
        margin-bottom: 50px; 
    }

    .ttd-name {
        font-size: 11px;
        font-weight: bold;
    }

    .ttd-nip {
        font-size: 10px;
    }
</style>
</head>
<body>
<div class="page">

    
    <div class="corner corner-tl"></div>
    <div class="corner corner-tr"></div>
    <div class="corner corner-bl"></div>
    <div class="corner corner-br"></div>

   
    <div class="inner-border"></div>
    <div class="inner-border-2"></div>

   
    <div class="medal"></div>

    
    <div class="content">

        <div class="title">Sertifikat</div>
        <div class="nomor">No. {{ $nomor }}</div>

        <div class="ornament">
            <div class="ornament-line"></div>
            <div class="ornament-diamond"></div>
            <div class="ornament-line"></div>
        </div>

        <p class="label">Diberikan kepada :</p>

        <div class="nama">{{ $nama }}</div>
        <div class="nama-underline"></div>

        <p class="label-jabatan">Atas Partisipasinya Sebagai :</p>
        <div class="jabatan">{{ $jabatan }}</div>

        <p class="acara">
            <b>{{ $acara }}</b>
            yang diselenggarakan oleh {{ $penyelenggara }}
            pada {{ $tanggal_acara }}.
        </p>
        
        <table class="ttd-table">
            <tr>
                {{-- DEKAN --}}
                <td>
                    <p class="ttd-label">{{ $label_dekan }}</p>
                    <div style="height:45px;"></div>
                    <div class="ttd-line"></div>
                    <p class="ttd-name">{{ $nama_dekan }}</p>
                    <p class="ttd-nip">NIP. {{ $nip_dekan }}</p>
                </td>

                {{-- KOORDINATOR --}}
                <td>
                <p class="ttd-label">{!! nl2br(e($label_koordinator)) !!}</p>
                    <div style="height:45px;"></div>
                    <div class="ttd-line"></div>
                    <p class="ttd-name">{{ $nama_koordinator }}</p>
                    <p class="ttd-nip">NIP. {{ $nip_koordinator }}</p>
                </td>

                {{-- KETUA --}}
                <td>
                <p class="ttd-label">{{ $label_ketua }}</p>
                    <div style="height:45px;"></div>
                    <div class="ttd-line"></div>
                    <p class="ttd-name">{{ $nama_ketua }}</p>
                    <p class="ttd-nip">NIM. {{ $nim_ketua }}</p>
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>