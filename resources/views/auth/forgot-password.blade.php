@extends('layouts.app')

@section('title', 'Lupa Password — TGN Parfume')

@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="glass-card p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="fs-1 text-accent mb-2"><i class="bi bi-key"></i></div>
                    <h2 class="fw-extrabold mb-1">Lupa Password</h2>
                    <p class="text-secondary small">Masukkan data Anda yang terdaftar untuk verifikasi dan pembaruan password</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $errors->first() }}
                    </div>
                @endif

                <form action="" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-slate-300 small fw-bold" for="fullname">Nama Lengkap</label>
                        <input type="text" id="fullname" name="fullname" class="form-control" placeholder="Nama lengkap Anda" value="{{ old('fullname') }}" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-slate-300 small fw-bold" for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="email@domain.com" value="{{ old('email') }}" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-slate-300 small fw-bold" for="phone">Nomor Telepon / WA</label>
                        <input type="text" id="phone" name="phone" class="form-control" placeholder="08123456789" value="{{ old('phone') }}" required />
                    </div>

                    <div class="mt-4">
                        <button type="submit" name="submit" class="btn btn-gradient btn-lg w-100 font-heading fw-bold py-3 mb-3">
                            <i class="bi bi-shield-check me-2"></i>Verifikasi &amp; Lanjutkan
                        </button>
                    </div>

                    <div class="text-center text-secondary small">
                        Ingat password Anda? <a href="{{ url('/sign-in.php') }}" class="text-accent fw-bold text-decoration-none">Masuk di Sini</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
