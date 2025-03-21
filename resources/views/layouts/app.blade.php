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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
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

        /* Ensure navbar items are visible */
        .navbar-nav .nav-link {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        /* Icon styles */
        .fas,
        .fa,
        .far,
        .fab,
        .bi {
            vertical-align: middle;
        }

        /* Car feature icons */
        .car-feature {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .car-feature i {
            margin-right: 8px;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        /* Icon colors for admin dashboard */
        .border-left-primary {
            border-left: 4px solid #4e73df;
        }

        .border-left-success {
            border-left: 4px solid #1cc88a;
        }

        .border-left-info {
            border-left: 4px solid #36b9cc;
        }

        .border-left-warning {
            border-left: 4px solid #f6c23e;
        }

        /* Social media icons styling */
        .social-icon {
            display: flex;
            flex-wrap: wrap;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .social-icon-item {
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .social-icon-link {
            background: #f0f0f0;
            border-radius: 50%;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-icon-link:hover {
            background: #333;
            color: #fff;
        }

        .social-icon-link i {
            font-size: 1.2rem;
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
                                            <i class="fas fa-map-marker-alt me-1"></i>{{ $agence->adresse }}
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
                    <i class="fas fa-car-alt me-2"></i>Car Rental
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ route('home') }}">
                                <i class="fas fa-home me-1"></i>Home
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('cars*') ? 'active' : '' }}"
                                href="{{ route('cars.index') }}">
                                <i class="fas fa-car me-1"></i>Browse Cars
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('cars/available') ? 'active' : '' }}"
                                href="{{ route('cars.available') }}">
                                <i class="fas fa-check-circle me-1"></i>Available Cars
                            </a>
                        </li>

                        @auth
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('reservations*') ? 'active' : '' }}"
                                    href="{{ route('reservations.index') }}">
                                    <i class="fas fa-calendar-check me-1"></i>My Reservations
                                </a>
                            </li>
                        @endauth
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('login') ? 'active' : '' }}"
                                    href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt me-1"></i>Login
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('register') ? 'active' : '' }}"
                                    href="{{ route('register') }}">
                                    <i class="fas fa-user-plus me-1"></i>Sign up
                                </a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile') }}">
                                            <i class="fas fa-user-cog me-2"></i>Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('reservations.index') }}">
                                            <i class="fas fa-calendar-check me-2"></i>My Reservations
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('client.reservations.history') }}">
                                            <i class="fas fa-history me-2"></i>Rental History
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
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
                    <h5 class="site-footer-title mb-3">Quick Links</h5>

                    <ul class="footer-menu">
                        <li class="footer-menu-item"><a href="{{ route('home') }}" class="footer-menu-link">Home</a>
                        </li>
                        <li class="footer-menu-item"><a href="{{ route('cars.index') }}"
                                class="footer-menu-link">Browse Cars</a></li>
                        <li class="footer-menu-item"><a href="{{ route('cars.available') }}"
                                class="footer-menu-link">Available Cars</a></li>
                        @auth
                            <li class="footer-menu-item"><a href="{{ route('reservations.index') }}"
                                    class="footer-menu-link">My Reservations</a></li>
                            <li class="footer-menu-item"><a href="{{ route('profile') }}" class="footer-menu-link">My
                                    Profile</a></li>
                        @else
                            <li class="footer-menu-item"><a href="{{ route('login') }}"
                                    class="footer-menu-link">Login</a></li>
                            <li class="footer-menu-item"><a href="{{ route('register') }}" class="footer-menu-link">Sign
                                    Up</a></li>
                        @endauth
                    </ul>
                </div>

                @if (isset($agence))
                    <div class="col-lg-4 col-md-6 col-12 mb-4">
                        <h5 class="site-footer-title mb-3">Contact</h5>

                        <p class="text-white d-flex mb-2">
                            <i class="fas fa-phone me-2"></i>
                            <a href="tel:{{ $agence->tele }}" class="site-footer-link">{{ $agence->tele }}</a>
                        </p>

                        <p class="text-white d-flex">
                            <i class="fas fa-envelope me-2"></i>
                            <a href="mailto:{{ $agence->email }}" class="site-footer-link">{{ $agence->email }}</a>
                        </p>

                        <p class="text-white d-flex mt-3">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            {{ $agence->adresse }}
                        </p>
                    </div>
                @else
                    <div class="col-lg-4 col-md-6 col-12 mb-4">
                        <h5 class="site-footer-title mb-3">Contact</h5>

                        <p class="text-white d-flex mb-2">
                            <i class="fas fa-phone me-2"></i>
                            <a href="tel:+1234567890" class="site-footer-link">+1 (234) 567-890</a>
                        </p>

                        <p class="text-white d-flex">
                            <i class="fas fa-envelope me-2"></i>
                            <a href="mailto:info@carrentals.com" class="site-footer-link">info@carrentals.com</a>
                        </p>

                        <p class="text-white d-flex mt-3">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            123 Rental Street, City, Country
                        </p>
                    </div>
                @endif

                <div class="col-lg-4 col-md-6 col-12 mx-auto">
                    <h5 class="site-footer-title mb-3">Follow Us</h5>

                    <ul class="social-icon">
                        <li class="social-icon-item"><a href="#" class="social-icon-link"><i
                                    class="fab fa-facebook-f"></i></a></li>
                        <li class="social-icon-item"><a href="#" class="social-icon-link"><i
                                    class="fab fa-twitter"></i></a></li>
                        <li class="social-icon-item"><a href="#" class="social-icon-link"><i
                                    class="fab fa-instagram"></i></a></li>
                        <li class="social-icon-item"><a href="#" class="social-icon-link"><i
                                    class="fab fa-linkedin-in"></i></a></li>
                        <li class="social-icon-item"><a href="#" class="social-icon-link"><i
                                    class="fab fa-youtube"></i></a></li>
                    </ul>

                    <h5 class="site-footer-title mb-3 mt-4">Need Help?</h5>
                    <p class="text-white d-flex">
                        <a href="#" class="btn btn-outline-light mt-2"><i
                                class="fas fa-question-circle me-2"></i>FAQ & Support</a>
                    </p>
                </div>
            </div>
        </div>

        <div class="site-footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-7 col-12">
                        <p class="copyright-text mb-0">© {{ date('Y') }} <strong>Car Rental System</strong> - All
                            Rights Reserved</p>
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
