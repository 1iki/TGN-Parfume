@extends('layouts.app')

@section('title', 'Pembaruan Password — TGN Parfume')

@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="glass-card p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="fs-1 text-accent mb-2"><i class="bi bi-shield-lock"></i></div>
                    <h2 class="fw-extrabold mb-1">Perbarui Password</h2>
                    <p class="text-secondary small">Buat password baru yang aman untuk akun Anda</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $errors->first() }}
                    </div>
                @endif

                <form action="" method="post">
                    @csrf
                    <input type="hidden" name="name" value="">
                    <input type="hidden" name="email" value="">
                    <input type="hidden" name="prev_pass" value="">

                    <div class="mb-3">
                        <label class="form-label text-slate-300 small fw-bold" for="new_pass">Password Baru</label>
                        <input type="password" id="new_pass" name="new_pass" class="form-control" placeholder="Masukkan password baru" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-slate-300 small fw-bold" for="cpass">Konfirmasi Password Baru</label>
                        <input type="password" id="cpass" name="cpass" class="form-control" placeholder="Ulangi password baru" required />
                    </div>

                    <div class="mt-4">
                        <button type="submit" name="submit" class="btn btn-gradient btn-lg w-100 font-heading fw-bold py-3 mb-3">
                            <i class="bi bi-check2-circle me-2"></i>Simpan Password Baru
                        </button>
                    </div>

                    <div class="text-center text-secondary small">
                        Batal dan kembali ke halaman <a href="{{ url('/sign-in.php') }}" class="text-accent fw-bold text-decoration-none">Masuk</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
