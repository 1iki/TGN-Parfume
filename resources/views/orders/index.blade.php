@extends('layouts.app')

@section('title', 'Riwayat Pesanan Saya — TGN Parfume')

@section('content')
<div class="container">
    <div class="mb-4">
        <h1 class="fw-extrabold mb-1">
            Riwayat <span class="text-accent">Pesanan</span>
        </h1>
        <p class="text-secondary mb-0">Daftar transaksi dan status pemesanan parfum Anda</p>
    </div>

    @forelse($orders as $fetch_orders)
        <div class="glass-card p-4 mb-3">
            <div class="row align-items-center gy-3">
                <div class="col-md-3">
                    <span class="text-secondary small d-block">Tanggal Transaksi</span>
                    <span class="fw-bold text-dark">{{ $fetch_orders->placed_on }}</span>
                    <span class="badge {{ $fetch_orders->payment_status === 'Completed' ? 'bg-success bg-opacity-25 text-success border border-success' : ($fetch_orders->payment_status === 'Cancelled' ? 'bg-danger bg-opacity-25 text-danger border border-danger' : 'bg-warning bg-opacity-25 text-warning border border-warning') }} mt-2">
                        {{ $fetch_orders->payment_status }}
                    </span>
                </div>

                <div class="col-md-5">
                    <span class="text-secondary small d-block">Produk Dibeli</span>
                    <p class="fw-bold text-dark mb-1">{{ $fetch_orders->total_products }}</p>
                    <span class="text-secondary small d-block text-truncate"><i class="bi bi-geo-alt me-1"></i>{{ $fetch_orders->address }}</span>
                </div>

                <div class="col-md-2 text-md-center">
                    <span class="text-secondary small d-block">Total Tagihan</span>
                    <span class="fw-bold text-warning fs-5">Rp {{ number_format($fetch_orders->total_price, 0, ',', '.') }}</span>
                </div>

                <div class="col-md-2 text-md-end">
                    <a href="{{ url('/purchase-history-details.php?pid=' . ($fetch_orders->legacy_id ?? $fetch_orders->_id ?? $fetch_orders->id)) }}"
                       class="btn btn-gradient btn-sm font-heading fw-bold px-3 py-2">
                        <i class="bi bi-eye me-1"></i> Detail Pesanan
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="glass-card p-5 text-center my-5">
            <i class="bi bi-receipt fs-1 text-secondary mb-3 d-block"></i>
            <h4 class="fw-bold mb-2">Belum Ada Riwayat Pesanan</h4>
            <p class="empty mb-3">no orders placed yet!</p>
            <a href="{{ route('products.index') }}" class="btn btn-gradient px-4 py-2 font-heading fw-bold">
                <i class="bi bi-cart-plus me-2"></i>Mulai Belanja Parfum
            </a>
        </div>
    @endforelse
</div>
@endsection
