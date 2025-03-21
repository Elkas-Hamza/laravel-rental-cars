@extends('layouts.app')

@section('title', 'About Us')

@section('content')
    <div class="container my-5">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h1 class="display-4">About Our Car Rental Service</h1>
                <p class="lead">Providing premium vehicles and exceptional service since 2010.</p>
            </div>
        </div>

        <!-- Company Overview Section -->
        <div class="row mb-5 align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="mb-4">Our Story</h2>
                <p>Founded in 2010, our car rental service has grown from a small local operation with just 5 vehicles to a
                    respected name in the industry with a fleet of over 100 premium cars.</p>
                <p>Our journey began with a simple mission: to provide reliable, high-quality rental cars with exceptional
                    customer service at competitive prices. This mission continues to guide everything we do.</p>
                <p>Over the years, we've expanded our services to multiple locations while maintaining our commitment to
                    personalized service, transparency, and customer satisfaction.</p>
                <div class="d-flex mt-4">
                    <div class="me-4 text-center">
                        <h3 class="text-primary mb-0">100+</h3>
                        <p class="text-muted">Premium Vehicles</p>
                    </div>
                    <div class="me-4 text-center">
                        <h3 class="text-primary mb-0">5</h3>
                        <p class="text-muted">Locations</p>
                    </div>
                    <div class="text-center">
                        <h3 class="text-primary mb-0">50K+</h3>
                        <p class="text-muted">Happy Customers</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="https://source.unsplash.com/random/800x600/?car-showroom" alt="Our car showroom"
                    class="img-fluid rounded shadow">
            </div>
        </div>

        <!-- Mission and Values Section -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-5">Our Mission & Values</h2>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="text-center">
                                    <i class="fas fa-handshake fs-1 text-primary mb-3"></i>
                                    <h3>Reliability</h3>
                                    <p>We promise well-maintained vehicles and punctual service. Our rigorous maintenance
                                        schedule ensures that every car in our fleet meets the highest standards of
                                        performance and safety.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <i class="fas fa-gem fs-1 text-primary mb-3"></i>
                                    <h3>Quality</h3>
                                    <p>Our fleet consists of premium vehicles selected for comfort, performance, and style.
                                        We regularly update our inventory to offer the latest models with modern features
                                        and technology.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <i class="fas fa-heart fs-1 text-primary mb-3"></i>
                                    <h3>Customer-First</h3>
                                    <p>We put our customers at the center of everything we do. Our team is dedicated to
                                        providing personalized service and going above and beyond to ensure a seamless
                                        rental experience.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Our Fleet Section -->
        <div class="row mb-5">
            <div class="col-12 text-center mb-4">
                <h2>Explore Our Premium Fleet</h2>
                <p class="lead">We offer a wide range of vehicles to meet your needs, from compact cars to luxury SUVs.
                </p>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <img src="https://source.unsplash.com/random/600x400/?sedan" class="card-img-top" alt="Sedan">
                    <div class="card-body">
                        <h3 class="card-title">Sedans</h3>
                        <p class="card-text">Our sedan collection offers comfort, reliability, and excellent fuel
                            efficiency. Perfect for business trips or family vacations.</p>
                        <a href="{{ route('cars.index') }}" class="btn btn-primary">View Sedans</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <img src="https://source.unsplash.com/random/600x400/?suv" class="card-img-top" alt="SUV">
                    <div class="card-body">
                        <h3 class="card-title">SUVs</h3>
                        <p class="card-text">For those who need more space and versatility, our SUVs provide ample room for
                            passengers and luggage while maintaining comfort.</p>
                        <a href="{{ route('cars.index') }}" class="btn btn-primary">View SUVs</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <img src="https://source.unsplash.com/random/600x400/?luxury-car" class="card-img-top" alt="Luxury Car">
                    <div class="card-body">
                        <h3 class="card-title">Luxury Cars</h3>
                        <p class="card-text">Experience the ultimate in driving pleasure with our luxury collection,
                            featuring premium amenities and superior performance.</p>
                        <a href="{{ route('cars.index') }}" class="btn btn-primary">View Luxury Cars</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Testimonials Section -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card shadow-sm border-0 bg-light">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-5">What Our Customers Say</h2>
                        <div class="row">
                            <div class="col-lg-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex mb-3">
                                            <span class="text-warning me-2">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </span>
                                            <span>(5.0)</span>
                                        </div>
                                        <p class="card-text">"I've rented cars from many companies, but none compare to the
                                            service I received here. The staff was friendly, the car was spotless, and the
                                            whole process was seamless. Highly recommend!"</p>
                                        <div class="d-flex align-items-center mt-3">
                                            <i class="fas fa-user-circle fs-3 text-primary me-3"></i>
                                            <div>
                                                <h5 class="mb-0">John Smith</h5>
                                                <small class="text-muted">Business Traveler</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex mb-3">
                                            <span class="text-warning me-2">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                            </span>
                                            <span>(4.5)</span>
                                        </div>
                                        <p class="card-text">"The SUV we rented was perfect for our family vacation. Clean,
                                            spacious, and great on gas. The pick-up and drop-off were so easy. We'll
                                            definitely be using this service again for our next trip!"</p>
                                        <div class="d-flex align-items-center mt-3">
                                            <i class="fas fa-user-circle fs-3 text-primary me-3"></i>
                                            <div>
                                                <h5 class="mb-0">Sarah Johnson</h5>
                                                <small class="text-muted">Family Traveler</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex mb-3">
                                            <span class="text-warning me-2">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </span>
                                            <span>(5.0)</span>
                                        </div>
                                        <p class="card-text">"Renting a luxury car for my anniversary was the perfect
                                            choice. The car was immaculate and drove like a dream. The staff made the
                                            experience special by adding a few thoughtful touches. Exceptional service!"</p>
                                        <div class="d-flex align-items-center mt-3">
                                            <i class="fas fa-user-circle fs-3 text-primary me-3"></i>
                                            <div>
                                                <h5 class="mb-0">Michael Chen</h5>
                                                <small class="text-muted">Special Occasion</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Our Team Section -->
        <div class="row mb-5">
            <div class="col-12 text-center mb-4">
                <h2>Meet Our Leadership Team</h2>
                <p class="lead">Passionate professionals dedicated to providing you with the best rental experience.</p>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow-sm text-center h-100">
                    <img src="https://source.unsplash.com/random/300x300/?businessman" class="card-img-top"
                        alt="CEO">
                    <div class="card-body">
                        <h4 class="card-title">Robert Anderson</h4>
                        <p class="text-muted">CEO & Founder</p>
                        <p class="card-text">With over 20 years in the automotive industry, Robert founded the company with
                            a vision to transform the car rental experience.</p>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <div class="d-flex justify-content-center">
                            <a href="#" class="social-icon-link me-3"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="social-icon-link"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow-sm text-center h-100">
                    <img src="https://source.unsplash.com/random/300x300/?businesswoman" class="card-img-top"
                        alt="COO">
                    <div class="card-body">
                        <h4 class="card-title">Jennifer Martinez</h4>
                        <p class="text-muted">Chief Operations Officer</p>
                        <p class="card-text">Jennifer oversees all operational aspects, ensuring that every customer
                            receives exceptional service and a seamless rental experience.</p>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <div class="d-flex justify-content-center">
                            <a href="#" class="social-icon-link me-3"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="social-icon-link"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow-sm text-center h-100">
                    <img src="https://source.unsplash.com/random/300x300/?mechanic" class="card-img-top"
                        alt="Fleet Manager">
                    <div class="card-body">
                        <h4 class="card-title">David Kim</h4>
                        <p class="text-muted">Fleet Manager</p>
                        <p class="card-text">With a background in automotive engineering, David ensures that our fleet is
                            always in perfect condition and up to date with the latest models.</p>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <div class="d-flex justify-content-center">
                            <a href="#" class="social-icon-link me-3"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="social-icon-link"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow-sm text-center h-100">
                    <img src="https://source.unsplash.com/random/300x300/?customer-service" class="card-img-top"
                        alt="Customer Service Manager">
                    <div class="card-body">
                        <h4 class="card-title">Rachel Williams</h4>
                        <p class="text-muted">Customer Experience Director</p>
                        <p class="card-text">Rachel leads our customer service team, implementing innovative solutions to
                            enhance the customer journey at every touchpoint.</p>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <div class="d-flex justify-content-center">
                            <a href="#" class="social-icon-link me-3"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="social-icon-link"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action Section -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0 bg-primary text-white">
                    <div class="card-body p-5 text-center">
                        <h2 class="mb-3">Ready to Experience Premium Car Rental?</h2>
                        <p class="lead mb-4">Explore our fleet and book your perfect vehicle today.</p>
                        <div>
                            <a href="{{ route('cars.index') }}" class="btn btn-light btn-lg me-2">Browse Cars</a>
                            <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
