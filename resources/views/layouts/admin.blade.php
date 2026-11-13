<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>@yield('title', 'Admin TGN')</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('Admin/assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('Admin/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('Admin/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('Admin/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('Admin/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('Admin/assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('Admin/assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('Admin/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('Admin/assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('Admin/assets/css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('css/tgn-theme.css') }}" rel="stylesheet">
  @yield('styles')
</head>

<body class="tgn-admin" @if(session('form_mode')) data-reopen-product-form="{{ session('form_mode') }}" data-reopen-product-id="{{ session('form_id') }}" @endif>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="{{ url('/Admin/index.php') }}" class="logo d-flex align-items-center">
        <img src="{{ asset('Admin/assets/img/logo.png') }}" alt="Admin Logo">
        <span class="d-none d-lg-block">Admin TGN</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="GET" action="{{ url('Admin/penjualan-list-produk.php') }}" role="search">
        <input type="search" name="search" placeholder="Cari produk parfum..." title="Cari produk" value="{{ request('search') }}" aria-label="Cari produk">
        <button type="submit" title="Cari"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown">
          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-chat-left-text"></i>
            @php
              $msgCount = \App\Models\Message::count();
            @endphp
            <span class="badge bg-success badge-number">{{ $msgCount }}</span>
          </a><!-- End Messages Icon -->
        </li>

        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="{{ Auth::user()->avatar_url ?? asset('Admin/assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle" style="width: 36px; height: 36px; object-fit: cover;">
            <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->username ?? 'Admin' }}</span>
          </a><!-- End Profile Image Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{ Auth::user()->username ?? 'Admin' }}</h6>
              <span>{{ Auth::user()->level ?? 'Administrator' }}</span>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ url('/Admin/users-profile.php') }}">
                <i class="bi bi-person"></i>
                <span>Profile Saya</span>
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form action="{{ route('logout') }}" method="POST" id="admin-logout-form">
                @csrf
                <a class="dropdown-item d-flex align-items-center" href="#" onclick="document.getElementById('admin-logout-form').submit();">
                  <i class="bi bi-box-arrow-right"></i>
                  <span>Sign Out</span>
                </a>
              </form>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ url('/') }}">
                <i class="bi bi-box-arrow-right"></i>
                <span>Kembali ke Homepage</span>
              </a>
            </li>
          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link {{ request()->is('Admin/index.php') || request()->is('Admin') ? '' : 'collapsed' }}" href="{{ url('/Admin/index.php') }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link {{ request()->is('Admin/penjualan*') ? '' : 'collapsed' }}" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Penjualan</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse {{ request()->is('Admin/penjualan*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ url('/Admin/penjualan-history-pesanan.php') }}" class="{{ request()->is('Admin/penjualan-history-pesanan.php') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Riwayat Transaksi</span>
            </a>
          </li>
          <li>
            <a href="{{ url('/Admin/penjualan-list-produk.php') }}" class="{{ request()->is('Admin/penjualan-list-produk.php') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Produk</span>
            </a>
          </li>
        </ul>
      </li><!-- End Penjualan Nav -->

      <li class="nav-item">
        <a class="nav-link {{ request()->is('Admin/users*') ? '' : 'collapsed' }}" data-bs-target="#users-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-people"></i><span>Users</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="users-nav" class="nav-content collapse {{ request()->is('Admin/users*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ url('/Admin/users.php') }}" class="{{ request()->is('Admin/users.php') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Users</span>
            </a>
          </li>
          <li>
            <a href="{{ url('/Admin/users-tabel-konsumen.php') }}" class="{{ request()->is('Admin/users-tabel-konsumen.php') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>User Konsumen</span>
            </a>
          </li>
          <li>
            <a href="{{ url('/Admin/users-tabel-karyawan.php') }}" class="{{ request()->is('Admin/users-tabel-karyawan.php') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>User Karyawan</span>
            </a>
          </li>
          <li>
            <a href="{{ url('/Admin/users-tabel-admin.php') }}" class="{{ request()->is('Admin/users-tabel-admin.php') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>User Admin</span>
            </a>
          </li>
        </ul>
      </li><!-- End Users Nav -->

      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link {{ request()->is('Admin/users-profile.php') ? '' : 'collapsed' }}" href="{{ url('/Admin/users-profile.php') }}">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li>

    </ul>

  </aside><!-- End Sidebar-->

  <!-- Main Content -->
  <main id="main" class="main">
    @yield('content')
  </main>

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Panel Admin TGN</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      Designed by <a href="https://bootstrapmade.com/">Telu Gusti Noir</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('Admin/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('Admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('Admin/assets/vendor/chart.js/chart.umd.js') }}"></script>
  <script src="{{ asset('Admin/assets/vendor/echarts/echarts.min.js') }}"></script>
  <script src="{{ asset('Admin/assets/vendor/quill/quill.min.js') }}"></script>
  <script src="{{ asset('Admin/assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
  <script src="{{ asset('Admin/assets/vendor/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('Admin/assets/vendor/php-email-form/validate.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('Admin/assets/js/main.js') }}"></script>
  <script src="{{ asset('js/tgn-ui.js') }}"></script>
  @yield('scripts')

  @include('partials.toasts')
  @include('partials.confirm-modal')

</body>

</html>

