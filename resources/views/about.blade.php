@extends('layouts.app')

@section('title', 'Tentang Kami — TGN Parfume')

@section('content')
<div class="container">
    <!-- Hero Banner -->
    <div class="glass-card p-4 p-md-5 mb-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <span class="badge badge-category mb-3">Seni Keharuman Premium</span>
                <h1 class="display-5 fw-extrabold mb-3">Sentuhan Aroma Memikat Untuk Setiap Kehadiran Anda</h1>
                <p class="text-slate-300 fs-5 mb-0">TGN Parfume lahir dari dedikasi mendalam terhadap keindahan wewangian berkelas tinggi. Kami meracik formula unik yang memadukan keharuman modern dan daya tahan maksimal.</p>
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{ asset('assets/img/about-1.jpg') }}" alt="Tentang TGN Parfume" class="img-fluid rounded-4 shadow-sm border" style="max-height: 320px; object-fit: cover;">
            </div>
        </div>
    </div>

    <!-- Vision & Mission -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="glass-card p-4 h-100">
                <div class="fs-1 text-primary mb-3"><i class="bi bi-gem"></i></div>
                <h4 class="fw-bold text-dark mb-3">Visi Kami</h4>
                <p class="text-secondary leading-relaxed mb-0">Menjadi brand wewangian lokal terdepan yang dikenal secara internasional atas kualitas konsentrasi parfum Eau de Parfum (EDP) murni dan keunikan komposisi aroma pilihan.</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="glass-card p-4 h-100">
                <div class="fs-1 text-accent mb-3"><i class="bi bi-heart-pulse"></i></div>
                <h4 class="fw-bold text-dark mb-3">Misi Kami</h4>
                <p class="text-secondary leading-relaxed mb-0">Menghadirkan pengalaman keharuman mewah yang terjangkau bagi semua orang tanpa mengorbankan standar mutu, keamanan bahan, dan estetika kemasan.</p>
            </div>
        </div>
    </div>
</div>
@endsection
