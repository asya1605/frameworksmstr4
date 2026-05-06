@extends('layouts.admin.app')

@section('title', 'Wilayah AJAX')

@section('content')

<div class="page-header">
    <h3 class="page-title">Wilayah AJAX</h3>
</div>

<div class="card">
    <div class="card-body">

        <div class="wilayah-wrapper">

            <!-- ====================== FORM KIRI ====================== -->
            <div class="wilayah-left">

                <div class="section-title">Pilih Wilayah</div>

                <div class="form-group mb-3">
                    <label class="form-label">Provinsi</label>
                    <select id="province" class="form-control">
                        <option value="">-- Pilih Provinsi --</option>

                        @foreach ($provinces as $p)
                            <option value="{{ $p->id }}">
                                {{ $p->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Kota</label>
                    <select id="city" class="form-control">
                        <option value="">-- Pilih Kota --</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Kecamatan</label>
                    <select id="district" class="form-control">
                        <option value="">-- Pilih Kecamatan --</option>
                    </select>
                </div>

                <div class="form-group mb-0">
                    <label class="form-label">Kelurahan</label>
                    <select id="village" class="form-control">
                        <option value="">-- Pilih Kelurahan --</option>
                    </select>
                </div>

            </div>

            <!-- DIVIDER TENGAH -->
            <div class="wilayah-divider"></div>

            <!-- ====================== HASIL KANAN ====================== -->
            <div class="wilayah-right">

                <div class="section-title">Hasil Pilihan</div>

                <div class="result-item">
                    <div class="result-step">1</div>
                    <div class="result-info">
                        <span class="result-label">Provinsi</span>
                        <span class="result-value" id="result_province">
                            Belum dipilih
                        </span>
                    </div>
                </div>

                <div class="result-item">
                    <div class="result-step">2</div>
                    <div class="result-info">
                        <span class="result-label">Kota</span>
                        <span class="result-value" id="result_city">
                            Belum dipilih
                        </span>
                    </div>
                </div>

                <div class="result-item">
                    <div class="result-step">3</div>
                    <div class="result-info">
                        <span class="result-label">Kecamatan</span>
                        <span class="result-value" id="result_district">
                            Belum dipilih
                        </span>
                    </div>
                </div>

                <div class="result-item">
                    <div class="result-step">4</div>
                    <div class="result-info">
                        <span class="result-label">Kelurahan</span>
                        <span class="result-value" id="result_village">
                            Belum dipilih
                        </span>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection


@section('scripts')

<style>

/* === WRAPPER SIDE BY SIDE === */
.wilayah-wrapper {
    display: flex;
    gap: 0;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    overflow: hidden;
}

.wilayah-left {
    flex: 1;
    padding: 1.5rem;
    background: #fff;
}

.wilayah-divider {
    width: 1px;
    background: #e2e8f0;
    flex-shrink: 0;
}

.wilayah-right {
    flex: 1;
    padding: 1.5rem;
    background: #f8fafc;
}

/* === SECTION TITLE === */
.section-title {
    font-size: 13px;
    font-weight: 600;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-bottom: 1.25rem;
}

/* === FORM === */
.form-label {
    font-size: 13px;
    font-weight: 500;
    color: #475569;
    margin-bottom: 5px;
    display: block;
}

.form-control {
    font-size: 14px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    padding: 9px 12px;
    transition: border-color 0.2s, box-shadow 0.2s;
    color: #1e293b;
    background-color: #fff;
    width: 100%;
}

.form-control:focus {
    border-color: #a78bfa;
    box-shadow: 0 0 0 3px rgba(167, 139, 250, 0.15);
    outline: none;
}

/* === HASIL ITEM === */
.result-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 0;
    border-bottom: 1px solid #e2e8f0;
}

.result-item:last-child {
    border-bottom: none;
}

.result-step {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #e2e8f0;
    color: #94a3b8;
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: background 0.2s, color 0.2s;
}

.result-item.active .result-step {
    background: #7c3aed;
    color: #fff;
}

.result-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.result-label {
    font-size: 12px;
    color: #94a3b8;
    font-weight: 500;
}

.result-value {
    font-size: 14px;
    font-weight: 500;
    color: #94a3b8;
    transition: color 0.2s;
}

.result-item.active .result-value {
    color: #1e293b;
}

</style>


<script>

/* ====================== PROVINSI ====================== */
$('#province').change(function () {

    let province_id = $(this).val(); //ambil value
    let text = $("#province option:selected").text(); //ambil text dari option yang dipilih, untuk ditampilkan di hasil

    $('#city').html('<option value="">-- Pilih Kota --</option>');
    $('#district').html('<option value="">-- Pilih Kecamatan --</option>');
    $('#village').html('<option value="">-- Pilih Kelurahan --</option>');

    resetResult('result_city');
    resetResult('result_district');
    resetResult('result_village');

    if (province_id != "") {

        setResult('result_province', text, 1);

        $.ajax({
            url: "{{ route('get.cities') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                province_id: province_id
            },
            success: function (data) {

                $.each(data, function (key, value) {

                    $('#city').append(
                        '<option value="' + value.id + '">' + value.name + '</option>'
                    );

                });

            }
        });

    } else {
        resetResult('result_province');
    }

});


/* ====================== KOTA ====================== */
$('#city').change(function () {

    let city_id = $(this).val();
    let text = $("#city option:selected").text(); 

    $('#district').html('<option value="">-- Pilih Kecamatan --</option>');
    $('#village').html('<option value="">-- Pilih Kelurahan --</option>');

    resetResult('result_district');
    resetResult('result_village');

    if (city_id != "") {

        setResult('result_city', text, 2);

        $.ajax({ 
            url: "{{ route('get.districts') }}", //kirim request ke controller get.districts
            type: "POST",
            data: { // Kirim data menggunakan POST
                _token: "{{ csrf_token() }}",
                city_id: city_id
            },
            success: function (data) {

                $.each(data, function (key, value) { //loop data 

                    $('#district').append(
                        '<option value="' + value.id + '">' + value.name + '</option>'
                    );

                });

            }
        });

    } else {
        resetResult('result_city');
    }

});


/* ====================== KECAMATAN ====================== */
$('#district').change(function () {

    let district_id = $(this).val();
    let text = $("#district option:selected").text(); // Trigger text untuk hasil

    $('#village').html('<option value="">-- Pilih Kelurahan --</option>');
    resetResult('result_village');

    if (district_id != "") {

        setResult('result_district', text, 3);

        $.ajax({
            url: "{{ route('get.villages') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                district_id: district_id
            },
            success: function (data) {

                $.each(data, function (key, value) {

                    $('#village').append(
                        '<option value="' + value.id + '">' + value.name + '</option>'
                    );

                });

            }
        });

    } else {
        resetResult('result_district');
    }

});


/* ====================== KELURAHAN ====================== */
$('#village').change(function () {

    let text = $("#village option:selected").text(); // Trigger text untuk hasil

    if ($(this).val() != "") {
        setResult('result_village', text, 4);
    } else {
        resetResult('result_village');
    }

});


/* ====================== HELPERS ====================== */
function setResult(id, text, step) {

    $('#' + id).text(text);
    $('#' + id).closest('.result-item').addClass('active');

}

function resetResult(id) {

    $('#' + id).text('Belum dipilih');
    $('#' + id).closest('.result-item').removeClass('active');

}

</script>

@endsection