<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>@yield('title', 'TGN Premium Parfume')</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon1.png') }}" rel="icon">
  <link href="{{ asset('assets/img/favicon1.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Amatic+SC:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
  <link href="{{ asset('css/tgn-theme.css') }}" rel="stylesheet">
  @yield('styles')
</head>

<body class="tgn-store">

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto me-lg-0">
        <img src="{{ asset('assets/img/Logo-TGN.png') }}" alt="TGN Logo">
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="{{ url('/#hero') }}">Home</a></li>
          <li><a href="{{ url('/#about') }}">About</a></li>
          <li><a href="{{ url('/#menu') }}">Catalogue</a></li>
          <li><a href="{{ url('/#new') }}">Blog</a></li>
          <li><a href="{{ url('/#staff') }}">Staff</a></li>
          <li><a href="{{ url('/#gallery') }}">Gallery</a></li>
          <li><a href="{{ url('/#contact') }}">Contact</a></li>
          <li class="dropdown"><a href="#" id="tgn-cart-fly-target"><span>Profile</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
              <li><a href="{{ url('/cart.php') }}" id="tgn-cart-link">My Cart</a></li>
              <li><a href="{{ url('/purchase-history.php') }}">My Purchase</a></li>
              <li><a href="{{ url('/users-profile.php') }}">Setting</a></li>
              <li><a href="{{ url('/components/user-sign-out.php') }}">Sign Out</a></li>
            </ul>
          </li>
        </ul>
      </nav><!-- End navbar -->

      @auth
        @if(in_array(Auth::user()->level, ['Super Admin', 'Admin', 'Customer Service', 'Marketing', 'Executive', 'customer service', 'marketing', 'super admin']))
          <span class="bilek">Hello, <a href="{{ url('/Admin/index.php') }}">{{ Auth::user()->username }}</a></span>
        @else
          <span class="bilek">Hello, {{ Auth::user()->username }}</span>
        @endif
      @else
        <a class="btn-book-a-table" href="{{ url('/sign-in.php') }}">Sign In</a>
      @endauth

      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

    </div>
  </header><!-- End Header -->

  <!-- Main Content -->
  @php
    $isSubPage = !request()->is('/') && !request()->is('index.php');
  @endphp
  <div class="{{ $isSubPage ? 'tgn-page' : 'tgn-home' }}">
    @yield('content')
  </div>

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">

    <div class="container">
      <div class="row gy-3">
        <div class="col-lg-3 col-md-6 d-flex">
          <i class="bi bi-geo-alt icon"></i>
          <div>
            <h4>Address</h4>
            <p href="https://fachri-aer.vercel.app/">
            Jalan Warung Jati Barat No.98. RT.1/RW.7. Pejaten Barat<br>
            Jakarta 12510, Indonesia<br>
            </p>
          </div>

        </div>

        <div class="col-lg-3 col-md-6 footer-links d-flex">
          <i class="bi bi-telephone icon"></i>
          <div>
            <h4>Contacts</h4>
            <p>
              <strong>Phone:</strong> +62 822 9991 1239<br>
              <strong>Email:</strong> telugustinoir@gmail.com<br>
            </p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 footer-links d-flex">
          <i class="bi bi-clock icon"></i>
          <div>
            <h4>Working Hours</h4>
            <p>
              <strong>Mon-Friday: 9AM</strong> - 5PM<br>
              Saturday-Sunday: Closed
            </p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 footer-links">
          <h4>Follow Us</h4>
          <div class="social-links d-flex">
            <a href="https://github.com/1iki" class="twitter"><i class="bi bi-twitter"></i></a>
            <a href="https://github.com/1iki" class="facebook"><i class="bi bi-facebook"></i></a>
            <a href="https://www.instagram.com/fachri.aer" class="instagram"><i class="bi bi-instagram"></i></a>
            <a href="https://www.linkedin.com/in/fachriadityar/" class="linkedin"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>TGN</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        Designed by <a href="https://www.linkedin.com/in/putra-ardiansyah/">Putra</a> <a href="https://www.linkedin.com/in/fachriadityar/">Fachri</a> <a href="https://www.linkedin.com/in/krisna-wirawan-8ab7942b9/">Krisna</a>
      </div>
    </div>

  </footer><!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>
  <script src="{{ asset('js/tgn-ui.js') }}"></script>
  @yield('scripts')

  @include('partials.toasts')
  @include('partials.confirm-modal')

</body>

</html>

