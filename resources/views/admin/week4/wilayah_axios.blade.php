@extends('layouts.admin.app')

@section('title', 'Wilayah AXIOS')

@section('content')

<div class="page-header">
    <h3 class="page-title">Wilayah AXIOS</h3>
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

            <!-- DIVIDER -->
            <div class="wilayah-divider"></div>

            <!-- ====================== HASIL ====================== -->
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

/* WRAPPER */
.wilayah-wrapper {
    display: flex;
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
}

.wilayah-right {
    flex: 1;
    padding: 1.5rem;
    background: #f8fafc;
}

/* TITLE */
.section-title {
    font-size: 13px;
    font-weight: 600;
    color: #94a3b8;
    margin-bottom: 1rem;
}

/* INPUT */
.form-control {
    border-radius: 8px;
}

/* RESULT */
.result-item {
    display: flex;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid #e2e8f0;
}

.result-step {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.result-item.active .result-step {
    background: #7c3aed;
    color: white;
}

.result-value {
    color: #94a3b8;
}

.result-item.active .result-value {
    color: #1e293b;
}

</style>


<!-- AXIOS CDN -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


<script>

// PROVINSI

$('#province').change(function () {

    let province_id = $(this).val();
    let text = $("#province option:selected").text(); // Trigger text untuk hasil

    $('#city').html('<option value="">-- Pilih Kota --</option>');
    $('#district').html('<option value="">-- Pilih Kecamatan --</option>');
    $('#village').html('<option value="">-- Pilih Kelurahan --</option>');

    resetResult('result_city');
    resetResult('result_district');
    resetResult('result_village');

    if (province_id != "") {

        setResult('result_province', text);

        axios.post("{{ route('get.cities') }}", {
            province_id: province_id
        }, {
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        })
        .then(function (response) {

            let data = response.data;

            data.forEach(function (value) {

                $('#city').append(
                    '<option value="' + value.id + '">' + value.name + '</option>'
                );

            });

        })
        .catch(function (error) {

            console.log(error);
            alert("Gagal mengambil data kota");

        });

    } else {

        resetResult('result_province');

    }

});


// KOTA

$('#city').change(function () {

    let city_id = $(this).val();
    let text = $("#city option:selected").text(); // Trigger text untuk hasil

    $('#district').html('<option value="">-- Pilih Kecamatan --</option>');
    $('#village').html('<option value="">-- Pilih Kelurahan --</option>');

    resetResult('result_district');
    resetResult('result_village');

    if (city_id != "") {

        setResult('result_city', text);

        axios.post("{{ route('get.districts') }}", {
            city_id: city_id
        }, {
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        })
        .then(function (response) {

            let data = response.data;

            data.forEach(function (value) {

                $('#district').append(
                    '<option value="' + value.id + '">' + value.name + '</option>'
                );

            });

        })
        .catch(function (error) {

            console.log(error);
            alert("Gagal mengambil data kecamatan");

        });

    } else {

        resetResult('result_city');

    }

});


// KECAMATAN

$('#district').change(function () {

    let district_id = $(this).val();
    let text = $("#district option:selected").text(); // Trigger text untuk hasil

    $('#village').html('<option value="">-- Pilih Kelurahan --</option>');
    resetResult('result_village');

    if (district_id != "") {

        setResult('result_district', text);

        axios.post("{{ route('get.villages') }}", {
            district_id: district_id
        }, {
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        })
        .then(function (response) {

            let data = response.data;

            data.forEach(function (value) {

                $('#village').append(
                    '<option value="' + value.id + '">' + value.name + '</option>'
                );

            });

        })
        .catch(function (error) {

            console.log(error);
            alert("Gagal mengambil data kelurahan");

        });

    } else {

        resetResult('result_district');

    }

});


// KELURAHAN

$('#village').change(function () {

    let text = $("#village option:selected").text(); // Trigger text untuk hasil

    if ($(this).val() != "") {
        setResult('result_village', text);
    } else {
        resetResult('result_village');
    }

});


// HELPER 

function setResult(id, text) {

    $('#' + id).text(text);
    $('#' + id).closest('.result-item').addClass('active');

}

function resetResult(id) {

    $('#' + id).text('Belum dipilih');
    $('#' + id).closest('.result-item').removeClass('active');

}

</script>

@endsection