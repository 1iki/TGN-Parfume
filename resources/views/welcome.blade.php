@extends('layouts.app')

@section('title', 'TGN Premium Parfume')

@section('content')
<div class="container py-5 text-center">
    <div class="glass-card p-5 mx-auto" style="max-width: 680px;">
        <div class="mb-3">
            <img src="{{ asset('assets/img/Logo-TGN.png') }}" alt="TGN Logo" class="img-fluid" style="max-height: 80px;">
        </div>
        <h1 class="fw-extrabold mb-3">Selamat Datang di <span class="text-accent">TGN Parfume</span></h1>
        <p class="text-secondary leading-relaxed mb-4">
            Temukan koleksi wewangian premium dengan konsentrasi aroma terbaik yang tahan lama dan menyegarkan hari-hari Anda.
        </p>
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('products.index') }}" class="btn btn-gradient px-4 py-2 font-heading fw-bold">
                <i class="bi bi-grid me-1"></i> Jelajahi Katalog
            </a>
            <a href="{{ url('/#about') }}" class="btn btn-outline-custom px-4 py-2 font-heading">
                Tentang Kami
            </a>
        </div>
    </div>
</div>
@endsection
