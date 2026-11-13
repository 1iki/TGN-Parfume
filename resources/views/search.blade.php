@extends('layouts.app')

@section('title', 'Hasil Pencarian — TGN Parfume')

@section('content')
<div class="container">
    <div class="mb-4">
        <h1 class="fw-extrabold mb-1"><i class="bi bi-search text-accent me-2"></i>Hasil Pencarian</h1>
        @if($query)
            <p class="text-secondary mb-0">Menampilkan hasil pencarian untuk: <span class="text-warning fw-bold">"{{ $query }}"</span></p>
        @else
            <p class="text-secondary mb-0">Ketik kata kunci nama parfum, bahan, atau kategori pada kolom pencarian di atas.</p>
        @endif
    </div>

    @if(!$query)
        <div class="glass-card p-5 text-center my-4">
            <i class="bi bi-search fs-1 text-secondary mb-3"></i>
            <h4 class="fw-bold text-dark">Cari Parfum Impian Anda</h4>
            <p class="text-secondary mb-4">Gunakan kolom pencarian di navigasi atas untuk menemukan varian produk.</p>
            <a href="{{ route('products.index') }}" class="btn btn-gradient">Lihat Semua Katalog</a>
        </div>
    @elseif(count($products) == 0)
        <div class="glass-card p-5 text-center my-4">
            <i class="bi bi-emoji-frown fs-1 text-secondary mb-3"></i>
            <h4 class="fw-bold text-dark">Tidak Ada Parfum yang Cocok</h4>
            <p class="text-secondary mb-4">Maaf, kami tidak menemukan hasil untuk kata kunci "{{ $query }}".</p>
            <a href="{{ route('products.index') }}" class="btn btn-gradient">Lihat Katalog Lengkap</a>
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
                                <img src="{{ asset('uploaded_img/' . trim($product->image)) }}" alt="{{ $product->name }}" class="img-fluid" style="height: 160px; object-fit: contain;">
                            </div>
                            <h5 class="fw-bold mb-1 text-truncate text-dark">{{ $product->name }}</h5>
                            <p class="small text-secondary mb-2 text-truncate">{{ $product->details }}</p>
                        </a>

                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                            <span class="fw-bold text-warning fs-5">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <form action="{{ route('cart.add') }}" method="POST">
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
            @endforeach
        </div>
    @endif
</div>
@endsection
