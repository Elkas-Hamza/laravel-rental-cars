<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Car Rental System">
    <meta name="author" content="Abdo">

    <title>@yield('title', 'Car Rental System')</title>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles and Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100;300;400;600;700&display=swap"
        rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tooplate-moso-interior.css') }}" rel="stylesheet">
    <link rel="shortcut icon" type="x-icon" href="{{ asset('icon/car-rental.png') }}">
    <style>
        .top_bar {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e7e7e7;
            color: #333;
            position: static !important;
            padding: 10px 0;
        }

        .slideshow-container {
            margin-top: 0;
            width: 100%;
            position: relative;
            height: 500px;
            overflow: hidden;
        }

        .carousel-item {
            height: 500px;
        }

        .carousel-item img {
            object-fit: cover;
            width: 100%;
            height: 100%;
        }

        .carousel-caption {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 5px;
        }

        .navbar {
            z-index: 1000;
        }
    </style>
    @yield('styles')
</head>

<body>
    <header>
        <!-- Top Bar -->
        @if (isset($agence))
            <div class="top_bar pt-3 mb-0">
                <div class="container">
                    <div class="row">
                        <div class="col-12 d-flex">
                            <div class="top_bar_contact_item me-3">
                                <div class="top_bar_icon"><img
                                        src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1560918577/phone.png"
                                        alt=""></div>
                                <a target="_blank" href="tel:{{ $agence->tele }}">{{ $agence->tele }}</a>
                            </div>
                            <div class="top_bar_contact_item me-3">
                                <div class="top_bar_icon"><img
                                        src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1560918597/mail.png"
                                        alt=""></div>
                                <a target="_blank" href="mailto:{{ $agence->email }}">{{ $agence->email }}</a>
                            </div>
                            <div class="top_bar_content ms-auto">
                                <div class="top_bar_menu">
                                    <div class="standard_dropdown top_bar_dropdown">
                                        <a target="_blank"
                                            href="https://maps.google.com/?q={{ urlencode($agence->adresse) }}">
                                            <i class="bi bi-geo-alt me-1"></i>{{ $agence->adresse }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg bg-light shadow-lg">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    Car Rental
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="{{ route('home') }}">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="#section_2">About</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cars.index') }}">Cars</a>
                        </li>

                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Sign up</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                        @else
                            @if (auth()->user()->isAdmin())
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Admin
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                                        <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ route('admin.cars.index') }}">Manage Cars</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('reservations.index') }}">My Reservations</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('profile') }}">Profile</a>
                            </li>

                            <li class="nav-item">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="nav-link btn btn-link"
                                        onclick="return confirm('Are you sure?')">Logout</button>
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Slideshow -->
    @if (Request::is('/') || Request::is('home'))
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3"
                    aria-label="Slide 4"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('images/slideshow/give_key.jpg') }}" class="d-block w-100"
                        alt="Car Key Handover">
                    <div class="carousel-caption d-none d-md-block">
                        <h2>Premium Car Rental Services</h2>
                        <p>Experience the luxury of our premium car rental services</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/slideshow/open_car.jpg') }}" class="d-block w-100" alt="Open Car">
                    <div class="carousel-caption d-none d-md-block">
                        <h2>Wide Range of Vehicles</h2>
                        <p>Choose from our extensive fleet of vehicles for any occasion</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/slideshow/key_merci.jpg') }}" class="d-block w-100"
                        alt="Mercedes Key">
                    <div class="carousel-caption d-none d-md-block">
                        <h2>Luxury Brands Available</h2>
                        <p>Drive the luxury car of your dreams</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/slideshow/mercidice.jpeg') }}" class="d-block w-100" alt="Mercedes">
                    <div class="carousel-caption d-none d-md-block">
                        <h2>Premium Mercedes Collection</h2>
                        <p>Explore our exclusive Mercedes collection</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    @endif

    <main>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-12 mb-4">
                    <h5 class="site-footer-title mb-3">Links</h5>

                    <ul class="footer-menu">
                        <li class="footer-menu-item"><a href="{{ route('home') }}" class="footer-menu-link">Home</a>
                        </li>
                        <li class="footer-menu-item"><a href="{{ route('cars.index') }}"
                                class="footer-menu-link">Cars</a></li>
                        @auth
                            <li class="footer-menu-item"><a href="{{ route('reservations.index') }}"
                                    class="footer-menu-link">My Reservations</a></li>
                        @else
                            <li class="footer-menu-item"><a href="{{ route('login') }}"
                                    class="footer-menu-link">Login</a></li>
                        @endauth
                    </ul>
                </div>

                @if (isset($agence))
                    <div class="col-lg-4 col-md-6 col-12 mb-4">
                        <h5 class="site-footer-title mb-3">Contact</h5>

                        <p class="text-white d-flex mb-2">
                            <i class="bi-telephone me-2"></i>
                            <a href="tel:{{ $agence->tele }}" class="site-footer-link">{{ $agence->tele }}</a>
                        </p>

                        <p class="text-white d-flex">
                            <i class="bi-envelope me-2"></i>
                            <a href="mailto:{{ $agence->email }}" class="site-footer-link">{{ $agence->email }}</a>
                        </p>

                        <p class="text-white d-flex mt-3">
                            <i class="bi-geo-alt me-2"></i>
                            {{ $agence->adresse }}
                        </p>
                    </div>
                @endif

                <div class="col-lg-4 col-md-6 col-12 mx-auto">
                    <h5 class="site-footer-title mb-3">Follow Us</h5>

                    <ul class="social-icon">
                        <li class="social-icon-item"><a href="#" class="social-icon-link bi-facebook"></a></li>
                        <li class="social-icon-item"><a href="#" class="social-icon-link bi-twitter"></a></li>
                        <li class="social-icon-item"><a href="#" class="social-icon-link bi-instagram"></a>
                        </li>
                        <li class="social-icon-item"><a href="#" class="social-icon-link bi-linkedin"></a></li>
                        <li class="social-icon-item"><a href="#" class="social-icon-link bi-youtube"></a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="site-footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-7 col-12">
                        <p class="copyright-text mb-0">© {{ date('Y') }} <strong>Car Rental System</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    @yield('scripts')
</body>

</html>
