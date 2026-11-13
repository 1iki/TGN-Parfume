@extends('layouts.app')

@section('title', 'Masuk Akun — TGN Parfume')

@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="glass-card p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="fs-1 text-accent mb-2"><i class="bi bi-person-circle"></i></div>
                    <h2 class="fw-extrabold mb-1">Masuk ke Akun Anda</h2>
                    <p class="text-secondary small">Nikmati kemudahan berbelanja aroma eksklusif di TGN Parfume</p>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger mb-4" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-slate-300 small fw-bold" for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}" placeholder="Masukkan username Anda" required />
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label text-slate-300 small fw-bold mb-0" for="pass">Password</label>
                            <a href="{{ url('/forgot-password.php') }}" class="small text-accent text-decoration-none">Lupa Password?</a>
                        </div>
                        <input type="password" id="pass" name="pass" class="form-control" placeholder="Masukkan password Anda" required />
                    </div>

                    <div class="mt-4">
                        <button type="submit" name="submit" class="btn btn-gradient btn-lg w-100 font-heading fw-bold py-3 mb-3">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sekarang
                        </button>
                    </div>

                    <div class="text-center text-secondary small">
                        Belum memiliki akun? <a href="{{ url('/sign-up.php') }}" class="text-accent fw-bold text-decoration-none">Daftar Akun Baru</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
