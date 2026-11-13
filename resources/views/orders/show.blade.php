@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->id . ' — TGN Parfume')

@section('content')
<div class="container">
    <!-- Breadcrumbs -->
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-secondary text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('orders.index') }}" class="text-secondary text-decoration-none">Riwayat Pesanan</a></li>
                <li class="breadcrumb-item active text-accent fw-bold" aria-current="page">Pesanan #{{ $order->id }}</li>
            </ol>
        </nav>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-extrabold mb-1">
                Detail Pesanan <span class="text-accent">#{{ $order->id }}</span>
            </h1>
            <p class="text-secondary mb-0">Ditempatkan pada tanggal {{ $order->placed_on }}</p>
        </div>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-custom btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
        </a>
    </div>

    <div class="row g-4">
        <!-- Main details -->
        <div class="col-lg-8">
            <div class="glass-card p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-box-seam text-accent me-2"></i>Rincian Item Parfum</h5>
                    <span class="badge {{ $order->payment_status === 'Completed' ? 'bg-success bg-opacity-25 text-success border border-success' : ($order->payment_status === 'Cancelled' ? 'bg-danger bg-opacity-25 text-danger border border-danger' : 'bg-warning bg-opacity-25 text-warning border border-warning') }} px-3 py-2">
                        Status: {{ $order->payment_status }}
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr class="text-secondary small">
                                <th>Produk</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light p-2 rounded-3 me-3">
                                            <img src="{{ asset('assets/img/favicon1.png') }}" alt="TGN" width="36" class="img-fluid">
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0">{{ $order->total_products }}</h6>
                                            <span class="text-secondary small">Parfum Original TGN</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end fw-bold text-dark">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-secondary">Biaya Pengiriman</td>
                                <td class="text-end text-success fw-bold">Gratis Ongkir</td>
                            </tr>
                            <tr class="border-top">
                                <td class="fw-bold text-dark fs-5">TOTAL TAGIHAN</td>
                                <td class="text-end fw-extrabold text-warning fs-5">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Payment details -->
            <div class="glass-card p-4">
                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-credit-card text-accent me-2"></i>Metode Pembayaran</h5>
                <div class="p-3 bg-light rounded-3 border">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-secondary small d-block">Metode yang Digunakan</span>
                            <span class="fw-bold text-dark">{{ $order->method }}</span>
                        </div>
                        <span class="badge bg-success bg-opacity-25 text-success border border-success px-3 py-2">
                            {{ strtoupper($order->payment_status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar shipping info -->
        <div class="col-lg-4">
            <div class="glass-card p-4 sticky-top" style="top: 100px;">
                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-geo-alt text-accent me-2"></i>Tujuan Pengiriman</h5>
                
                <div class="mb-3">
                    <span class="text-secondary small d-block">Nama Penerima</span>
                    <span class="fw-bold text-dark">{{ $order->name }}</span>
                </div>

                <div class="mb-3">
                    <span class="text-secondary small d-block">Nomor Telepon</span>
                    <span class="fw-bold text-dark"><i class="bi bi-telephone me-1"></i>{{ $order->number }}</span>
                </div>

                <div class="mb-3">
                    <span class="text-secondary small d-block">Alamat Pengiriman</span>
                    <p class="text-slate-300 small mb-0">{{ $order->address }}</p>
                    @if($order->address2)
                        <span class="text-secondary small d-block mt-1">Catatan: {{ $order->address2 }}</span>
                    @endif
                </div>

                <hr class="my-3">

                <a href="{{ route('orders.index') }}" class="btn btn-outline-custom w-100 py-2">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
