@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="brand-logo">
    <img src="{{ asset('assets/images/logo.svg') }}" alt="logo">
    <h2>Fishy Paperie</h2>
</div>

<h4 class="text-center mb-4">Daftar Akun Baru</h4>
<h6 class="font-weight-light text-center mb-4">Lengkapi data dibawah untuk mendaftar</h6>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form class="pt-3" method="POST" action="{{ route('register') }}">
    @csrf
    
    {{-- Name --}}
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="mdi mdi-account-outline"></i>
                </span>
            </div>
            <input type="text" 
                   class="form-control form-control-lg @error('name') is-invalid @enderror" 
                   id="name" 
                   name="name"
                   placeholder="Nama Lengkap" 
                   value="{{ old('name') }}"
                   required 
                   autofocus>
        </div>
        @error('name')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    
    {{-- Email --}}
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="mdi mdi-email-outline"></i>
                </span>
            </div>
            <input type="email" 
                   class="form-control form-control-lg @error('email') is-invalid @enderror" 
                   id="email" 
                   name="email"
                   placeholder="Email" 
                   value="{{ old('email') }}"
                   required>
        </div>
        @error('email')
            <small class="text-danger">{{ $message }}</small>
        @enderror
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
                   class="form-control form-control-lg @error('password') is-invalid @enderror" 
                   id="password" 
                   name="password"
                   placeholder="Password" 
                   required>
        </div>
        @error('password')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    
    {{-- Confirm Password --}}
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="mdi mdi-lock-check-outline"></i>
                </span>
            </div>
            <input type="password" 
                   class="form-control form-control-lg" 
                   id="password-confirm" 
                   name="password_confirmation"
                   placeholder="Konfirmasi Password" 
                   required>
        </div>
    </div>
    
    {{-- Terms & Conditions --}}
    <div class="form-group">
        <div class="form-check">
            <label class="form-check-label text-muted">
                <input type="checkbox" class="form-check-input" required>
                <i class="input-helper"></i>
                Saya setuju dengan <a href="#" class="auth-link">Syarat & Ketentuan</a>
            </label>
        </div>
    </div>
    
    {{-- Register Button --}}
    <div class="mt-4">
        <button type="submit" class="btn btn-gradient-primary btn-lg w-100 auth-form-btn">
            <i class="mdi mdi-account-plus"></i> DAFTAR
        </button>
    </div>
    
    {{-- Login Link --}}
    <div class="text-center mt-4 font-weight-light">
        Sudah punya akun? <a href="{{ route('login') }}" class="auth-link">Login Sekarang</a>
    </div>
</form>
@endsection