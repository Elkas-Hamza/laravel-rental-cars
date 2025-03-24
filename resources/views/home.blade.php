@extends('layouts.app')

@section('title', 'Home - Car Rental System')
@section('style')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

@endsection

@section('content')
   
</head>
<body>
    <!-- Hero Section with Reservation Form -->
    <div class="container-fluid hero-section">
        <div class="row">
            <!-- Left Side: Text & Booking Form -->
            <div class="col-md-6 d-flex align-items-center">
                <div class="text-center text-md-start p-5">
                    <h1 class="display-4 fw-bold" style="color: #042825;">Fast And Easy Way To Rent A Car</h1>
                    <p class="lead text-muted" style="max-width: 500px;">Sed volutpat sed nunc vel porttitor. Integer euismod, nisi vel consectetur interdum, nisl nisi aliquet nunc, eget facilisis ligula nisi eget ligula.</p>
                    <form method="post" action="{{ route('search.cars') }}" class="mt-4">
                     
                     @csrf
                        
                        <div class="mb-3">
                            <input type="date" class="p-2 col-12 rounded-lg shadow-md" required name="date_de_location" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}"    >
                        </div>
                        <div class="mb-3">
                            <input required name="date_de_retour" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" type="date"  class="p-2 col-12 rounded-lg shadow-md">
                        </div>
                        <button type="submit" class="btn btn-primary" style="background-color: #FF6B00; border-color: #FF6B00;">Search Cars</button>
                    </form>
                </div>
            </div>
            <!-- Right Side: Car Image Slider -->
            <div class="col-md-6 p-0">
                <div id="carCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset("images/slideshow/key_merci.jpg") }}" class="d-block w-100" alt="Car 1">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset("images/slideshow/interior-wall-mockup-with-sofa-cabinet-living-room-with-empty-white-wall-background-3d-rendering.jpg") }}" class="d-block w-100" alt="Car 2">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset("images/slideshow/wood-sideboard-living-room-interior-with-copy-space.jpg") }}" class="d-block w-100" alt="Car 3">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Main Section -->
        <section class="main-section py-20 bg-gray-50 text-center">
            <h2 class="text-3xl font-bold text-blue-500 mb-8">Best Services and Luxuries Cars</h2>
            <p class="text-gray-700 mb-12">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            <div class="flex flex-col md:flex-row items-center justify-center gap-8">
                <img src="https://via.placeholder.com/400" alt="Vehicle" class="w-full md:w-1/2 rounded-lg shadow-md">
                <div class="services-list flex flex-col gap-8">
                    <div class="service-item flex items-center gap-4">
                        <div class="icon bg-gray-200 p-4 rounded-lg">
                            <i class="bi bi-car-front text-blue-500 text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Service 1</h3>
                            <p class="text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>
                    <div class="service-item flex items-center gap-4">
                        <div class="icon bg-gray-200 p-4 rounded-lg">
                            <i class="bi bi-gear text-blue-500 text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Service 2</h3>
                            <p class="text-gray-600">Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                    </div>
                    <div class="service-item flex items-center gap-4">
                        <div class="icon bg-gray-200 p-4 rounded-lg">
                            <i class="bi bi-shield-check text-blue-500 text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Service 3</h3>
                            <p class="text-gray-600">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        {{-- working Hours  --}}
    @if (isset($agence))
    <section class="working-hours py-20 bg-white text-center px-10 mx-10 ">
        <h2 class="text-3xl font-bold text-blue-500 mb-8">Working Hours</h2>
        <div class="flex flex-col md:flex-row justify-center items-center gap-8 md:gap-16">
            
            <!-- Left Column: Business Hours & Contact Info -->
            <div class="flex flex-col gap-6 w-full md:w-1/2">
                <!-- Business Hours -->
                <div class="info-box bg-gray-100 p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-bold text-blue-500 mb-2">Business Hours</h3>
                    <p>Monday - Friday:  <strong>{{ $agence->temp_debut }}</strong> AM - <strong>{{ $agence->temp_fin }}</strong> PM</p>
                    <p>Week End: Closed</p>
                </div>
    
                <!-- Contact Information -->
                <div class="info-box bg-gray-100 p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-bold text-blue-500 mb-2">Contact Us</h3>
                    <p>📍 {{ $agence->adresse }}</p>
                    <p>📞 {{ $agence->tele }}</p>
                    <p>✉️ {{ $agence->email }}</p>
                </div>
            </div>
    
            <!-- Right Column: Image -->
            <div class="w-full md:w-1/2">
                <img src="your-photo-url.jpg" alt="Working Hours Image" class="w-full rounded-lg shadow-md">
            </div>
    
        </div>
    </section>
    
    @endif
    


    <!-- Reviews Section -->

    <section class="reviews">
    <div class="reviews-container">
        @foreach ($reviews as $review)
            <div class="review-card">
                <h4>{{ $review->date_coment }}</h4>
                <p>{{ $review->message }}</p>
                <p><strong>{{ $review->first_name }}</strong>, <small>{{ $review->last_name }}</small></p>
            </div>
        @endforeach
    </div>
</section>



    <!-- Partner Brands Section -->
    <section class="partner-brands py-20 bg-white text-center">
        <h2 class="text-3xl font-bold text-blue-500 mb-8">Our Partner Brands</h2>
        <div class="flex flex-wrap justify-center gap-8">
            <img src="https://via.placeholder.com/100" alt="Ford" class="w-24 h-24">
            <img src="https://via.placeholder.com/100" alt="Mercedes" class="w-24 h-24">
            <img src="https://via.placeholder.com/100" alt="Honda" class="w-24 h-24">
            <img src="https://via.placeholder.com/100" alt="Jeep" class="w-24 h-24">
            <img src="https://via.placeholder.com/100" alt="Volvo" class="w-24 h-24">
            <img src="https://via.placeholder.com/100" alt="Mitsubishi" class="w-24 h-24">
            <img src="https://via.placeholder.com/100" alt="Volkswagen" class="w-24 h-24">
            <img src="https://via.placeholder.com/100" alt="Audi" class="w-24 h-24">
            <img src="https://via.placeholder.com/100" alt="Hyundai" class="w-24 h-24">
        </div>
    </section>

    <!-- Top Rental Cars Section -->
    <section class="top-rental-cars py-20 bg-white text-center">
        <div class="container">
            <h2 class="text-3xl font-bold text-blue-500 mb-8">Top Rental Cars</h2>
            <div class="d-flex justify-content-between align-items-center mb-4">
           
                <a  class="btn btn-primary" href="{{ route('cars.index') }}">Explore all cars</a>
            </div>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                <div class="col">
                    <div class="card h-100">
                        <img src="https://via.placeholder.com/400" class="card-img-top" alt="Car">
                        <div class="card-body">
                            <h5 class="card-title">Toyota Camry</h5>
                            <p class="card-text">Sedan</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100">
                        <img src="https://via.placeholder.com/400" class="card-img-top" alt="Car">
                        <div class="card-body">
                            <h5 class="card-title">Ford Explorer</h5>
                            <p class="card-text">SUV</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100">
                        <img src="https://via.placeholder.com/400" class="card-img-top" alt="Car">
                        <div class="card-body">
                            <h5 class="card-title">BMW 5 Series</h5>
                            <p class="card-text">Luxury</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100">
                        <img src="https://via.placeholder.com/400" class="card-img-top" alt="Car">
                        <div class="card-body">
                            <h5 class="card-title">Honda CR-V</h5>
                            <p class="card-text">SUV</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Car Reviews Section -->
    <section class="latest-car-reviews py-20 bg-white text-center">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-3xl font-bold text-blue-500">Latest Car Reviews</h2>
                <button type="button" class="btn btn-primary">Read more reviews</button>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        <img src="https://via.placeholder.com/600x400" class="card-img-top" alt="Review">
                        <div class="card-body">
                            <h5 class="card-title">Excellent Service</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row row-cols-1 g-4">
                        <div class="col">
                            <div class="card h-100">
                                <img src="https://via.placeholder.com/150" class="card-img-top" alt="Review">
                                <div class="card-body">
                                    <h5 class="card-title">Great Experience</h5>
                                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100">
                                <img src="https://via.placeholder.com/150" class="card-img-top" alt="Review">
                                <div class="card-body">
                                    <h5 class="card-title">Highly Recommend</h5>
                                    <p class="card-text">Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100">
                                <img src="https://via.placeholder.com/150" class="card-img-top" alt="Review">
                                <div class="card-body">
                                    <h5 class="card-title">Best Rental Service</h5>
                                    <p class="card-text">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Customer Highlights Section -->
    <section class="customer-highlights py-20 bg-white text-center">
        <div class="container">
            <h2 class="text-3xl font-bold text-blue-500 mb-8">Customer Highlights</h2>
            <div class="card mb-4">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="https://via.placeholder.com/150" class="img-fluid rounded-start" alt="Customer">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Jane Smith</h5>
                            <p class="card-text">⭐⭐⭐⭐⭐</p>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="highlightsCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="https://via.placeholder.com/600x400" class="d-block w-100" alt="Highlight">
                            </div>
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Memorable Trip</h5>
                                    <p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="statistics py-20 bg-white text-center">
        <h2 class="text-3xl font-bold text-blue-500 mb-8">Key Platform Statistics</h2>
        <div class="stats-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="stat-item bg-gray-100 p-8 rounded-lg shadow-md">
                <i class="bi bi-car-front text-green-500 text-4xl mb-4"></i>
                <h3 class="text-2xl font-bold text-blue-500 mb-2">15,500+</h3>
                <p>Cars for Rent</p>
            </div>
            <div class="stat-item bg-gray-100 p-8 rounded-lg shadow-md">
                <i class="bi bi-people text-green-500 text-4xl mb-4"></i>
                <h3 class="text-2xl font-bold text-blue-500 mb-2">1,750+</h3>
                <p>Visitors per Day</p>
            </div>
            <div class="stat-item bg-gray-100 p-8 rounded-lg shadow-md">
                <i class="bi bi-star text-green-500 text-4xl mb-4"></i>
                <h3 class="text-2xl font-bold text-blue-500 mb-2">3,500+</h3>
                <p>Customer Reviews</p>
            </div>
            <div class="stat-item bg-gray-100 p-8 rounded-lg shadow-md">
                <i class="bi bi-award text-green-500 text-4xl mb-4"></i>
                <h3 class="text-2xl font-bold text-blue-500 mb-2">250+</h3>
                <p>Verified Partners</p>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact py-20 bg-white text-center px-10 mx-10">
        <div class="flex flex-col md:flex-row justify-center items-center gap-8">
            
            <!-- Left: Map -->
            <div class="map-container w-full md:w-1/2 h-96 rounded-lg shadow-md">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.019112497918!2d144.9630583153169!3d-37.81410797975195!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf577d1b6b1b1b1b1!2sFederation%20Square!5e0!3m2!1sen!2sau!4v1611811234567!5m2!1sen!2sau"
                    width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0">
                </iframe>
            </div>

            <!-- Right: Contact Form -->
            <form class="contact-form w-full md:w-1/2 bg-gray-100 p-8 rounded-lg shadow-md" action="{{ route('reviews.store') }}" method="post">
                @csrf
                <div class="input-group mb-4">
                    <input type="text" name="first_name" placeholder="First Name" required class="w-full p-2 rounded-lg shadow-md">
                </div>
                <div class="input-group mb-4">
                    <input type="text" name="last_name" placeholder="Last Name" required class="w-full p-2 rounded-lg shadow-md">
                </div>
                <div class="input-group mb-4">
                    <input type="email" name="email" placeholder="Email" required class="w-full p-2 rounded-lg shadow-md">
                </div>
                <div class="input-group mb-4">
                    <textarea name="message" placeholder="Message" required class="w-full p-2 rounded-lg shadow-md"></textarea>
                </div>
                <button type="submit" class="w-full p-2 bg-green-500 text-white font-bold rounded-lg shadow-md">Submit</button>
            </form>

        </div>
    </section>



@endsection
