@extends('layouts.app')

@section('title', 'Support & Help')

@section('content')
    <div class="container my-5">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h1 class="display-4">How Can We Help You?</h1>
                <p class="lead">Get in touch with our customer support team for assistance with bookings, inquiries, or any
                    issues you may encounter.</p>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-lg-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-phone-alt fs-1 text-primary mb-3"></i>
                        <h3>Call Us</h3>
                        <p class="mb-3">Our support team is available 24/7</p>
                        <a href="tel:{{ isset($agence) ? $agence->tele : '+1234567890' }}" class="btn btn-primary">
                            {{ isset($agence) ? $agence->tele : '+1 (234) 567-890' }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-envelope fs-1 text-primary mb-3"></i>
                        <h3>Email Us</h3>
                        <p class="mb-3">We'll respond within 24 hours</p>
                        <a href="mailto:{{ isset($agence) ? $agence->email : 'support@carrentals.com' }}"
                            class="btn btn-primary">
                            {{ isset($agence) ? $agence->email : 'support@carrentals.com' }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-comments fs-1 text-primary mb-3"></i>
                        <h3>Live Chat</h3>
                        <p class="mb-3">Chat with a support agent now</p>
                        <button class="btn btn-primary" id="open-chat-btn">Start Chat</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-5">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0"><i class="fas fa-paper-plane me-2"></i>Send Us a Message</h3>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('home') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <select class="form-select" id="subject" name="subject" required>
                                    <option value="">Select a subject</option>
                                    <option value="Booking Inquiry">Booking Inquiry</option>
                                    <option value="Reservation Support">Reservation Support</option>
                                    <option value="Technical Issue">Technical Issue</option>
                                    <option value="Billing Question">Billing Question</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-5">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0"><i class="fas fa-question-circle me-2"></i>Frequently Asked Questions</h3>
                    </div>
                    <div class="card-body p-4">
                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        How can I modify my reservation?
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        You can modify your reservation by logging into your account and navigating to the
                                        "My Reservations" section. From there, you can view and modify your active
                                        reservations as needed.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        What is the cancellation policy?
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Our standard cancellation policy allows free cancellation up to 24 hours before the
                                        scheduled pickup time. Cancellations made within 24 hours may be subject to a fee
                                        equivalent to one day's rental charge.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        What do I need to bring when picking up my rental car?
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse"
                                    aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        When picking up your rental car, you'll need to bring a valid driver's license, a
                                        credit card in the name of the main driver, and your reservation confirmation.
                                        Additional requirements may apply based on location and vehicle type.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <a href="{{ route('faq') }}" class="btn btn-outline-primary">View All FAQs</a>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Our Location</h3>
                    </div>
                    <div class="card-body p-4">
                        <p>
                            <strong>Address:</strong>
                            {{ isset($agence) ? $agence->adresse : '123 Rental Street, City, Country' }}
                        </p>
                        <p>
                            <strong>Business Hours:</strong><br>
                            Monday - Friday: 8:00 AM - 8:00 PM<br>
                            Saturday: 9:00 AM - 6:00 PM<br>
                            Sunday: 10:00 AM - 4:00 PM
                        </p>
                        <div class="ratio ratio-16x9 mt-3">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3024.2219901290355!2d-74.00369368400567!3d40.71312937933185!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a23e28c1191%3A0x49f75d3281df052a!2s150%20Park%20Row%2C%20New%20York%2C%20NY%2010007!5e0!3m2!1sen!2sus!4v1553090754797"
                                width="600" height="450" style="border:0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('open-chat-btn').addEventListener('click', function() {
            alert('Live chat functionality will be implemented soon. Please use email or phone for now.');
        });
    </script>
@endpush
