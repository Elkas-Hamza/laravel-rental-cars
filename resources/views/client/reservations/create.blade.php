@extends('layouts.app')

@section('title', 'New Reservation')

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .car-image {
            height: 300px;
            object-fit: cover;
            border-radius: 8px;
        }
        
        .reservation-form {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
        }
        
        .car-details {
            transition: all 0.3s;
        }
        
        .car-details:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }
        
        .feature-icon {
            width: 32px;
            height: 32px;
            background-color: #e9ecef;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
        }
        
        .feature-icon i {
            color: var(--primary-color);
        }
    </style>
@endsection

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-12 mb-4">
                <h1>Rent a Car</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cars.index') }}">Cars</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cars.show', $car) }}">{{ $car->marque }} {{ $car->model }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">New Reservation</li>
                    </ol>
                </nav>
            </div>
            
            <!-- Car Details Section -->
            <div class="col-lg-5 mb-4">
                <div class="card shadow-sm car-details h-100">
                    <div class="card-body">
                        <h5 class="card-title">Selected Vehicle</h5>
                        <hr>
                        <div class="text-center mb-3">
                            <img src="{{ $car->image ? asset('images/cars/' . $car->image) : asset('images/no-image.jpg') }}" 
                                 class="car-image img-fluid" alt="{{ $car->marque }} {{ $car->model }}">
                        </div>
                        <h4 class="mt-3">{{ $car->marque }} {{ $car->model }} ({{ $car->year }})</h4>
                        <p class="text-muted">{{ $car->description }}</p>
                        
                        <div class="mt-4">
                            <h5>Car Specifications</h5>
                            <div class="d-flex align-items-center mb-2">
                                <div class="feature-icon">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                                <div>
                                    <strong>Price:</strong> ${{ number_format($car->prix_journalier, 2) }} per day
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="feature-icon">
                                    <i class="fas fa-gas-pump"></i>
                                </div>
                                <div>
                                    <strong>Fuel Type:</strong> {{ ucfirst($car->fuel_type) }}
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="feature-icon">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <div>
                                    <strong>Transmission:</strong> {{ ucfirst($car->transmission) }}
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="feature-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <strong>Seats:</strong> {{ $car->seats }} passengers
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Reservation Form Section -->
            <div class="col-lg-7">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Reservation Details</h5>
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
                        
                        <form action="{{ route('client.reservations.store', $car) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="date_debut" class="form-label">Pick-up Date</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="text" class="form-control" id="date_debut" name="date_debut" 
                                               placeholder="Select date" value="{{ $startDate ?? '' }}" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="date_fin" class="form-label">Return Date</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="text" class="form-control" id="date_fin" name="date_fin" 
                                               placeholder="Select date" value="{{ $endDate ?? '' }}" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="pickup_location" class="form-label">Pick-up Location</label>
                                    <select class="form-select" id="pickup_location" name="pickup_location" required>
                                        <option value="">Select location</option>
                                        <option value="Main Office">Main Office - 123 Main St</option>
                                        <option value="Airport">Airport Terminal</option>
                                        <option value="Downtown">Downtown Branch - 456 City Center</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="return_location" class="form-label">Return Location</label>
                                    <select class="form-select" id="return_location" name="return_location" required>
                                        <option value="">Select location</option>
                                        <option value="Main Office">Main Office - 123 Main St</option>
                                        <option value="Airport">Airport Terminal</option>
                                        <option value="Downtown">Downtown Branch - 456 City Center</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mt-4" id="price-calculation">
                                <h5>Price Calculation</h5>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Daily Rate:</span>
                                            <span>${{ number_format($car->prix_journalier, 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Number of Days:</span>
                                            <span id="duration">{{ $days ?? 0 }}</span>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between fw-bold">
                                            <span>Total Price:</span>
                                            <span id="total-price">${{ isset($totalPrice) ? number_format($totalPrice, 2) : '0.00' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="prix_total" id="prix_total" value="{{ $totalPrice ?? 0 }}">
                            </div>
                            
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">Continue to Payment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize date pickers
            const pickupDatePicker = flatpickr("#date_debut", {
                enableTime: false,
                dateFormat: "Y-m-d",
                minDate: "today",
                onChange: calculatePrice
            });
            
            const returnDatePicker = flatpickr("#date_fin", {
                enableTime: false,
                dateFormat: "Y-m-d",
                minDate: "today",
                onChange: calculatePrice
            });
            
            // Calculate price based on selected dates
            function calculatePrice() {
                const pickupDate = new Date(document.getElementById('date_debut').value);
                const returnDate = new Date(document.getElementById('date_fin').value);
                
                if (pickupDate && returnDate && pickupDate < returnDate) {
                    // Calculate days difference
                    const diffTime = Math.abs(returnDate - pickupDate);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    
                    // Update days and price
                    document.getElementById('duration').textContent = diffDays;
                    
                    const dailyRate = {{ $car->prix_journalier }};
                    const totalPrice = dailyRate * diffDays;
                    
                    document.getElementById('total-price').textContent = '$' + totalPrice.toFixed(2);
                    document.getElementById('prix_total').value = totalPrice.toFixed(2);
                }
            }
            
            // Calculate initial price if dates are pre-filled
            calculatePrice();
        });
    </script>
@endsection
