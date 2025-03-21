@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
    <div class="container my-5">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h1 class="display-4">Contact Us</h1>
                <p class="lead">We're here to help and answer any question you might have.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mb-5">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0"><i class="fas fa-envelope me-2"></i>Send Us a Message</h3>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('home') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone">
                            </div>

                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <select class="form-select" id="subject" name="subject" required>
                                    <option value="">Select a subject</option>
                                    <option value="General Inquiry">General Inquiry</option>
                                    <option value="Reservation Question">Reservation Question</option>
                                    <option value="Vehicle Information">Vehicle Information</option>
                                    <option value="Feedback">Feedback</option>
                                    <option value="Partnership">Partnership</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter"
                                    value="1">
                                <label class="form-check-label" for="newsletter">
                                    Subscribe to our newsletter for special offers and updates
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0"><i class="fas fa-info-circle me-2"></i>Contact Information</h3>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex mb-3">
                            <i class="fas fa-map-marker-alt fs-4 text-primary me-3 mt-1"></i>
                            <div>
                                <h4 class="mb-1">Address</h4>
                                <p class="mb-0">
                                    {{ isset($agence) ? $agence->adresse : '123 Rental Street, City, Country' }}
                                </p>
                            </div>
                        </div>

                        <div class="d-flex mb-3">
                            <i class="fas fa-phone-alt fs-4 text-primary me-3 mt-1"></i>
                            <div>
                                <h4 class="mb-1">Phone</h4>
                                <p class="mb-0">
                                    <a href="tel:{{ isset($agence) ? $agence->tele : '+1234567890' }}"
                                        class="text-decoration-none">
                                        {{ isset($agence) ? $agence->tele : '+1 (234) 567-890' }}
                                    </a>
                                </p>
                            </div>
                        </div>

                        <div class="d-flex mb-3">
                            <i class="fas fa-envelope fs-4 text-primary me-3 mt-1"></i>
                            <div>
                                <h4 class="mb-1">Email</h4>
                                <p class="mb-0">
                                    <a href="mailto:{{ isset($agence) ? $agence->email : 'info@carrentals.com' }}"
                                        class="text-decoration-none">
                                        {{ isset($agence) ? $agence->email : 'info@carrentals.com' }}
                                    </a>
                                </p>
                            </div>
                        </div>

                        <div class="d-flex">
                            <i class="fas fa-clock fs-4 text-primary me-3 mt-1"></i>
                            <div>
                                <h4 class="mb-1">Business Hours</h4>
                                <p class="mb-0">
                                    Monday - Friday: 8:00 AM - 8:00 PM<br>
                                    Saturday: 9:00 AM - 6:00 PM<br>
                                    Sunday: 10:00 AM - 4:00 PM
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0"><i class="fas fa-share-alt me-2"></i>Connect With Us</h3>
                    </div>
                    <div class="card-body p-4">
                        <p>Follow us on social media for updates, promotions, and more:</p>
                        <div class="d-flex justify-content-between">
                            <a href="#" class="btn btn-outline-primary flex-grow-1 me-2"><i
                                    class="fab fa-facebook-f me-2"></i>Facebook</a>
                            <a href="#" class="btn btn-outline-primary flex-grow-1"><i
                                    class="fab fa-twitter me-2"></i>Twitter</a>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <a href="#" class="btn btn-outline-primary flex-grow-1 me-2"><i
                                    class="fab fa-instagram me-2"></i>Instagram</a>
                            <a href="#" class="btn btn-outline-primary flex-grow-1"><i
                                    class="fab fa-linkedin-in me-2"></i>LinkedIn</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0"><i class="fas fa-map-marked-alt me-2"></i>Our Location</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="ratio ratio-21x9">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3024.2219901290355!2d-74.00369368400567!3d40.71312937933185!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a23e28c1191%3A0x49f75d3281df052a!2s150%20Park%20Row%2C%20New%20York%2C%20NY%2010007!5e0!3m2!1sen!2sus!4v1553090754797"
                                width="600" height="450" style="border:0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <div class="card shadow-sm border-0 bg-light">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="text-center">
                                    <i class="fas fa-bolt fs-1 text-primary mb-3"></i>
                                    <h4>Fast Response</h4>
                                    <p>We'll respond to your inquiry within 24 hours</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="text-center">
                                    <i class="fas fa-headset fs-1 text-primary mb-3"></i>
                                    <h4>24/7 Support</h4>
                                    <p>Customer service available all day, every day</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="text-center">
                                    <i class="fas fa-users fs-1 text-primary mb-3"></i>
                                    <h4>Expert Team</h4>
                                    <p>Our knowledgeable staff is here to assist you</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="text-center">
                                    <i class="fas fa-shield-alt fs-1 text-primary mb-3"></i>
                                    <h4>Secure Communication</h4>
                                    <p>Your information is kept private and secure</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
