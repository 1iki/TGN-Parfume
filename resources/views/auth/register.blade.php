@extends('layouts.app')

@section('title', 'Daftar Akun Baru — TGN Parfume')

@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="glass-card p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="fs-1 text-accent mb-2"><i class="bi bi-person-plus"></i></div>
                    <h2 class="fw-extrabold mb-1">Buat Akun Baru</h2>
                    <p class="text-secondary small">Bergabunglah dengan komunitas pencinta keharuman TGN Parfume</p>
                </div>

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-slate-300 small fw-bold" for="reg-name">Nama Lengkap</label>
                            <input type="text" id="reg-name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="John Doe" value="{{ old('name') }}" required>
                            @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-slate-300 small fw-bold" for="reg-username">Username</label>
                            <input type="text" id="reg-username" name="username" class="form-control @error('username') is-invalid @enderror" placeholder="johndoe" value="{{ old('username') }}" required>
                            @error('username')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-slate-300 small fw-bold" for="reg-email">Email</label>
                            <input type="email" id="reg-email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="email@domain.com" value="{{ old('email') }}" required>
                            @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-slate-300 small fw-bold" for="reg-phone">Nomor Telepon / WA</label>
                            <input type="text" id="reg-phone" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="08123456789" value="{{ old('phone') }}" required>
                            @error('phone')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-slate-300 small fw-bold" for="reg-password">Password</label>
                            <input type="password" id="reg-password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 6 karakter" required>
                            @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-slate-300 small fw-bold" for="reg-password-confirmation">Konfirmasi Password</label>
                            <input type="password" id="reg-password-confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-gradient btn-lg w-100 font-heading fw-bold py-3 mb-3">
                                <i class="bi bi-person-check me-2"></i>Daftar Sekarang
                            </button>
                            <div class="text-center text-secondary small">
                                Sudah memiliki akun? <a href="{{ route('login') }}" class="text-accent fw-bold text-decoration-none">Masuk di Sini</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
