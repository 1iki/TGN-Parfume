@extends('layouts.app')

@section('title', 'Katalog Parfum — TGN Parfume')

@section('content')
<div class="container">
    <!-- Header Title & Filters -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="fw-extrabold mb-1">
                Katalog Parfum <span class="text-accent">Eksklusif</span>
            </h1>
            <p class="text-secondary mb-0">Temukan racikan aroma favorit Anda di bawah ini</p>
        </div>

        <!-- Filter Tabs -->
        <div class="btn-group bg-white p-1 rounded-pill border shadow-sm">
            <a href="{{ route('products.index') }}" class="btn btn-sm {{ !$category ? 'btn-gradient' : 'btn-outline-custom text-slate-300 border-0' }} rounded-pill px-3">
                Semua Parfum
            </a>
            <a href="{{ route('products.index', ['category' => 'male']) }}" class="btn btn-sm {{ $category === 'male' ? 'btn-gradient' : 'btn-outline-custom text-slate-300 border-0' }} rounded-pill px-3">
                <i class="bi bi-gender-male me-1"></i> Pria
            </a>
            <a href="{{ route('products.index', ['category' => 'female']) }}" class="btn btn-sm {{ $category === 'female' ? 'btn-gradient' : 'btn-outline-custom text-slate-300 border-0' }} rounded-pill px-3">
                <i class="bi bi-gender-female me-1"></i> Wanita
            </a>
        </div>
    </div>

    <!-- Product Grid -->
    @if($products->isEmpty())
        <div class="glass-card p-5 text-center my-5">
            <i class="bi bi-droplet-half fs-1 text-secondary mb-3"></i>
            <h4 class="fw-bold">Tidak ada produk ditemukan</h4>
            <p class="text-secondary">Silakan coba kata kunci atau kategori lainnya.</p>
            <a href="{{ route('products.index') }}" class="btn btn-gradient mt-2">Lihat Semua Produk</a>
        </div>
    @else
        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="glass-card h-100 p-3 d-flex flex-column justify-content-between position-relative">
                        <span class="badge {{ strtolower($product->categories) === 'female' ? 'badge-female' : 'badge-category' }} position-absolute top-0 start-0 m-3 z-1">
                            {{ ucfirst($product->categories) }}
                        </span>

                        <a href="{{ route('products.show', $product->_id) }}" class="text-decoration-none text-dark">
                            <div class="text-center py-3 bg-light rounded-4 mb-3 position-relative overflow-hidden group">
                                <img src="{{ asset('uploaded_img/' . trim($product->image)) }}" alt="{{ $product->name }}" class="img-fluid" style="height: 180px; object-fit: contain; transition: transform 0.3s ease;">
                            </div>

                            <h5 class="fw-bold text-dark mb-1 text-truncate">{{ $product->name }}</h5>
                            <p class="text-secondary small mb-2 text-truncate" title="{{ $product->details }}">{{ $product->details }}</p>
                            <p class="text-xs text-slate-400 mb-3"><i class="bi bi-eyedropper me-1 text-primary"></i> {{ $product->ingredient }}</p>
                        </a>

                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                            <div>
                                <span class="text-xs text-secondary d-block">Harga</span>
                                <span class="fw-bold text-warning fs-5">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <a href="{{ route('products.show', $product->_id) }}" class="btn btn-outline-custom btn-sm rounded-circle p-2 px-3" title="Detail Parfum">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <form action="{{ route('cart.add') }}" method="POST" data-fly-to="#tgn-cart-fly-target">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->_id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-gradient btn-sm rounded-circle p-2 px-3" title="Tambah ke Keranjang">
                                        <i class="bi bi-plus-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
