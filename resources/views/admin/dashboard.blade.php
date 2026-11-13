@extends('layouts.admin')

@section('title', 'Admin Dashboard — TGN Parfume')
@section('page-title', 'Dashboard Panel Admin')

@section('content')
<div class="row g-4 mb-4">
    <!-- Stat 1: Total Pendings -->
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-secondary small fw-bold text-uppercase">Pendapatan Pending</span>
                <span class="fs-4 text-warning"><i class="bi bi-clock-history"></i></span>
            </div>
            <h3 class="fw-bold text-dark mb-0">Rp {{ number_format($totalPendings, 0, ',', '.') }}</h3>
            <span class="text-xs text-secondary">Total nilai pesanan pending</span>
        </div>
    </div>

    <!-- Stat 2: Total Completes -->
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-secondary small fw-bold text-uppercase">Pendapatan Selesai</span>
                <span class="fs-4 text-success"><i class="bi bi-cash-coin"></i></span>
            </div>
            <h3 class="fw-bold text-dark mb-0">Rp {{ number_format($totalCompletes, 0, ',', '.') }}</h3>
            <span class="text-xs text-secondary">Total transaksi sukses</span>
        </div>
    </div>

    <!-- Stat 3: Total Orders -->
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-secondary small fw-bold text-uppercase">Total Pesanan</span>
                <span class="fs-4 text-primary"><i class="bi bi-cart3"></i></span>
            </div>
            <h3 class="fw-bold text-dark mb-0">{{ $totalOrders }}</h3>
            <span class="text-xs text-secondary">Semua pesanan masuk</span>
        </div>
    </div>

    <!-- Stat 4: Total Products -->
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-secondary small fw-bold text-uppercase">Varian Parfum</span>
                <span class="fs-4 text-accent"><i class="bi bi-droplet-half"></i></span>
            </div>
            <h3 class="fw-bold text-dark mb-0">{{ $totalProducts }}</h3>
            <span class="text-xs text-secondary">Produk aktif dalam MongoDB</span>
        </div>
    </div>

    <!-- Stat 5: Consument Users -->
    <div class="col-md-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-secondary small fw-bold text-uppercase">Akun Pelanggan</span>
                <span class="fs-4 text-accent"><i class="bi bi-people"></i></span>
            </div>
            <h3 class="fw-bold text-dark mb-0">{{ $totalUsers }}</h3>
            <span class="text-xs text-secondary">Pengguna terdaftar</span>
        </div>
    </div>

    <!-- Stat 6: Admin/Staff Users -->
    <div class="col-md-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-secondary small fw-bold text-uppercase">Admin & Karyawan</span>
                <span class="fs-4 text-warning"><i class="bi bi-shield-lock"></i></span>
            </div>
            <h3 class="fw-bold text-dark mb-0">{{ $totalAdmins }}</h3>
            <span class="text-xs text-secondary">Termasuk staf yang digabung</span>
        </div>
    </div>

    <!-- Stat 7: Messages -->
    <div class="col-md-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-secondary small fw-bold text-uppercase">Pesan Masuk</span>
                <span class="fs-4 text-danger"><i class="bi bi-envelope-open"></i></span>
            </div>
            <h3 class="fw-bold text-dark mb-0">{{ $totalMessages }}</h3>
            <span class="text-xs text-secondary">Pesan feedback pelanggan</span>
        </div>
    </div>
</div>

<!-- Quick Action Shortcuts -->
<div class="stat-card">
    <h5 class="fw-bold text-dark mb-3"><i class="bi bi-lightning-charge text-warning me-2"></i>Aksi Cepat Admin</h5>
    <div class="d-flex flex-wrap gap-3">
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary rounded-3 px-4">
            <i class="bi bi-plus-lg me-1"></i> Tambah Parfum Baru
        </a>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary rounded-3 px-4">
            <i class="bi bi-cart3 me-1"></i> Kelola Transaksi
        </a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary rounded-3 px-4">
            <i class="bi bi-people me-1"></i> Kelola Pengguna
        </a>
        <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary rounded-3 px-4">
            <i class="bi bi-envelope me-1"></i> Lihat Pesan
        </a>
    </div>
</div>
@endsection
