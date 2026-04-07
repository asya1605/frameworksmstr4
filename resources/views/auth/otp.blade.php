@extends('layouts.auth')

@section('title', 'Verifikasi OTP')

@section('content')

<div class="brand-logo text-center">
    <img src="{{ asset('assets/images/logo.svg') }}" alt="logo">
    <h2>Fishy Paperie</h2>
    <p class="text-muted mt-2">Masukkan kode OTP yang telah dikirim</p>
</div>

@if(session('error'))
    <div class="alert alert-danger text-center">
        {{ session('error') }}
    </div>
@endif

<form method="POST" action="{{ route('otp.verify') }}">
    @csrf

    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="mdi mdi-shield-key"></i>
                </span>
            </div>
            <input type="text"
                   name="otp"
                   class="form-control @error('otp') is-invalid @enderror"
                   placeholder="Masukkan 6 Digit OTP"
                   maxlength="6"
                   required>
        </div>

        @error('otp')
            <div class="text-danger mt-2" style="font-size: 13px;">
                {{ $message }}
            </div>
        @enderror
    </div>

        <div class="mt-4">
            <button type="submit" 
                class="btn btn-gradient-primary auth-form-btn">
                <i class="mdi mdi-check-circle-outline"></i>
                Verifikasi OTP
            </button>
        </div>

</form>

<div class="text-center mt-4">
    <small class="text-muted">
        Tidak menerima kode? 
        <a href="#" class="auth-link">Kirim ulang OTP</a>
    </small>
</div>

@endsection
