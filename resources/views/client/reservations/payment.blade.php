@extends('layouts.app')

@section('title', 'Complete Payment')

@section('styles')
    <style>
        .payment-card {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .card-image {
            height: 200px;
            object-fit: cover;
            border-radius: 0.5rem;
        }
        
        .card-info {
            background: #f8f9fa;
            border-radius: 0.5rem;
            padding: 1rem;
        }
        
        .payment-details {
            margin-top: 2rem;
        }
        
        .form-label {
            font-weight: 500;
        }
        
        .price-details {
            background: #f8f9fa;
            border-radius: 0.5rem;
            padding: 1rem;
        }
    </style>
@endsection

@section('content')
    <div class="container my-5">
        <div class="payment-card shadow-sm">
            <div class="card">
                <div class="card-body p-4">
                    <h1 class="card-title mb-4">Complete Your Reservation</h1>
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Reservation Summary</h5>
                                    <hr>
                                    
                                    <div class="text-center mb-3">
                                        <img src="{{ $reservation->car->image ? asset('images/cars/' . $reservation->car->image) : asset('images/no-image.jpg') }}" 
                                             class="card-image img-fluid" alt="{{ $reservation->car->marque }} {{ $reservation->car->model }}">
                                    </div>
                                    
                                    <h4>{{ $reservation->car->marque }} {{ $reservation->car->model }}</h4>
                                    <p class="text-muted">{{ $reservation->car->year }} • {{ ucfirst($reservation->car->fuel_type) }} • {{ ucfirst($reservation->car->transmission) }}</p>
                                    
                                    <div class="card-info mt-3">
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="mb-1"><strong>Pick-up Date:</strong></p>
                                                <p>{{ \Carbon\Carbon::parse($reservation->date_debut)->format('M d, Y') }}</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="mb-1"><strong>Return Date:</strong></p>
                                                <p>{{ \Carbon\Carbon::parse($reservation->date_fin)->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-6">
                                                <p class="mb-1"><strong>Pick-up Location:</strong></p>
                                                <p>{{ $reservation->pickup_location }}</p>
                                                @if($reservation->pickup_fee > 0)
                                                    <span class="badge bg-info text-white">+${{ number_format($reservation->pickup_fee, 2) }} fee</span>
                                                @endif
                                            </div>
                                            <div class="col-6">
                                                <p class="mb-1"><strong>Return Location:</strong></p>
                                                <p>{{ $reservation->return_location }}</p>
                                                @if($reservation->return_fee > 0)
                                                    <span class="badge bg-info text-white">+${{ number_format($reservation->return_fee, 2) }} fee</span>
                                                @endif
                                            </div>
                                        </div>
                                        <hr>
                                        <p><strong>Duration:</strong> {{ $days }} {{ Str::plural('day', $days) }}</p>
                                        <p><strong>Daily Rate:</strong> ${{ number_format($reservation->car->prix_journalier, 2) }}</p>
                                        
                                        <!-- Price breakdown -->
                                        <div class="price-breakdown bg-white p-2 rounded mb-2">
                                            <div class="d-flex justify-content-between">
                                                <span>Car Rental ({{ $days }} {{ Str::plural('day', $days) }}):</span>
                                                <span>${{ number_format($reservation->car->prix_journalier * $days, 2) }}</span>
                                            </div>
                                            @if($reservation->pickup_fee > 0)
                                            <div class="d-flex justify-content-between">
                                                <span>Pickup Location Fee:</span>
                                                <span>${{ number_format($reservation->pickup_fee, 2) }}</span>
                                            </div>
                                            @endif
                                            @if($reservation->return_fee > 0)
                                            <div class="d-flex justify-content-between">
                                                <span>Return Location Fee:</span>
                                                <span>${{ number_format($reservation->return_fee, 2) }}</span>
                                            </div>
                                            @endif
                                            
                                            <!-- Accessories section -->
                                            @if($reservation->add_gps || $reservation->add_wifi || $reservation->add_baby_seat || $reservation->add_full_tank)
                                                <div class="mt-2 mb-1">
                                                    <strong>Selected Accessories:</strong>
                                                </div>
                                                
                                                
                                                <div class="d-flex justify-content-between mt-2">
                                                    <span><strong>Accessories Subtotal:</strong></span>
                                                    <span><strong>${{ number_format($reservation->accessories_fee, 2) }}</strong></span>
                                                </div>
                                                @endif
                                                @if($reservation->add_gps)
                                                <div class="d-flex justify-content-between">
                                                    <span><i class="fas fa-map-marker-alt me-1"></i> GPS Navigation:</span>
                                                    <span>$20.00</span>
                                                </div>
                                                @endif
                                                
                                                @if($reservation->add_wifi)
                                                <div class="d-flex justify-content-between">
                                                    <span><i class="fas fa-wifi me-1"></i> In-car WiFi:</span>
                                                    <span>${{ number_format(2 * $days, 2) }}</span>
                                                </div>
                                                @endif
                                                
                                                @if($reservation->add_baby_seat)
                                                <div class="d-flex justify-content-between">
                                                    <span><i class="fas fa-baby me-1"></i> Baby/Child Seat:</span>
                                                    <span>$10.00</span>
                                                </div>
                                                @endif
                                                
                                                @if($reservation->add_full_tank)
                                                <div class="d-flex justify-content-between">
                                                    <span><i class="fas fa-gas-pump me-1"></i> Full Fuel Tank:</span>
                                                    <span>$45.00</span>
                                                </div>
                                                @endif
                                        </div>
                                        
                                        <p><strong>Total Amount:</strong> <span class="fw-bold text-primary">${{ number_format($reservation->prix_total, 2) }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Payment Information</h5>
                                    <hr>
                                    
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    
                                    <form action="{{ route('client.reservations.processPayment', $reservation) }}" method="POST">
                                        @csrf
                                        
                                        <div class="mb-3">
                                            <label for="card_number" class="form-label">Card Number</label>
                                            <input type="text" class="form-control" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" required>
                                            <div class="form-text">Enter any card number - no verification is done for testing purposes.</div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="card_holder" class="form-label">Card Holder Name</label>
                                            <input type="text" class="form-control" id="card_holder" name="card_holder" placeholder="Name on card" required>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Expiration Date</label>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <select class="form-select" name="expiry_month" required>
                                                            <option value="" selected disabled>Month</option>
                                                            @for ($i = 1; $i <= 12; $i++)
                                                                <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <select class="form-select" name="expiry_year" required>
                                                            <option value="" selected disabled>Year</option>
                                                            @for ($i = date('y'); $i <= date('y') + 10; $i++)
                                                                <option value="{{ $i }}">{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                @error('expiry_date')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="cvv" class="form-label">CVV</label>
                                                <input type="text" class="form-control" id="cvv" name="cvv" placeholder="123" required>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                                <label class="form-check-label" for="terms">
                                                    I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and Conditions</a>
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="d-grid mt-4">
                                            <button type="submit" class="btn btn-primary btn-lg">Pay Now ${{ number_format($reservation->prix_total, 2) }}</button>
                                        </div>
                                        
                                        <div class="text-center mt-3">
                                            <small class="text-muted">
                                                <i class="fas fa-lock me-1"></i> Your payment is secure. We use encryption to protect your data.
                                            </small>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Terms and Conditions Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Rental Agreement Terms</h6>
                    <p>By proceeding with this reservation, you agree to the following terms:</p>
                    <ul>
                        <li>The driver must be at least 21 years old and possess a valid driver's license.</li>
                        <li>A credit card in the driver's name must be presented at the time of pickup.</li>
                        <li>The car must be returned with the same amount of fuel as when it was picked up.</li>
                        <li>Smoking is not allowed in the vehicle.</li>
                        <li>The vehicle must not be taken off-road or used for racing.</li>
                        <li>Any damage to the vehicle will be the responsibility of the renter.</li>
                    </ul>
                    
                    <h6>Cancellation Policy</h6>
                    <p>Free cancellation up to 48 hours before pickup. A fee equivalent to one day's rental will be charged for cancellations within 48 hours of pickup.</p>
                    
                    <h6>Insurance Information</h6>
                    <p>Basic insurance is included in your rental. Additional coverage options are available at the time of pickup.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Format card number input with spaces for better readability
        document.addEventListener('DOMContentLoaded', function() {
            const cardNumberInput = document.getElementById('card_number');
            
            cardNumberInput.addEventListener('input', function(e) {
                // Remove all non-digit characters
                let value = e.target.value.replace(/\D/g, '');
                
                // Add space after every 4 digits
                let formattedValue = '';
                for (let i = 0; i < value.length; i++) {
                    if (i > 0 && i % 4 === 0) {
                        formattedValue += ' ';
                    }
                    formattedValue += value[i];
                }
                
                // Update input value
                e.target.value = formattedValue;
            });
            
            // Format CVV to allow only digits
            const cvvInput = document.getElementById('cvv');
            cvvInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '');
            });
        });
    </script>
@endsection
