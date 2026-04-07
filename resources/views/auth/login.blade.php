@extends('layouts.auth')

@section('title', 'Login')

@section('content')

<div class="brand-logo text-center">
    <img src="{{ asset('assets/images/logo.svg') }}" alt="logo">
    <h2>Fishy Paperie</h2>
</div>

<h4 class="text-center mb-1">Selamat Datang</h4>
<p class="text-center text-muted mb-4">Silakan login untuk melanjutkan</p>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf
    
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="mdi mdi-account"></i>
                </span>
            </div>
            <input type="email" 
                   class="form-control form-control-lg"
                   name="email"
                   placeholder="Email"
                   value="{{ old('email') }}"
                   required autofocus>
        </div>
    </div>
    
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="mdi mdi-lock"></i>
                </span>
            </div>
            <input type="password" 
                   class="form-control form-control-lg"
                   name="password"
                   placeholder="Password"
                   required>
        </div>
    </div>
    
    <div class="form-group">
        <div class="form-check">
            <label class="form-check-label text-muted">
                <input type="checkbox" class="form-check-input" name="remember">
                Ingat Saya
            </label>
        </div>
    </div>
    
    <div class="mt-4">
        <button type="submit" class="btn btn-gradient-primary btn-lg w-100 auth-form-btn">
            <i class="mdi mdi-login"></i>
            LOGIN
        </button>
    </div>
    
    <div class="mt-3">
    <a href="/auth/google" class="btn btn-danger btn-lg w-100">
        <i class="mdi mdi-google"></i>
        Login dengan Google
    </a>
    </div>


    <div class="text-center mt-3">
        <a href="{{ route('password.request') }}" class="auth-link">Lupa Password?</a>
    </div>

    <div class="text-center mt-3 text-muted">
        Belum punya akun? 
        <a href="{{ route('register') }}" class="auth-link">Daftar</a>
    </div>

</form>

@endsection
