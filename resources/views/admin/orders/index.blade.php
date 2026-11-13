@extends('layouts.admin')

@section('title', 'Kelola Pesanan — Admin TGN Parfume')
@section('page-title', 'Manajemen Pesanan Pelanggan')

@section('content')
<div class="mb-4">
    <p class="text-secondary mb-0">Total {{ $orders->count() }} transaksi pesanan tercatat di MongoDB `orders` collection</p>
</div>

@if($orders->isEmpty())
    <div class="stat-card text-center p-5">
        <i class="bi bi-inbox fs-1 text-secondary mb-3 d-block"></i>
        <h4 class="fw-bold text-dark">Belum Ada Pesanan Masuk</h4>
        <p class="text-secondary">Pesanan yang dibuat oleh pelanggan akan tampil di halaman ini.</p>
    </div>
@else
    <div class="row g-4">
        @foreach($orders as $order)
            <div class="col-12">
                <div class="stat-card">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 border-bottom pb-3 mb-3">
                        <div>
                            <span class="text-xs text-secondary d-block">Pemesan &amp; Tanggal</span>
                            <h6 class="fw-bold text-dark mb-0">
                                <i class="bi bi-person text-primary me-1"></i> {{ $order->name }} ({{ $order->number }})
                            </h6>
                            <span class="text-xs text-secondary">{{ $order->email }} &bull; {{ $order->placed_on }}</span>
                        </div>

                        <div>
                            <span class="text-xs text-secondary d-block">Metode Pembayaran</span>
                            <span class="badge bg-light border text-dark">{{ $order->method }}</span>
                        </div>

                        <div>
                            <span class="text-xs text-secondary d-block">Status Pembayaran</span>
                            <span class="badge {{ $order->payment_status === 'Completed' ? 'bg-success bg-opacity-25 text-success border border-success' : ($order->payment_status === 'Cancelled' ? 'bg-danger bg-opacity-25 text-danger border border-danger' : 'bg-warning bg-opacity-25 text-warning border border-warning') }}">
                                {{ $order->payment_status }}
                            </span>
                        </div>

                        <div>
                            <span class="text-xs text-secondary d-block mb-1">Update Status</span>
                            <form action="{{ route('admin.orders.updateStatus', $order->_id) }}" method="POST" class="d-flex align-items-center gap-2"
                                  data-confirm
                                  data-confirm-title="Batalkan Pesanan"
                                  data-confirm-text="Pesanan {{ $order->name }} akan dibatalkan. Lanjutkan?"
                                  data-confirm-accept="Ya, Batalkan">
                                @csrf
                                @method('PUT')
                                <label class="visually-hidden" for="status-{{ $order->_id }}">Status pembayaran pesanan {{ $order->name }}</label>
                                <select name="payment_status" id="status-{{ $order->_id }}" data-cancel-confirm="1"
                                        class="form-select form-select-sm">
                                    <option value="Pending" {{ $order->payment_status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Completed" {{ $order->payment_status === 'Completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="Cancelled" {{ $order->payment_status === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-7">
                            <h6 class="text-secondary small text-uppercase fw-bold mb-1">Ringkasan Rincian Produk:</h6>
                            <p class="p-3 bg-light rounded-3 border mb-0 small text-dark">
                                {{ $order->total_products }}
                            </p>
                        </div>
                        <div class="col-md-5">
                            <h6 class="text-secondary small text-uppercase fw-bold mb-1">Alamat Tujuan Pengiriman:</h6>
                            <p class="text-slate-300 small mb-2"><i class="bi bi-geo-alt me-1 text-accent"></i> {{ $order->address }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                                <span class="text-secondary small">Total Tagihan:</span>
                                <span class="fw-extrabold text-warning fs-5">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-primary" title="Lihat Detail Pesanan"
                                            data-view-target="order-viewer-modal"
                                            data-name="{{ $order->name }}"
                                            data-number="{{ $order->number }}"
                                            data-email="{{ $order->email }}"
                                            data-placed-on="{{ $order->placed_on }}"
                                            data-method="{{ $order->method }}"
                                            data-status="{{ $order->payment_status }}"
                                            data-address="{{ $order->address }}"
                                            data-products="{{ $order->total_products }}"
                                            data-price="Rp {{ number_format($order->total_price, 0, ',', '.') }}">
                                        <i class="bi bi-receipt me-1"></i> Detail
                                    </button>
                                    <form action="{{ route('admin.orders.destroy', $order->_id) }}" method="POST"
                                          data-confirm
                                          data-confirm-title="Hapus Pesanan"
                                          data-confirm-text="Pesanan {{ $order->name }} akan dihapus permanen dari riwayat. Lanjutkan?"
                                          data-confirm-accept="Ya, Hapus">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Pesanan">
                                            <i class="bi bi-trash3"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

{{-- Order detail viewer --}}
<div class="modal fade" id="order-viewer-modal" tabindex="-1" aria-labelledby="order-viewer-title" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="order-viewer-title"><i class="bi bi-receipt text-primary me-2"></i>Detail Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <span class="text-secondary small d-block">Pemesan</span>
                        <h6 class="fw-bold text-dark mb-0" data-fill="name"></h6>
                        <span class="text-slate-300 small" data-fill="number"></span> &bull;
                        <span class="text-slate-300 small" data-fill="email"></span>
                    </div>
                    <div class="col-md-3">
                        <span class="text-secondary small d-block">Tanggal</span>
                        <span class="text-dark small" data-fill="placed-on"></span>
                    </div>
                    <div class="col-md-3">
                        <span class="text-secondary small d-block">Pembayaran</span>
                        <span class="text-dark small" data-fill="method"></span><br>
                        <span class="badge bg-light border text-warning small" data-fill="status"></span>
                    </div>
                </div>
                <div class="bg-light p-3 rounded-3 border mb-3">
                    <span class="text-secondary small d-block mb-1">Produk Dipesan</span>
                    <p class="text-dark mb-0" data-fill="products" style="white-space: pre-line;"></p>
                </div>
                <div class="bg-light p-3 rounded-3 border mb-2">
                    <span class="text-secondary small d-block mb-1">Alamat Pengiriman</span>
                    <p class="text-dark mb-0" data-fill="address"></p>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <span class="text-secondary small">Total Tagihan</span>
                <span class="fw-extrabold text-warning fs-5" data-fill="price"></span>
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection
