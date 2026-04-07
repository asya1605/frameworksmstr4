@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')

<div class="brand-logo text-center">
    <img src="{{ asset('assets/images/logo.svg') }}" alt="logo">
    <h2>Fishy Paperie</h2>
</div>

<h4 class="text-center mb-1">Reset Password</h4>
<p class="text-center text-muted mb-4">Masukkan password baru Anda</p>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('password.update') }}">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    {{-- Email --}}
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="mdi mdi-email-outline"></i>
                </span>
            </div>
            <input type="email" 
                   class="form-control form-control-lg"
                   name="email"
                   value="{{ $email ?? old('email') }}"
                   readonly required>
        </div>
    </div>

    {{-- Password --}}
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="mdi mdi-lock-outline"></i>
                </span>
            </div>
            <input type="password"
                   class="form-control form-control-lg"
                   name="password"
                   placeholder="Password Baru"
                   required>
        </div>
    </div>

    {{-- Confirm --}}
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="mdi mdi-lock-check-outline"></i>
                </span>
            </div>
            <input type="password"
                   class="form-control form-control-lg"
                   name="password_confirmation"
                   placeholder="Konfirmasi Password"
                   required>
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-gradient-primary btn-block btn-lg auth-form-btn">
            <i class="mdi mdi-lock-reset"></i> RESET PASSWORD
        </button>
    </div>

    <div class="text-center mt-3">
        <a href="{{ route('login') }}" class="auth-link">
            <i class="mdi mdi-arrow-left"></i> Kembali ke Login
        </a>
    </div>
</form>

@endsection
