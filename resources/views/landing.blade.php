<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>GIS Kecelakaan</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="shortcut icon" href="{{ asset('assets/') }}/subang.ico" />
    <link rel="stylesheet" href="{{ asset('landing/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/js/lib/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/js/lib/slick/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('landing/css/responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('landing/css/color.css') }}">
</head>

<body>
    <!--[if lte IE 9]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->
    <div class="wrapper">

        <header>

            <div class="header">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <nav class="navbar navbar-expand-lg navbar-light">
                                <a class="navbar-brand d-flex align-items-center" href="{{ route('landing') }}">
                                    <img src="{{ asset('assets/images/logo-min.png') }}" alt="">
                                    <span class="logo-text d-none d-md-block">GIS Titik Rawan Kecelakaan</span>
                                </a>
                                <button class="menu-button" type="button" data-toggle="collapse"
                                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent">
                                    <span class="icon-spar"></span>
                                    <span class="icon-spar"></span>
                                    <span class="icon-spar"></span>
                                </button>

                                <div class="navbar-collapse" id="navbarSupportedContent">
                                    <ul class="navbar-nav mr-auto">
                                        <li class="nav-item active">
                                            <a class="nav-link" href="#">
                                                Home
                                            </a>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                                                Map
                                            </a>
                                            <div class="dropdown-menu animated">
                                                <a class="dropdown-item" href="{{ route('map') }}">Titik Rawan
                                                    Kecelakaan</a>
                                                <a class="dropdown-item" href="{{ route('navigasi') }}">Navigasi</a>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="d-inline my-2 my-lg-0">
                                        <ul class="navbar-nav">
                                            <li class="nav-item signin-btn">
                                                @guest
                                                    <a href="{{ route('login') }}" class="nav-link">
                                                        <i class="la la-sign-in"></i>
                                                        <span><b class="signin-op">Login</b></span>
                                                    </a>
                                                @else
                                                    <a href="{{ route('home') }}" class="nav-link">
                                                        <i class="la la-sign-in"></i>
                                                        <span><b class="signin-op">Dashboard</b></span>
                                                    </a>
                                                @endguest
                                            </li>
                                        </ul>
                                    </div>
                                    <a href="#" title="" class="close-menu"><i class="la la-close"></i></a>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

        </header>
        <!--header end-->

        <section class="main-banner-sec hp6" style="background-image: url({{ asset('landing/images/banner.png') }});">
            <div class="overlay-bg"></div>
            <div class="container">
                <div class="bannner_text">
                    <h3>Keselamatan Prioritas Utama</h3>
                    <p>Sistem yang membantu untuk
                        mengidentifikasi dan menganalisis lokasi-lokasi yang rentan terhadap kecelakaan serta
                        merekomendasikan rute alternatif untuk perjalanan yang aman. </p>
                    <a href="{{ route('map') }}" title="" class="btn-default st1">Yuk, ketahui
                        titik-titiknya</a>
                </div>
                <!--banner_img end-->
            </div>
        </section>
        <!--main-banner-sec end-->

        <a href="#" title="">
            <section class="cta section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="cta-text">
                                <h2>Rute Cerdas: Menghindari Titik Kecelakaan dengan Sistem GIS</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </a>

        <section class="bottom section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-sm-6 col-md-4 mb-3">
                        <div class="bottom-logo">
                            <img src="{{ asset('assets/images/logo.png') }}" alt="" class="img-fluid">
                        </div>
                        <address>
                            <p>{{ $settings['0']->option_value }}</p>
                            <p><a href="mailto:{{ $settings['1']->option_value }}"
                                    title="email">{{ $settings['1']->option_value }}</a></p>
                            <p><a href="{{ $settings['2']->option_value }}" title="web"
                                    target="_blank">{{ $settings['2']->option_value }}</a></p>
                        </address>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-md-3">
                        <div class="bottom-list">
                            <h3>Quick Links</h3>
                            <ul>
                                <li>
                                    <a href="18_Half_Map.html" title="">Map Titik Rawan Kecelakaan</a>
                                </li>
                                <li>
                                    <a href="#" title="">Map Navigasi</a>
                                </li>
                            </ul>
                        </div>
                        <!--bottom-list end-->
                    </div>
                    <div class="col-xl-5 col-sm-12 col-md-5 pl-0">
                        <div class="bottom-desc">
                            <h3>Tentang</h3>
                            <p>
                                {{ $settings['3']->option_value }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="footer-content">
                            <div class="row justify-content-between">
                                <div class="col-xl-6 col-md-6">
                                    <div class="copyright">
                                        <p>&copy; Selio theme made in EU. All Rights Reserved.</p>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="footer-social">
                                        <a href="#">
                                            <i class="fa fa-facebook"></i>
                                        </a>
                                        <a href="#">
                                            <i class="fa fa-twitter"></i>
                                        </a>
                                        <a href="#">
                                            <i class="fa fa-instagram"></i>
                                        </a>
                                        <a href="#">
                                            <i class="fa fa-linkedin"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!--footer end-->


    </div>
    <!--wrapper end-->

    <script src="{{ asset('landing/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('landing/js/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('landing/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('landing/js/lib/slick/slick.js') }}"></script>
    <script src="{{ asset('landing/js/scripts.js') }}"></script>

    <!-- Maps -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
    <script src="{{ asset('landing/js/map-cluster/infobox.min.js') }}"></script>
    <script src="{{ asset('landing/js/map-cluster/markerclusterer.js') }}"></script>
    <script src="{{ asset('landing/js/map-cluster/maps.js') }}"></script>

</body>

</html>
