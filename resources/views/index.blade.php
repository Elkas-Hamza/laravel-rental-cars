@extends('layouts.app')

@section('title', 'Home - Car Rental System')

@section('style')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
    <!-- Hero Section with Reservation Form -->
    <div class="hero relative w-full h-screen bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1485291571150-772bcfc10da5?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');">
        <div class="absolute inset-0 bg-black opacity-70"></div>
        <div class="relative z-10 flex flex-col items-center justify-center h-full text-white text-center">
            <h1 class="text-4xl font-bold mb-4">15,000+ Vehicles Available</h1>
            <div class="search-bar flex gap-4 mt-4">
                <input name="make" id="make" placeholder="Car Make" class="p-2 rounded-lg shadow-md">
                <select name="model" id="model" class="p-2 rounded-lg shadow-md">
                    <option value=""></option>
                    <!-- Add options here -->
                </select>
                <input type="number" name="max_price" id="max_price" placeholder="Max Price" class="p-2 rounded-lg shadow-md">
                <button type="button" class="p-2 bg-green-500 text-white font-bold rounded-lg shadow-md">Search Cars</button>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <section class="statistics py-20 bg-white text-center">
        <h2 class="text-3xl font-bold text-blue-500 mb-8">Key Platform Statistics</h2>
        <div class="stats-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="stat-item bg-gray-100 p-8 rounded-lg shadow-md">
                <i class="bi bi-car-front text-green-500 text-4xl mb-4"></i>
                <h3 class="text-2xl font-bold text-blue-500 mb-2">15,500+</h3>
                <p>Cars for Sale</p>
            </div>
            <div class="stat-item bg-gray-100 p-8 rounded-lg shadow-md">
                <i class="bi bi-people text-green-500 text-4xl mb-4"></i>
                <h3 class="text-2xl font-bold text-blue-500 mb-2">1,750+</h3>
                <p>Visitors per Day</p>
            </div>
            <div class="stat-item bg-gray-100 p-8 rounded-lg shadow-md">
                <i class="bi bi-star text-green-500 text-4xl mb-4"></i>
                <h3 class="text-2xl font-bold text-blue-500 mb-2">3,500+</h3>
                <p>Dealer Reviews</p>
            </div>
            <div class="stat-item bg-gray-100 p-8 rounded-lg shadow-md">
                <i class="bi bi-award text-green-500 text-4xl mb-4"></i>
                <h3 class="text-2xl font-bold text-blue-500 mb-2">250+</h3>
                <p>Verified Dealers</p>
            </div>
        </div>
    </section>

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

    <!-- Working Hours Section -->
    <section class="working-hours py-20 bg-white text-center">
        <h2 class="text-3xl font-bold text-blue-500 mb-8">Working Hours</h2>
        <div class="hours-grid grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="hour-item bg-gray-100 p-8 rounded-lg shadow-md">
                <h3 class="text-xl font-bold text-blue-500 mb-2">Monday - Friday</h3>
                <p>9:00 AM - 6:00 PM</p>
            </div>
            <div class="hour-item bg-gray-100 p-8 rounded-lg shadow-md">
                <h3 class="text-xl font-bold text-blue-500 mb-2">Saturday</h3>
                <p>10:00 AM - 4:00 PM</p>
            </div>
            <div class="hour-item bg-gray-100 p-8 rounded-lg shadow-md">
                <h3 class="text-xl font-bold text-blue-500 mb-2">Sunday</h3>
                <p>Closed</p>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact py-20 bg-white text-center">
        <div class="flex flex-wrap justify-center gap-8">
            <div class="map-container w-full md:w-1/2 h-96 rounded-lg shadow-md">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.019112497918!2d144.9630583153169!3d-37.81410797975195!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf577d1b6b1b1b1b1!2sFederation%20Square!5e0!3m2!1sen!2sau!4v1611811234567!5m2!1sen!2sau" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>
            <form class="contact-form w-full md:w-1/2 bg-gray-100 p-8 rounded-lg shadow-md" action="{{ route('reviews.store') }}" method="post">
                @csrf
                <div class="input-group mb-4">
                    <input type="text" name="name" placeholder="Name" required class="w-full p-2 rounded-lg shadow-md">
                </div>
                <div class="input-group mb-4">
                    <input type="email" name="email" placeholder="Email" required class="w-full p-2 rounded-lg shadow-md">
                </div>
                <div class="input-group mb-4">
                    <input type="tel" name="phone" placeholder="Phone Number (optional)" class="w-full p-2 rounded-lg shadow-md">
                </div>
                <div class="input-group mb-4">
                    <textarea name="message" placeholder="Message" required class="w-full p-2 rounded-lg shadow-md"></textarea>
                </div>
                <button type="submit" class="w-full p-2 bg-green-500 text-white font-bold rounded-lg shadow-md">Submit</button>
            </form>
        </div>
    </section>

    <!-- Top Destinations Section -->
    <section class="top-destinations py-20 bg-white text-center">
        <div class="container">
            <h2 class="text-3xl font-bold text-blue-500 mb-8">Top Destinations</h2>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary">Popular</button>
                    <button type="button" class="btn btn-outline-primary">USA</button>
                    <button type="button" class="btn btn-outline-primary">Europe</button>
                    <button type="button" class="btn btn-outline-primary">Asia</button>
                </div>
                <button type="button" class="btn btn-primary">Explore all destinations</button>
            </div>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                <div class="col">
                    <div class="card h-100">
                        <img src="https://via.placeholder.com/400" class="card-img-top" alt="Destination">
                        <div class="card-body">
                            <h5 class="card-title">Paris</h5>
                            <p class="card-text">France</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100">
                        <img src="https://via.placeholder.com/400" class="card-img-top" alt="Destination">
                        <div class="card-body">
                            <h5 class="card-title">New York</h5>
                            <p class="card-text">USA</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100">
                        <img src="https://via.placeholder.com/400" class="card-img-top" alt="Destination">
                        <div class="card-body">
                            <h5 class="card-title">Tokyo</h5>
                            <p class="card-text">Japan</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100">
                        <img src="https://via.placeholder.com/400" class="card-img-top" alt="Destination">
                        <div class="card-body">
                            <h5 class="card-title">London</h5>
                            <p class="card-text">UK</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Stories Section -->
    <section class="latest-stories py-20 bg-white text-center">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-3xl font-bold text-blue-500">Latest Stories</h2>
                <button type="button" class="btn btn-primary">Read more stories</button>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        <img src="https://via.placeholder.com/600x400" class="card-img-top" alt="Story">
                        <div class="card-body">
                            <h5 class="card-title">Amazing Journey</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row row-cols-1 g-4">
                        <div class="col">
                            <div class="card h-100">
                                <img src="https://via.placeholder.com/150" class="card-img-top" alt="Story">
                                <div class="card-body">
                                    <h5 class="card-title">Adventure Awaits</h5>
                                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100">
                                <img src="https://via.placeholder.com/150" class="card-img-top" alt="Story">
                                <div class="card-body">
                                    <h5 class="card-title">Exploring the World</h5>
                                    <p class="card-text">Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100">
                                <img src="https://via.placeholder.com/150" class="card-img-top" alt="Story">
                                <div class="card-body">
                                    <h5 class="card-title">Wonders of Nature</h5>
                                    <p class="card-text">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trekker’s Highlights Section -->
    <section class="trekkers-highlights py-20 bg-white text-center">
        <div class="container">
            <h2 class="text-3xl font-bold text-blue-500 mb-8">Trekker’s Highlights</h2>
            <div class="card mb-4">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="https://via.placeholder.com/150" class="img-fluid rounded-start" alt="Author">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">John Doe</h5>
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
                                    <h5>Incredible Journey</h5>
                                    <p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
                 


@endsection