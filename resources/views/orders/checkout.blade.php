@extends('layouts.app')

@section('title', 'Pembayaran & Checkout — TGN Parfume')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="mb-4">
        <h1 class="fw-extrabold mb-1">
            Checkout &amp; <span class="text-accent">Pembayaran</span>
        </h1>
        <p class="text-secondary mb-0">Lengkapi informasi pengiriman dan metode pembayaran pesanan Anda</p>
    </div>

    @php
        $total_cart_counts = count($cartItems);
        $grand_total = 0;
        $cart_items = [];
    @endphp

    <div class="row g-4">
        <!-- Order Summary Column -->
        <div class="col-md-5 col-lg-4 order-md-last">
            <div class="glass-card p-4 sticky-top" style="top: 100px;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-dark mb-0">Pesanan Anda</h5>
                    <span class="badge badge-category rounded-pill">{{ $total_cart_counts }} item</span>
                </div>

                @if($total_cart_counts > 0)
                    <div class="list-group list-group-flush mb-3">
                        @foreach($cartItems as $fetch_cart)
                            @php
                                $sub_total = ($fetch_cart->price * $fetch_cart->quantity);
                                $grand_total += $sub_total;
                                $cart_items[] = $fetch_cart->name.' ('.$fetch_cart->price.' x '. $fetch_cart->quantity.') - ';
                            @endphp
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 bg-transparent border-bottom">
                                <div>
                                    <h6 class="mb-1 fw-bold text-dark">{{ $fetch_cart->name }}</h6>
                                    <span class="text-secondary small">{{ $fetch_cart->quantity }} x Rp {{ number_format($fetch_cart->price, 0, ',', '.') }}</span>
                                </div>
                                <span class="fw-bold text-dark">Rp {{ number_format($sub_total, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Biaya Pengiriman</span>
                        <span class="text-success fw-bold">Gratis Ongkir</span>
                    </div>

                    <hr class="my-3">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-bold text-dark fs-5">Total Pembayaran</span>
                        <span class="fw-extrabold text-warning fs-4">Rp {{ number_format($grand_total, 0, ',', '.') }}</span>
                    </div>
                @else
                    <p class="empty">Keranjang Anda masih kosong!</p>
                @endif
            </div>
        </div>

        <!-- Billing & Payment Form -->
        <div class="col-md-7 col-lg-8">
            <div class="glass-card p-4 p-md-5">
                <h4 class="fw-bold text-dark mb-4"><i class="bi bi-geo-alt text-accent me-2"></i>Informasi Pengiriman</h4>

                @if($errors->any())
                    <div class="alert alert-danger mb-4" role="alert">
                        <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Periksa kembali data Anda:</div>
                        <ul class="mb-0 ps-3 small">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="firstName" class="form-label text-slate-300 small fw-bold">Nama Depan</label>
                            <input type="text" id="firstName" class="form-control @error('firstname') is-invalid @enderror" name="firstname" placeholder="Nama Depan" value="{{ old('firstname', Auth::user()->fullname ? explode(' ', Auth::user()->fullname)[0] : '') }}" required>
                            <div class="invalid-feedback">Nama depan wajib diisi.</div>
                        </div>

                        <div class="col-sm-6">
                            <label for="lastName" class="form-label text-slate-300 small fw-bold">Nama Belakang</label>
                            <input type="text" id="lastName" class="form-control @error('lastname') is-invalid @enderror" name="lastname" placeholder="Nama Belakang" value="{{ old('lastname') }}" required>
                            <div class="invalid-feedback">Nama belakang wajib diisi.</div>
                        </div>

                        <div class="col-12">
                            <label for="email" class="form-label text-slate-300 small fw-bold">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="nama@domain.com" value="{{ old('email', Auth::user()->email ?? '') }}" required>
                            <div class="invalid-feedback">Email aktif diperlukan untuk konfirmasi pesanan.</div>
                        </div>

                        <div class="col-12">
                            <label for="number" class="form-label text-slate-300 small fw-bold">Nomor Telepon / WhatsApp</label>
                            <input type="text" class="form-control @error('number') is-invalid @enderror" name="number" id="number" placeholder="08123456789" value="{{ old('number', Auth::user()->phone ?? '') }}" required>
                            <div class="invalid-feedback">Nomor kontak wajib diisi.</div>
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label text-slate-300 small fw-bold">Alamat Lengkap</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="address" placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan" value="{{ old('address', Auth::user()->address ?? '') }}" required>
                            <div class="invalid-feedback">Alamat pengiriman wajib diisi.</div>
                        </div>

                        <div class="col-12">
                            <label for="address2" class="form-label text-slate-300 small fw-bold">Catatan / Detail Tambahan <span class="text-secondary fw-normal">(Opsional)</span></label>
                            <input type="text" class="form-control" name="address2" id="address2" placeholder="Patokan atau instruksi kurir" value="{{ old('address2') }}">
                        </div>

                        <div class="col-md-5">
                            <label for="country" class="form-label text-slate-300 small fw-bold">Negara</label>
                            <select class="form-select" name="country" id="country" required>
                                <option value="Indonesia" selected>Indonesia</option>
                                <option value="Singapore">Singapore</option>
                                <option value="Malaysia">Malaysia</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="city" class="form-label text-slate-300 small fw-bold">Kota / Kabupaten</label>
                            <input class="form-control @error('city') is-invalid @enderror" name="city" id="city" placeholder="Jakarta Selatan" value="{{ old('city') }}" required>
                            <div class="invalid-feedback">Kota tujuan wajib diisi.</div>
                        </div>

                        <div class="col-md-3">
                            <label for="zip" class="form-label text-slate-300 small fw-bold">Kode Pos</label>
                            <input type="text" class="form-control @error('zip') is-invalid @enderror" name="zip" id="zip" placeholder="12510" value="{{ old('zip') }}" required>
                            <div class="invalid-feedback">Kode pos wajib diisi.</div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h4 class="fw-bold text-dark mb-3"><i class="bi bi-wallet2 text-accent me-2"></i>Metode Pembayaran</h4>

                    <div class="p-3 bg-light rounded-3 border mb-3">
                        <div class="form-check mb-2">
                            <input id="credit" name="method" value="credit" type="radio" class="form-check-input" @checked(!old('method') || old('method') === 'credit') required>
                            <label class="form-check-label fw-bold text-dark" for="credit">Kartu Kredit / Debit Online</label>
                        </div>
                        <div class="form-check mb-2">
                            <input id="debit" name="method" value="debit" type="radio" class="form-check-input" @checked(old('method') === 'debit') required>
                            <label class="form-check-label fw-bold text-dark" for="debit">Transfer Bank (Virtual Account)</label>
                        </div>
                        <div class="form-check">
                            <input id="paypal" name="method" value="paypal" type="radio" class="form-check-input" @checked(old('method') === 'paypal') required>
                            <label class="form-check-label fw-bold text-dark" for="paypal">E-Wallet / PayPal</label>
                        </div>
                    </div>

                    <div class="row gy-3">
                        <div class="col-md-6">
                            <label for="cc-name" class="form-label text-slate-300 small fw-bold">Nama Pemegang Kartu</label>
                            <input type="text" class="form-control" id="cc-name" name="cc-name" placeholder="Nama sesuai kartu" value="{{ old('cc-name', Auth::user()->fullname ?? '') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="cc-number" class="form-label text-slate-300 small fw-bold">Nomor Kartu</label>
                            <input type="text" class="form-control" id="cc-number" name="cc-number" placeholder="4xxx xxxx xxxx xxxx" value="{{ old('cc-number', '4000123456789010') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="cc-expiration" class="form-label text-slate-300 small fw-bold">Kedaluwarsa (MM/YY)</label>
                            <input type="text" class="form-control" id="cc-expiration" name="cc-expiration" placeholder="12/28" value="{{ old('cc-expiration', '12/28') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="cc-cvv" class="form-label text-slate-300 small fw-bold">CVV</label>
                            <input type="text" class="form-control" id="cc-cvv" name="cc-cvv" placeholder="123" value="{{ old('cc-cvv', '123') }}" required>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Holds Cart Data -->
                    <input type="hidden" name="total_products" value="{{ implode('', $cart_items) }}">
                    <input type="hidden" name="total_price" value="{{ $grand_total }}">

                    <button class="w-100 btn btn-gradient btn-lg font-heading fw-bold py-3 {{ ($grand_total > 1) ? '' : 'disabled' }}" name="order" type="submit">
                        <i class="bi bi-shield-check me-2"></i>Konfirmasi &amp; Bayar Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
  <script src="{{ asset('assets/js/checkout.js') }}"></script>
@endsection
