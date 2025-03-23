@extends('layouts.app')

@section('title', 'Home - Car Rental System')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        /* Hero Section */
        .hero {
            width: 100vw;
            height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7));
            z-index: 1;
            animation: fadeBackground 10s infinite;
        }

        @keyframes fadeBackground {
            0% { background-image: url('https://images.unsplash.com/photo-1485291571150-772bcfc10da5?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80'); }
            33% { background-image: url('https://images.unsplash.com/photo-1504215680853-026ed2a45def?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80'); }
            66% { background-image: url('https://images.unsplash.com/photo-1511407397940-d57f68e81203?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80'); }
            100% { background-image: url('https://images.unsplash.com/photo-1485291571150-772bcfc10da5?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80'); }
        }

        .reservation-form {
            position: relative;
            z-index: 2;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 15px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        }

        .form-control {
            background: rgba(255,255,255,0.9);
            border: none;
            padding: 12px;
            border-radius: 8px;
            margin: 8px 0;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }

        /* Our Story Section */
        .our-story {
            padding: 5rem 2rem;
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(240, 248, 255, 1) 100%);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .story-content {
            flex: 1;
            min-width: 300px;
            color: #333;
            text-align: left;
        }

        .story-content h2 {
            font-size: 2.5rem;
            color: #2563eb;
            margin-bottom: 1rem;
        }

        .story-content h3 {
            font-size: 1.8rem;
            color: #1d4ed8;
            margin-bottom: 1rem;
        }

        .story-content p {
            font-size: 1.2rem;
            line-height: 1.6;
            color: #555;
        }

        .story-images {
            flex: 1;
            min-width: 300px;
            display: flex;
            gap: 20px;
            justify-content: center;
            align-items: flex-start;
        }

        .story-image {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            height: 300px;
            width: 45%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .story-image:nth-child(2) {
            margin-top: 15px;
        }

        .story-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .story-image:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .story-image:hover img {
            transform: scale(1.1);
        }

        /* Our Service Section */
        .our-service {
            padding: 5rem 2rem;
            text-align: center;
            background: #f8fafc;
        }

        .our-service h2 {
            font-size: 2.5rem;
            color: #2563eb;
            margin-bottom: 1rem;
        }

        .our-service p {
            font-size: 1.2rem;
            line-height: 1.6;
            color: #555;
        }

        /* Agency Info Section */
        .agency-info {
            padding: 3rem 2rem;
            background: white;
            text-align: center;
        }

        .time-info {
            display: inline-flex;
            gap: 2rem;
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        /* Reviews Section */
        .reviews {
            padding: 5rem 2rem;
            background: #f1f5f9;
            overflow: hidden;
        }

        .reviews-container {
            display: flex;
            gap: 2rem;
            animation: scroll 30s linear infinite;
        }

        .review-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            min-width: 300px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        @keyframes scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-100%); }
        }

        .reviews-container {
            display: flex;
            flex-wrap: nowrap;
            animation: scroll 30s linear infinite;
            width: 100%;
        }

        .review-card {
            flex: 0 0 auto;
        }

        .review-card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        /* Updated Cars Gallery */
        .cars-gallery {
            padding: 5rem 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .car-item {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .car-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        }

        .car-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .car-item:hover img {
            transform: scale(1.1);
        }

        /* Updated Contact Section */
        .contact {
            display: flex;
            flex-wrap: wrap;
            gap: 3rem;
            padding: 5rem 2rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            max-width: 1400px;
            margin: 0 auto;
        }

        .map-container {
            flex: 1;
            min-width: 300px;
            height: 500px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .contact-form {
            flex: 1;
            min-width: 300px;
            background: white;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
        }

        .input-group input,
        .input-group textarea {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .input-group textarea {
            padding-top: 1rem;
            min-height: 120px;
        }

        .input-group input:focus,
        .input-group textarea:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
            outline: none;
        }

        .submit-btn {
            width: 100%;
            padding: 1rem;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .reviews-container {
                animation: none;
            }

            .review-card {
                min-width: 100%;
            }

            .story-images {
                grid-template-columns: 1fr;
            }

            .time-info {
                flex-direction: column;
                gap: 1rem;
            }

            .cars-gallery {
                grid-template-columns: 1fr;
                grid-template-rows: repeat(5, 250px);
            }

            .car-item:nth-child(n) {
                grid-column: 1 / -1;
                grid-row: auto;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Hero Section with Reservation Form -->
    <div class="hero">
        <form method="post" action="{{ route('search.cars') }}" class="reservation-form">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="departureDate" class="form-label text-white">Date de départ</label>
                    <input required name="date_de_location" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" type="date" class="form-control" id="departureDate">
                </div>
                <div class="col-md-6">
                    <label for="returnDate" class="form-label text-white">Date de retour</label>
                    <input required name="date_de_retour" min="{{ date('Y-m-d') }}" type="date" class="form-control" id="returnDate">
                </div>
            </div>
            <button type="submit" class="mt-3 btn btn-primary w-100 shadow">RECHERCHER</button>
        </form>
    </div>

    <!-- Our Story Section -->
    <section class="our-story">
        <div class="story-content">
            <h2>Our Story</h2>
            <h3>Introducing Car Rental</h3>
            <p>Discover top-notch vehicle rentals with Car Rental. Enjoy competitive rates, flexible terms, and exceptional service.</p>
        </div>
        <div class="story-images">
            <div class="story-image">
                <img src="{{ asset('images/camry/2021-toyota-camry-hybrid-xle-138-1603151483.jpg') }}" alt="Car 1">
            </div>
            <div class="story-image">
                <img src="{{ asset('images/civic/2022-honda-civic-sedan-112-1623810389.jpg') }}" alt="Car 2">
            </div>
        </div>
    </section>

    <!-- Our Service Section -->
    <section class="our-service">
        <h2>Our Service</h2>
        <p>Discover top-notch vehicle rentals with Car Rental. Enjoy competitive rates, flexible terms, and exceptional service. With years of experience in the industry, we ensure a seamless and enjoyable rental experience for all our customers.</p>
    </section>

    <!-- Agency Info Section -->
    @if (isset($agence))
    <section class="agency-info">
        <div class="time-info">
            <p><i class="bi-clock me-2"></i> Morning: <strong>{{ $agence->temp_debut }}</strong></p>
            <p><i class="bi-clock me-2"></i> Evening: <strong>{{ $agence->temp_fin }}</strong></p>
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

    <!-- Updated Cars Gallery -->
    <section class="cars-gallery">
        <div class="car-item">
            <img src="{{ asset('images/camry/2021-toyota-camry-hybrid-xle-138-1603151483.jpg') }}" alt="Luxury Car 1">
        </div>
        <div class="car-item">
            <img src="{{ asset('images/camry/2021-toyota-camry-hybrid-xle-138-1603151483.jpg') }}" alt="Luxury Car 2">
        </div>
        <div class="car-item">
            <img src="{{ asset('images/camry/2021-toyota-camry-hybrid-xle-138-1603151483.jpg') }}" alt="Luxury Car 3">
        </div>
        <div class="car-item">
            <img src="{{ asset('images/camry/2021-toyota-camry-hybrid-xle-138-1603151483.jpg') }}" alt="Luxury Car 4">
        </div>
        <div class="car-item">
            <img src="{{ asset('images/camry/2021-toyota-camry-hybrid-xle-138-1603151483.jpg') }}" alt="Luxury Car 5">
        </div>
    </section>

    <!-- Updated Contact Section -->
    <section class="contact">
        <div class="map-container">
            <!-- Add your Google Maps embed code here -->
        </div>
        
        <form class="contact-form" action="{{ route('reviews.store') }}" method="post">
            @csrf
            <div class="row" style="display: flex; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="input-group" style="flex: 1;">
                    <i class="bi bi-person"></i>
                    <input type="text" name="first_name" placeholder="First Name" required>
                </div>
                <div class="input-group" style="flex: 1;">
                    <i class="bi bi-person"></i>
                    <input type="text" name="last_name" placeholder="Last Name" required>
                </div>
            </div>
            
            <div class="input-group">
                <i class="bi bi-envelope"></i>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            
            <div class="input-group">
                <i class="bi bi-chat-dots"></i>
                <textarea name="message" placeholder="Your Message" required></textarea>
            </div>
            
            <button type="submit" class="submit-btn">
                <i class="bi bi-send me-2"></i>
                Submit Review
            </button>
        </form>
    </section>

    <script>
        // Add smooth scrolling for reviews
        const reviewsContainer = document.querySelector('.reviews-container');
        const clonedReviews = reviewsContainer.innerHTML;
        reviewsContainer.innerHTML += clonedReviews;

        // Add date validation
        const departureDate = document.getElementById('departureDate');
        const returnDate = document.getElementById('returnDate');

        departureDate.addEventListener('change', function() {
            returnDate.min = this.value;
        });
    </script>
@endsection
