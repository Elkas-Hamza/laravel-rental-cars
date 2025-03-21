@extends('layouts.app')

@section('title', 'Home - Car Rental System')

@section('content')
    <section class="hero-section hero-slide d-flex justify-content-center align-items-center" id="section_1">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12 text-center mx-auto">
                    <div class="hero-section-text">
                        <div class="container mt-5"
                            style="
                        background-color: rgba(0, 0, 0, 0.6);
                        backdrop-filter: blur(3px);
                        border-radius: 10px;
                        padding: 20px;
                        box-shadow:0,0,8,black;">

                            <h1 class="hero-title text-white mt-2 mb-4">Choose the right time to rent a car</h1>

                            <form method="post" action="{{ route('search.cars') }}" class="bg-blur">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6 text-white">
                                        <label for="departureDate" class="text-white"><b>Date de départ</b></label>
                                        <input required name="date_de_location" min="{{ date('Y-m-d') }}"
                                            value="{{ date('Y-m-d') }}" type="date" class="form-control"
                                            id="departureDate">
                                    </div>

                                    <div class="form-group col-md-6 text-white">
                                        <label for="returnDate"><b>Date de retour</b></label>
                                        <input required name="date_de_retour" min="{{ date('Y-m-d') }}" type="date"
                                            class="form-control" id="returnDate">
                                    </div>
                                </div>

                                <button type="submit" class="mt-3 btn btn-primary btn-block">RECHERCHER</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about-section section-padding" id="section_2">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 col-12">
                    <small class="section-small-title">Our Story</small>

                    <h2 class="mt-2 mb-4"><span class="text-muted">Introducing</span> Car Rental</h2>

                    <h4 class="text-muted mb-3">Discover top-notch vehicle rentals with Car Rental</h4>

                    <p>Offering a wide selection of luxury and economy models to suit any travel need. Enjoy competitive
                        rates, flexible rental terms, and exceptional customer service for a seamless car rental experience.
                        Drive in style and comfort with Car Rental.</p>
                </div>

                <div class="col-lg-3 col-md-5 col-5 mx-lg-auto">
                    <img src="{{ asset('images/sharing-design-ideas-with-family.jpg') }}"
                        class="about-image about-image-small img-fluid" alt="">
                </div>

                <div class="col-lg-4 col-md-7 col-7">
                    <img src="{{ asset('images/living-room-interior-wall-mockup-warm-tones-with-leather-sofa-which-is-kitchen-3d-rendering.jpg') }}"
                        class="about-image img-fluid" alt="">
                </div>
            </div>
        </div>
    </section>

    <section id="section_3" class="featured-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-12">
                    <div class="custom-block featured-custom-block">
                        <h2 class="mt-2 mb-4">Opening Hours</h2>
                        @if (isset($agence))
                            <h4 class="mt-2 mb-4">All days</h4>
                            <div class="d-flex">
                                <i class="featured-icon bi-clock me-3"></i>

                                <div>
                                    <p class="mb-2">
                                        In the morning.
                                        <strong class="d-inline">
                                            {{ $agence->temp_debut }}
                                        </strong>
                                    </p>
                                    <p class="mb-2">
                                        In the evening.
                                        <strong class="d-inline">
                                            {{ $agence->temp_fin }}
                                        </strong>
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-7 col-12">
                    <div class="custom-block">
                        <h2 class="mt-2 mb-4">Customer Reviews</h2>

                        @foreach ($reviews as $review)
                            <div class="review-item mb-4">
                                <div class="border-bottom pb-3">
                                    <h4>{{ $review->first_name }} {{ $review->last_name }}</h4>
                                    <p class="text-muted small">{{ $review->date_coment }}</p>
                                    <p>{{ $review->message }}</p>
                                </div>
                            </div>
                        @endforeach

                        <div class="review-form mt-5">
                            <h4 class="mb-3">Leave a Review</h4>
                            <form action="{{ route('reviews.store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <input type="text" class="form-control" name="first_name"
                                            placeholder="First Name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="text" class="form-control" name="last_name" placeholder="Last Name"
                                            required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                                </div>
                                <div class="mb-3">
                                    <textarea class="form-control" name="message" rows="4" placeholder="Your Message" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit Review</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
