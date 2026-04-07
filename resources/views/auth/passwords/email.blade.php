@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('content')

<div class="brand-logo text-center">
    <img src="{{ asset('assets/images/logo.svg') }}" alt="logo">
    <h2>Fishy Paperie</h2>
</div>

<h4 class="text-center mb-1">Lupa Password?</h4>
<p class="text-center text-muted mb-4">
    Masukkan email untuk mendapatkan link reset password
</p>

{{-- Status sukses --}}
@if (session('status'))
    <div class="alert alert-success text-center">
        {{ session('status') }}
    </div>
@endif

{{-- Error validasi --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="mdi mdi-email-outline"></i>
                </span>
            </div>
            <input type="email"
                   name="email"
                   class="form-control form-control-lg"
                   placeholder="Masukkan email"
                   value="{{ old('email') }}"
                   required>
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-gradient-primary btn-lg w-100 auth-form-btn">
            <i class="mdi mdi-send"></i> Kirim Link Reset
        </button>
    </div>

    <div class="text-center mt-3">
        <a href="{{ route('login') }}" class="auth-link">
            <i class="mdi mdi-arrow-left"></i> Kembali ke Login
        </a>
    </div>
</form>

@endsection
