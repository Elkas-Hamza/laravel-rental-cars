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
        <link rel="stylesheet" href="{{ asset('css/tooplate-moso-interior.css') }}">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    @yield("style")
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
        
        /* Ensure dropdown is visible */
        .dropdown-menu {
            display: block;
            visibility: visible !important;
            opacity: 1 !important;
            z-index: 2000 !important;
        }
        
        /* Only show dropdown when parent is either hovered or has show class */
        .dropdown:not(:hover):not(.show) > .dropdown-menu {
            display: none;
        }
        
        /* Show dropdown on hover as well as click */
        .dropdown:hover > .dropdown-menu {
            display: block;
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

              

                        <!-- New Links -->
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('about') ? 'active' : '' }}" href="{{ route('about') }}">
                                <i class="fas fa-info-circle me-1"></i>About
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('faq') ? 'active' : '' }}" href="{{ route('faq') }}">
                                <i class="fas fa-question-circle me-1"></i>FAQ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                                <i class="fas fa-envelope me-1"></i>Contact Us
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('support') ? 'active' : '' }}" href="{{ route('support') }}">
                                <i class="fas fa-life-ring me-1"></i>Support
                            </a>
                        </li>
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
                            @if (auth()->user()->isAdmin())
                                <!-- Admin Dropdown -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-user-shield me-1"></i>Admin
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                                        <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i
                                                    class="fas fa-tachometer-alt me-1"></i>Dashboard</a>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ route('admin.cars.index') }}"><i
                                                    class="fas fa-car me-1"></i>Manage Cars</a>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ route('admin.reservations.index') }}"><i
                                                    class="fas fa-calendar-alt me-1"></i>Manage Reservations</a>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ route('admin.users.index') }}"><i
                                                    class="fas fa-users me-1"></i>Manage Users</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            <!-- User Dropdown -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false" style="font-weight: bold; font-size: 1.05rem;">
                                    @if(Auth::user()->photo)
                                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="{{ Auth::user()->name }}" class="rounded-circle me-2" style="width: 32px; height: 32px; object-fit: cover;">
                                    @else
                                        <i class="fas fa-user-circle me-1 fs-5"></i>
                                    @endif
                                    <span>{{ Auth::user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userDropdown" style="min-width: 200px; z-index: 2000 !important;">
                                    <li class="px-3 py-2 bg-light border-bottom">
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold">{{ Auth::user()->name }}</span>
                                            <small class="text-muted">{{ Auth::user()->email }}</small>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2" href="{{ route('profile') }}">
                                            <i class="fas fa-user-cog me-2 text-primary"></i>Profile Settings
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2" href="{{ route('client.reservations.index') }}">
                                            <i class="fas fa-calendar-check me-2 text-primary"></i>My Reservations
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2" href="{{ route('client.reservations.history') }}">
                                            <i class="fas fa-history me-2 text-primary"></i>Rental History
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item py-2 text-danger">
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
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#36363e" fill-opacity="1" d="M0,96L40,117.3C80,139,160,181,240,186.7C320,192,400,160,480,149.3C560,139,640,149,720,176C800,203,880,245,960,250.7C1040,256,1120,224,1200,229.3C1280,235,1360,277,1400,298.7L1440,320L1440,320L1400,320C1360,320,1280,320,1200,320C1120,320,1040,320,960,320C880,320,800,320,720,320C640,320,560,320,480,320C400,320,320,320,240,320C160,320,80,320,40,320L0,320Z"></path></svg>            
        </main>

        <footer class="site-footer" style="background-color: #36363e;">
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
                <a href="{{ route('faq') }}" class="btn btn-outline-light mt-2"><i
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
