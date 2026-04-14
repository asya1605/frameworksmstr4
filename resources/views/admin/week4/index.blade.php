@extends('layouts.admin.app')

@section('title', 'AJAX Demo')

@section('content')

<div class="page-header">
    <h3 class="page-title">AJAX Demo</h3>
</div>

<div class="card">
    <div class="card-body">

        <div class="row">

            <div class="col-md-4">

                <div class="form-group mb-3">
                    <label>Name</label>
                    <input
                        type="text"
                        id="myIdName"
                        class="form-control"
                    >
                </div>

                <div id="subutton">
                    <button
                        type="button"
                        class="btn btn-primary"
                        onclick="submitText()"
                    >
                        Submit
                    </button>
                </div>

                <br>

                <div id="freetxt"></div>

            </div>

        </div>

    </div>
</div>

@endsection


@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

function submitText() {

    var btn = $("#subutton");

    btn.html(
        '<button class="btn btn-primary" disabled>Submitting...</button>'
    );

    var name = $("#myIdName").val();

    $.ajax({

        url: "{{ route('week4.ajax_submit') }}",
        type: "POST",

        data: {
            _token: "{{ csrf_token() }}",
            name: name
        },

        success: function (response) {

            btn.html(
                '<button class="btn btn-primary" onclick="submitText()">Submit</button>'
            );

            console.log(response);

            $("#freetxt").html(
                "<b>Hello " + response.data.name + "</b>"
            );

            Swal.fire(
                "Success",
                response.message,
                "success"
            );

        },

        error: function () {

            btn.html(
                '<button class="btn btn-primary" onclick="submitText()">Submit</button>'
            );

            Swal.fire(
                "Error",
                "There was an error submitting your data.",
                "error"
            );

        }

    });

}

</script>

@endsection