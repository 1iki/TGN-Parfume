@extends('layouts.app')

@section('title', 'Hubungi Kami — TGN Parfume')

@section('content')
<div class="container">
    <div class="mb-4 text-center">
        <h1 class="fw-extrabold mb-2">Hubungi <span class="text-accent">TGN Parfume</span></h1>
        <p class="text-secondary mx-auto mb-0" style="max-width: 600px;">Punya pertanyaan, saran, atau butuh bantuan konsultasi aroma? Kami siap melayani Anda sepenuh hati.</p>
    </div>

    <div class="row g-4 my-3">
        <!-- Contact Form -->
        <div class="col-lg-7">
            <div class="glass-card p-4 p-md-5">
                <h4 class="fw-bold text-dark mb-4"><i class="bi bi-send text-accent me-2"></i>Kirim Pesan Anda</h4>

                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-slate-300 small fw-bold" for="contact-name">Nama Lengkap</label>
                            <input type="text" id="contact-name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan nama Anda" value="{{ old('name', Auth::user()->fullname ?? Auth::user()->username ?? '') }}" required>
                            @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-slate-300 small fw-bold" for="contact-email">Email</label>
                            <input type="email" id="contact-email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="email@contoh.com" value="{{ old('email', Auth::user()->email ?? '') }}" required>
                            @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label text-slate-300 small fw-bold" for="contact-number">Nomor Telepon / WA</label>
                            <input type="text" id="contact-number" name="number" class="form-control @error('number') is-invalid @enderror" placeholder="081234567890" value="{{ old('number', Auth::user()->phone ?? '') }}" required>
                            @error('number')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label text-slate-300 small fw-bold" for="contact-message">Pesan / Masukan</label>
                            <textarea id="contact-message" name="message" rows="5" class="form-control @error('message') is-invalid @enderror" placeholder="Tuliskan pesan Anda di sini..." required>{{ old('message') }}</textarea>
                            @error('message')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-12 mt-4">
                            <button type="submit" class="btn btn-gradient btn-lg w-100 font-heading fw-bold py-3">
                                <i class="bi bi-send me-2"></i> Kirim Pesan Sekarang
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Contact Info Side Card -->
        <div class="col-lg-5">
            <div class="glass-card p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <h4 class="fw-bold text-dark mb-4"><i class="bi bi-headset text-primary me-2"></i>Informasi Kontak</h4>
                    
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="fs-4 text-accent bg-light p-3 rounded-circle border"><i class="bi bi-geo-alt"></i></div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">Alamat Headquarter</h6>
                            <p class="text-secondary small mb-0">Jl. Buncit Raya No.98, Pejaten Barat, Pasar Minggu, Jakarta Selatan 12510</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="fs-4 text-primary bg-light p-3 rounded-circle border"><i class="bi bi-whatsapp"></i></div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">Layanan Customer Service</h6>
                            <p class="text-secondary small mb-0">+62 815-8061-371 (Senin - Sabtu, 08:00 - 20:00 WIB)</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="fs-4 text-warning bg-light p-3 rounded-circle border"><i class="bi bi-envelope"></i></div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">Email Resmi</h6>
                            <p class="text-secondary small mb-0">support@tgnparfume.com / info@tgnparfume.com</p>
                        </div>
                    </div>
                </div>

                <div class="p-3 bg-light rounded-3 border text-center">
                    <p class="text-slate-300 small mb-0"><i class="bi bi-shield-check text-success me-1"></i> Respon cepat dalam waktu kurang dari 24 jam kerja.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
