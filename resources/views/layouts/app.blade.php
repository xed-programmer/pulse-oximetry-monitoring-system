<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>POMS</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  {{--
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"> --}}

  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">
  <!-- Vendor CSS Files -->
  <link href="{{ asset('BizLand/assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('BizLand/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('BizLand/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('BizLand/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('BizLand/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('BizLand/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">

  @stack('links')
  <!-- Template Main CSS File -->
  <link href="{{ asset('BizLand/assets/css/style.css') }}" rel="stylesheet">

</head>

<body>

  <!-- ======= Top Bar ======= -->
  <section id="topbar" class="d-flex align-items-center">
    <div class="container d-flex justify-content-center justify-content-md-between">
      <div class="contact-info d-flex align-items-center">
        <i class="bi bi-envelope d-flex align-items-center"><a
            href="mailto:xedprogrammer@gmail.com">xedprogrammer@gmail.com</a></i>
        <i class="bi bi-phone d-flex align-items-center ms-4"><span>09510592362</span></i>
      </div>
    </div>
  </section>

  <!-- ======= Header ======= -->
  <header id="header" class="d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <!-- Uncomment below if you prefer to use an image logo -->
      <div class="d-flex flex-row align-items-center">
        <a href="index.html" class="logo"><img src="{{ asset('dist/img/logo.png') }}" alt="POMS"></a>
        <h1 class="logo"><a href="{{ route('home') }}">POMS<span>.</span></a></h1>
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link active" href="{{ route('home') }}">Home</a></li>
          <li><a class="nav-link" href="{{ route('home') }}#about">About</a></li>
          <li><a class="nav-link" href="{{ route('home') }}#contact">Contact</a></li>
          @auth
          @if(auth()->user()->hasRole('user'))
          <li>
            <a href="{{ route('user.index') }}" class="nav-link">User</a>
          </li>
          @endif
          <li class="dropdown"><a href="#"><span>{{ Str::limit(Auth::user()->name,15) }}</span></a>
            <ul>
              <li><a href="#">
                 <p>Your Profile
                  <br>
                {{ Str::limit(Auth::user()->email, 22) }}</a></li>
                 </p>
              <li>
                <form action="{{ route('logout') }}" method="post" class="w-100 h-100">
                  @csrf
                  <input type="submit" value="Logout" class="btn btn-block w-100 h-100">
                </form>
              </li>
            </ul>
          </li>

          @else
          <li>
            <a href="{{ route('login') }}" class="nav-link">Login</a>
          </li>
          <li>
            <a href="{{ route('register') }}" class="nav-link">Register</a>
          </li>
          @endauth
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  @yield('header')

  <main id="main" data-aos="fade-up">
    @yield('content')
  </main>
  @yield('modals')


  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
  {{-- <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}

  {{-- <script src="{{ asset('BizLand/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script> --}}
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('BizLand/assets/vendor/aos/aos.js')}}"></script>
  <script src="{{ asset('BizLand/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{ asset('BizLand/assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{ asset('BizLand/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
  <script src="{{ asset('BizLand/assets/vendor/waypoints/noframework.waypoints.js')}}"></script>
  <script src="{{ asset('BizLand/assets/vendor/php-email-form/validate.js')}}"></script>
  <x-toastr-scripts />
  @stack('scripts')
  <!-- Template Main JS File -->
  <script src="{{ asset('BizLand/assets/js/main.js') }}"></script>

</body>

</html>