@extends('layouts.app')

@section('title', 'Keranjang Belanja — TGN Parfume')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-extrabold mb-1">
                Keranjang <span class="text-accent">Belanja</span>
            </h1>
            <p class="text-secondary mb-0">Kelola daftar item parfum yang akan Anda beli</p>
        </div>

        @if(count($cartItems) > 0)
            <a href="{{ url('/cart.php?delete_all') }}" class="btn btn-outline-danger btn-sm"
               data-confirm
               data-confirm-title="Kosongkan Keranjang"
               data-confirm-text="Apakah Anda yakin ingin menghapus semua item dari keranjang?"
               data-confirm-accept="Ya, Kosongkan">
                <i class="bi bi-trash3 me-1"></i> Kosongkan Keranjang
            </a>
        @endif
    </div>

    @if(count($cartItems) > 0)
        @php $computed_total = 0; @endphp
        <div class="row g-4">
            <!-- Items Column -->
            <div class="col-lg-8">
                @foreach($cartItems as $fetch_cart)
                    @php
                        $sub_total = ($fetch_cart->price * $fetch_cart->quantity);
                        $computed_total += $sub_total;
                    @endphp
                    <div class="glass-card p-3 p-md-4 mb-3">
                        <form action="{{ url('/cart.php') }}" method="POST">
                            @csrf
                            <input type="hidden" name="cart_id" value="{{ $fetch_cart->_id ?? $fetch_cart->id }}">

                            <div class="row align-items-center gy-3">
                                <!-- Image -->
                                <div class="col-3 col-md-2 text-center">
                                    <div class="bg-light p-2 rounded-3">
                                        <img src="{{ asset('assets/img/menu/' . $fetch_cart->image) }}"
                                             class="img-fluid" alt="{{ $fetch_cart->name }}"
                                             onerror="this.src='{{ asset('uploaded_img/' . $fetch_cart->image) }}';"
                                             style="max-height: 80px; object-fit: contain;">
                                    </div>
                                </div>

                                <!-- Details -->
                                <div class="col-9 col-md-4">
                                    <h5 class="fw-bold mb-1 text-dark">{{ $fetch_cart->name }}</h5>
                                    <span class="text-secondary small d-block">Harga Satuan: Rp {{ number_format($fetch_cart->price, 0, ',', '.') }}</span>
                                </div>

                                <!-- Quantity Controls -->
                                <div class="col-6 col-md-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <label class="visually-hidden" for="qty-{{ $fetch_cart->_id ?? $fetch_cart->id }}">Jumlah</label>
                                        <input id="qty-{{ $fetch_cart->_id ?? $fetch_cart->id }}"
                                               name="qty"
                                               value="{{ $fetch_cart->quantity }}"
                                               type="number" min="1"
                                               class="form-control form-control-sm text-center"
                                               style="width: 70px;" />
                                        <button type="submit" name="update_qty" class="btn btn-sm btn-outline-custom" title="Perbarui Jumlah">
                                            <i class="bi bi-arrow-repeat"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Subtotal & Delete -->
                                <div class="col-6 col-md-3 text-end">
                                    <div class="fw-bold text-warning fs-5 mb-1">
                                        Rp {{ number_format($sub_total, 0, ',', '.') }}
                                    </div>
                                    <button type="submit" name="delete" class="btn btn-sm btn-outline-danger border-0" title="Hapus Produk">
                                        <i class="bi bi-trash3 me-1"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>

            <!-- Summary Column -->
            <div class="col-lg-4">
                <div class="glass-card p-4 sticky-top" style="top: 100px;">
                    <h5 class="fw-bold text-dark mb-3">Ringkasan Belanja</h5>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Total Item</span>
                        <span class="fw-bold text-dark">{{ $cartItems->sum('quantity') }} pcs</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Ongkos Kirim</span>
                        <span class="text-success fw-bold">Gratis Ongkir</span>
                    </div>

                    <hr class="my-3">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="fw-bold text-dark fs-5">Total Tagihan</span>
                        <span class="fw-extrabold text-warning fs-4">
                            Rp {{ number_format($grandTotal ?? $computed_total, 0, ',', '.') }}
                        </span>
                    </div>

                    <a href="{{ url('/checkout.php') }}"
                       class="btn btn-gradient btn-lg w-100 font-heading fw-bold py-3 mb-2">
                        <i class="bi bi-credit-card me-2"></i>Lanjut ke Pembayaran
                    </a>

                    <a href="{{ route('products.index') }}" class="btn btn-outline-custom w-100 text-center py-2">
                        <i class="bi bi-arrow-left me-1"></i> Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="glass-card p-5 text-center my-5">
            <i class="bi bi-bag-x fs-1 text-secondary mb-3 d-block"></i>
            <h4 class="fw-bold mb-2">Keranjang Anda Kosong</h4>
            <p class="empty mb-3">keranjang Anda kosong</p>
            <a href="{{ route('products.index') }}" class="btn btn-gradient px-4 py-2 font-heading fw-bold">
                <i class="bi bi-cart-plus me-2"></i>Mulai Belanja Sekarang
            </a>
        </div>
    @endif
</div>
@endsection
