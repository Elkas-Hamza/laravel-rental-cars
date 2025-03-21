@extends('layouts.app')

@section('title', 'Frequently Asked Questions')

@section('content')
    <div class="container my-5">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h1 class="display-4">Frequently Asked Questions</h1>
                <p class="lead">Find answers to commonly asked questions about our car rental services.</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-3 mb-4">
                <div class="list-group sticky-top" style="top: 100px;">
                    <a href="#reservations" class="list-group-item list-group-item-action" data-bs-toggle="list"><i
                            class="fas fa-calendar-check me-2"></i>Reservations</a>
                    <a href="#payments" class="list-group-item list-group-item-action" data-bs-toggle="list"><i
                            class="fas fa-credit-card me-2"></i>Payments & Pricing</a>
                    <a href="#pickup" class="list-group-item list-group-item-action" data-bs-toggle="list"><i
                            class="fas fa-car me-2"></i>Car Pickup & Return</a>
                    <a href="#requirements" class="list-group-item list-group-item-action" data-bs-toggle="list"><i
                            class="fas fa-file-contract me-2"></i>Requirements</a>
                    <a href="#insurance" class="list-group-item list-group-item-action" data-bs-toggle="list"><i
                            class="fas fa-shield-alt me-2"></i>Insurance & Coverage</a>
                    <a href="#account" class="list-group-item list-group-item-action" data-bs-toggle="list"><i
                            class="fas fa-user me-2"></i>Account Management</a>
                </div>

                <div class="card mt-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-question-circle me-2 text-primary"></i>Still have questions?
                        </h5>
                        <p class="card-text">Our support team is ready to help you with any other questions.</p>
                        <a href="{{ route('support') }}" class="btn btn-primary">Contact Support</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="tab-content">
                    <!-- Reservations FAQs -->
                    <div class="tab-pane fade show active" id="reservations">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-primary text-white">
                                <h3 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Reservations</h3>
                            </div>
                            <div class="card-body">
                                <div class="accordion" id="accordionReservations">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingR1">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseR1" aria-expanded="true"
                                                aria-controls="collapseR1">
                                                How do I make a reservation?
                                            </button>
                                        </h2>
                                        <div id="collapseR1" class="accordion-collapse collapse show"
                                            aria-labelledby="headingR1" data-bs-parent="#accordionReservations">
                                            <div class="accordion-body">
                                                Making a reservation is easy! You can make a reservation online through our
                                                website by browsing available cars, selecting your desired dates, and
                                                completing the booking process. You'll need to create an account or log in
                                                to finalize your reservation.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingR2">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseR2" aria-expanded="false"
                                                aria-controls="collapseR2">
                                                Can I modify or cancel my reservation?
                                            </button>
                                        </h2>
                                        <div id="collapseR2" class="accordion-collapse collapse" aria-labelledby="headingR2"
                                            data-bs-parent="#accordionReservations">
                                            <div class="accordion-body">
                                                Yes, you can modify or cancel your reservation by logging into your account
                                                and navigating to "My Reservations." Our standard cancellation policy allows
                                                free cancellation up to 24 hours before the scheduled pickup time.
                                                Cancellations made within 24 hours may be subject to a fee.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingR3">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseR3" aria-expanded="false"
                                                aria-controls="collapseR3">
                                                Is there a minimum rental period?
                                            </button>
                                        </h2>
                                        <div id="collapseR3" class="accordion-collapse collapse" aria-labelledby="headingR3"
                                            data-bs-parent="#accordionReservations">
                                            <div class="accordion-body">
                                                Yes, our minimum rental period is typically 24 hours. However, for certain
                                                premium vehicles or during peak seasons, the minimum rental period may be
                                                longer. The exact requirements are displayed during the reservation process.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingR4">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseR4"
                                                aria-expanded="false" aria-controls="collapseR4">
                                                How far in advance should I make a reservation?
                                            </button>
                                        </h2>
                                        <div id="collapseR4" class="accordion-collapse collapse"
                                            aria-labelledby="headingR4" data-bs-parent="#accordionReservations">
                                            <div class="accordion-body">
                                                We recommend making your reservation as soon as you know your travel dates,
                                                especially during peak seasons or holidays. This ensures you get the vehicle
                                                type you want at the best possible rate. Last-minute reservations are still
                                                possible, but vehicle availability may be limited.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payments & Pricing FAQs -->
                    <div class="tab-pane fade" id="payments">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-primary text-white">
                                <h3 class="mb-0"><i class="fas fa-credit-card me-2"></i>Payments & Pricing</h3>
                            </div>
                            <div class="card-body">
                                <div class="accordion" id="accordionPayments">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingP1">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseP1" aria-expanded="true"
                                                aria-controls="collapseP1">
                                                What payment methods do you accept?
                                            </button>
                                        </h2>
                                        <div id="collapseP1" class="accordion-collapse collapse show"
                                            aria-labelledby="headingP1" data-bs-parent="#accordionPayments">
                                            <div class="accordion-body">
                                                We accept all major credit cards including Visa, MasterCard, American
                                                Express, and Discover. The card must be in the name of the main driver. We
                                                do not accept debit cards, prepaid cards, or cash for reservations.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingP2">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseP2"
                                                aria-expanded="false" aria-controls="collapseP2">
                                                When will I be charged for my rental?
                                            </button>
                                        </h2>
                                        <div id="collapseP2" class="accordion-collapse collapse"
                                            aria-labelledby="headingP2" data-bs-parent="#accordionPayments">
                                            <div class="accordion-body">
                                                A security deposit hold is placed on your credit card when you pick up the
                                                vehicle. The full rental amount is charged at the end of your rental period,
                                                including any additional charges such as late returns, fuel, or damages.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingP3">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseP3"
                                                aria-expanded="false" aria-controls="collapseP3">
                                                Are there any additional fees I should be aware of?
                                            </button>
                                        </h2>
                                        <div id="collapseP3" class="accordion-collapse collapse"
                                            aria-labelledby="headingP3" data-bs-parent="#accordionPayments">
                                            <div class="accordion-body">
                                                Additional fees may include late return fees, cleaning fees (if the car is
                                                returned excessively dirty), fuel charges (if you don't refill the tank),
                                                and any applicable taxes. All potential fees are clearly outlined in the
                                                rental agreement before you confirm your reservation.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingP4">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseP4"
                                                aria-expanded="false" aria-controls="collapseP4">
                                                Is there a security deposit required?
                                            </button>
                                        </h2>
                                        <div id="collapseP4" class="accordion-collapse collapse"
                                            aria-labelledby="headingP4" data-bs-parent="#accordionPayments">
                                            <div class="accordion-body">
                                                Yes, a security deposit is required for all rentals. The amount varies based
                                                on the vehicle type and rental duration, typically ranging from $200 to
                                                $500. This hold is released after the vehicle is returned without damage and
                                                with a full tank of fuel.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pickup & Return FAQs -->
                    <div class="tab-pane fade" id="pickup">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-primary text-white">
                                <h3 class="mb-0"><i class="fas fa-car me-2"></i>Car Pickup & Return</h3>
                            </div>
                            <div class="card-body">
                                <div class="accordion" id="accordionPickup">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingC1">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseC1" aria-expanded="true"
                                                aria-controls="collapseC1">
                                                What do I need to bring when picking up my rental car?
                                            </button>
                                        </h2>
                                        <div id="collapseC1" class="accordion-collapse collapse show"
                                            aria-labelledby="headingC1" data-bs-parent="#accordionPickup">
                                            <div class="accordion-body">
                                                When picking up your rental car, you'll need to bring a valid driver's
                                                license, a credit card in the name of the main driver, and your reservation
                                                confirmation. International renters may need to provide additional
                                                documentation, such as a passport or international driving permit.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingC2">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseC2"
                                                aria-expanded="false" aria-controls="collapseC2">
                                                What if I'm running late for my pickup?
                                            </button>
                                        </h2>
                                        <div id="collapseC2" class="accordion-collapse collapse"
                                            aria-labelledby="headingC2" data-bs-parent="#accordionPickup">
                                            <div class="accordion-body">
                                                If you're running late for your pickup, please contact our customer service
                                                as soon as possible. We typically hold reservations for up to 2 hours past
                                                the scheduled pickup time, but this can vary depending on location and
                                                availability. After 2 hours, your reservation may be cancelled and subject
                                                to a cancellation fee.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingC3">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseC3"
                                                aria-expanded="false" aria-controls="collapseC3">
                                                What should I do if I return the car outside business hours?
                                            </button>
                                        </h2>
                                        <div id="collapseC3" class="accordion-collapse collapse"
                                            aria-labelledby="headingC3" data-bs-parent="#accordionPickup">
                                            <div class="accordion-body">
                                                If you need to return the car outside of our business hours, please contact
                                                us in advance to make arrangements. Many of our locations offer a secure key
                                                drop for after-hours returns. Please note that you remain responsible for
                                                the vehicle until our staff processes the return during business hours.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Other FAQs sections follow the same pattern -->
                    <div class="tab-pane fade" id="requirements">
                        <!-- Requirements FAQs content -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-primary text-white">
                                <h3 class="mb-0"><i class="fas fa-file-contract me-2"></i>Requirements</h3>
                            </div>
                            <div class="card-body">
                                <div class="accordion" id="accordionRequirements">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingReq1">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseReq1" aria-expanded="true"
                                                aria-controls="collapseReq1">
                                                What is the minimum age to rent a car?
                                            </button>
                                        </h2>
                                        <div id="collapseReq1" class="accordion-collapse collapse show"
                                            aria-labelledby="headingReq1" data-bs-parent="#accordionRequirements">
                                            <div class="accordion-body">
                                                The minimum age to rent a car is 21 years old. However, drivers under 25
                                                years old may be subject to a young driver surcharge and may have
                                                restrictions on certain vehicle categories. Specific age requirements can
                                                vary by location and vehicle type.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingReq2">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseReq2"
                                                aria-expanded="false" aria-controls="collapseReq2">
                                                Do I need a special license to rent certain vehicles?
                                            </button>
                                        </h2>
                                        <div id="collapseReq2" class="accordion-collapse collapse"
                                            aria-labelledby="headingReq2" data-bs-parent="#accordionRequirements">
                                            <div class="accordion-body">
                                                For most standard vehicles, a valid regular driver's license is sufficient.
                                                However, certain specialty vehicles, such as large vans or luxury cars, may
                                                have additional license requirements or driving experience prerequisites.
                                                These are specified during the booking process for applicable vehicles.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="insurance">
                        <!-- Insurance FAQs content -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-primary text-white">
                                <h3 class="mb-0"><i class="fas fa-shield-alt me-2"></i>Insurance & Coverage</h3>
                            </div>
                            <div class="card-body">
                                <div class="accordion" id="accordionInsurance">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingIns1">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseIns1" aria-expanded="true"
                                                aria-controls="collapseIns1">
                                                What insurance coverage is included in my rental?
                                            </button>
                                        </h2>
                                        <div id="collapseIns1" class="accordion-collapse collapse show"
                                            aria-labelledby="headingIns1" data-bs-parent="#accordionInsurance">
                                            <div class="accordion-body">
                                                Our standard rental packages include basic liability insurance as required
                                                by law. This covers damages to third parties but does not cover the rental
                                                vehicle itself. Additional coverage options, such as collision damage waiver
                                                (CDW) and personal accident insurance, are available during the booking
                                                process.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingIns2">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseIns2"
                                                aria-expanded="false" aria-controls="collapseIns2">
                                                Can I use my personal auto insurance for the rental?
                                            </button>
                                        </h2>
                                        <div id="collapseIns2" class="accordion-collapse collapse"
                                            aria-labelledby="headingIns2" data-bs-parent="#accordionInsurance">
                                            <div class="accordion-body">
                                                Many personal auto insurance policies extend coverage to rental vehicles. We
                                                recommend checking with your insurance provider before your rental to
                                                understand what is covered. If your personal insurance covers rental
                                                vehicles, you may be able to decline some of our optional coverage
                                                offerings.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="account">
                        <!-- Account Management FAQs content -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-primary text-white">
                                <h3 class="mb-0"><i class="fas fa-user me-2"></i>Account Management</h3>
                            </div>
                            <div class="card-body">
                                <div class="accordion" id="accordionAccount">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingAcc1">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseAcc1" aria-expanded="true"
                                                aria-controls="collapseAcc1">
                                                How do I create an account?
                                            </button>
                                        </h2>
                                        <div id="collapseAcc1" class="accordion-collapse collapse show"
                                            aria-labelledby="headingAcc1" data-bs-parent="#accordionAccount">
                                            <div class="accordion-body">
                                                Creating an account is simple. Click on the "Register" button in the
                                                top-right corner of the website. Fill in your details, including your name,
                                                email address, and a secure password. Once registered, you can manage your
                                                profile, view your rental history, and make reservations more quickly.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingAcc2">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseAcc2"
                                                aria-expanded="false" aria-controls="collapseAcc2">
                                                How can I update my account information?
                                            </button>
                                        </h2>
                                        <div id="collapseAcc2" class="accordion-collapse collapse"
                                            aria-labelledby="headingAcc2" data-bs-parent="#accordionAccount">
                                            <div class="accordion-body">
                                                To update your account information, log in to your account and navigate to
                                                the "Profile" section. Here, you can update your personal details, change
                                                your password, and manage your communication preferences. Keeping your
                                                information up to date ensures a smooth rental experience.
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
    </div>
@endsection

@push('scripts')
    <script>
        // Activate tab based on hash in URL
        document.addEventListener('DOMContentLoaded', function() {
            const hash = window.location.hash;
            if (hash) {
                const triggerEl = document.querySelector('a[href="' + hash + '"]');
                if (triggerEl) {
                    triggerEl.click();
                }
            }

            // Update URL hash when tab changes
            const tabLinks = document.querySelectorAll('.list-group-item');
            tabLinks.forEach(function(tabLink) {
                tabLink.addEventListener('click', function(e) {
                    window.location.hash = e.target.getAttribute('href');
                });
            });
        });
    </script>
@endpush
