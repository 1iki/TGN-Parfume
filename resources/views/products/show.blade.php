@extends('layouts.app')

@section('title', $product ? ($product->name . ' — TGN Parfume') : 'Produk — TGN Parfume')

@section('content')
<div class="container">
    <!-- Breadcrumbs -->
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-secondary text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-secondary text-decoration-none">Katalog</a></li>
                <li class="breadcrumb-item active text-accent fw-bold" aria-current="page">{{ $product->name ?? 'Detail Parfum' }}</li>
            </ol>
        </nav>
    </div>

    @if($product)
        <div class="mb-3">
            <a href="{{ route('products.index') }}" class="btn btn-outline-custom btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Katalog
            </a>
        </div>

        <div class="glass-card p-4 p-md-5">
            <form action="{{ url('/product.php') }}" method="POST" data-fly-to="#tgn-cart-fly-target">
                @csrf
                <input type="hidden" name="pid" value="{{ $product->legacy_id ?? $product->_id }}">
                <input type="hidden" name="name" value="{{ $product->name }}">
                <input type="hidden" name="price" value="{{ $product->price }}">
                <input type="hidden" name="image" value="{{ $product->image }}">

                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6 text-center mb-4 mb-md-0">
                        <div class="bg-light p-4 rounded-4 d-inline-block w-100">
                            <img class="img-fluid" data-fly-image
                                 src="{{ asset('uploaded_img/' . trim($product->image)) }}"
                                 alt="{{ $product->name }}" style="max-height: 380px; object-fit: contain;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="text-secondary small">SKU: TGN-{{ $product->legacy_id ?? $product->_id }}</span>
                            <span class="badge {{ strtolower($product->categories) === 'female' ? 'badge-female' : 'badge-category' }}">
                                {{ ucfirst($product->categories) }}
                            </span>
                        </div>
                        <h1 class="fw-extrabold mb-2">{{ $product->name }}</h1>
                        <div class="fs-3 mb-3">
                            <span class="fw-bold text-warning">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                        <p class="text-slate-300 leading-relaxed mb-3">{{ $product->details }}</p>
                        <div class="p-3 bg-light rounded-3 mb-4 border">
                            <span class="text-secondary small d-block mb-1">Komposisi &amp; Bahan Utama:</span>
                            <span class="fw-bold text-dark"><i class="bi bi-eyedropper me-1 text-primary"></i> {{ $product->ingredient }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div>
                                <label class="visually-hidden" for="qty-input">Jumlah</label>
                                <input id="qty-input" class="form-control text-center" name="qty" type="number" min="1" value="1" style="max-width: 5.5rem;" />
                            </div>
                            <button class="btn btn-gradient btn-lg flex-grow-1 flex-md-grow-0 px-4 font-heading fw-bold" type="submit" name="add_to_cart" value="1">
                                <i class="bi bi-cart-plus me-2"></i>Tambah ke Keranjang
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @else
        <div class="glass-card p-5 text-center my-5">
            <i class="bi bi-exclamation-circle fs-1 text-secondary mb-3"></i>
            <h4 class="fw-bold mb-2">Produk Tidak Ditemukan</h4>
            <p class="text-secondary">Produk yang Anda cari tidak tersedia atau telah dihapus.</p>
            <a href="{{ route('products.index') }}" class="btn btn-gradient mt-2">Kembali ke Katalog</a>
        </div>
    @endif
</div>
@endsection
