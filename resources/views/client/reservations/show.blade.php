@extends('layouts.app')

@section('title', 'Reservation Details')

@section('styles')
    <style>
        .reservation-card {
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
        
        .detail-section {
            margin-top: 2rem;
        }
        
        .price-details {
            background: #f8f9fa;
            border-radius: 0.5rem;
            padding: 1rem;
        }
        
        .status-badge {
            padding: 0.5rem 0.75rem;
            border-radius: 0.25rem;
            font-weight: 500;
            font-size: 0.875rem;
        }
        
        .status-active {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #664d03;
        }
        
        .status-completed {
            background-color: #cff4fc;
            color: #055160;
        }
        
        .status-cancelled {
            background-color: #f8d7da;
            color: #842029;
        }
    </style>
@endsection

@section('content')
    <div class="container my-5">
        <div class="reservation-card shadow-sm">
            <div class="card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="card-title">Reservation Details</h1>
                        
                        @php
                            $statusClass = 'status-pending';
                            if ($reservation->status === 'confirmed') {
                                $statusClass = 'status-active';
                            } elseif ($reservation->status === 'completed') {
                                $statusClass = 'status-completed';
                            } elseif ($reservation->status === 'cancelled') {
                                $statusClass = 'status-cancelled';
                            }
                        @endphp
                        
                        <span class="status-badge {{ $statusClass }}">
                            {{ ucfirst($reservation->status) }}
                        </span>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Car Details</h5>
                                    <hr>
                                    
                                    <div class="text-center mb-3">
                                        <img src="{{ $reservation->car->image ? asset('images/cars/' . $reservation->car->image) : asset('images/no-image.jpg') }}" 
                                             class="card-image img-fluid" alt="{{ $reservation->car->marque }} {{ $reservation->car->model }}">
                                    </div>
                                    
                                    <h4>{{ $reservation->car->marque }} {{ $reservation->car->model }}</h4>
                                    <p class="text-muted">{{ $reservation->car->year }} • {{ ucfirst($reservation->car->fuel_type) }} • {{ ucfirst($reservation->car->transmission) }}</p>
                                    
                                    <div class="mt-3">
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="mb-1"><i class="fas fa-chair me-2"></i> Seats:</p>
                                                <p class="mb-3">{{ $reservation->car->seats }}</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="mb-1"><i class="fas fa-gas-pump me-2"></i> Fuel:</p>
                                                <p class="mb-3">{{ ucfirst($reservation->car->fuel_type) }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="mb-1"><i class="fas fa-cogs me-2"></i> Transmission:</p>
                                                <p class="mb-3">{{ ucfirst($reservation->car->transmission) }}</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="mb-1"><i class="fas fa-calendar-alt me-2"></i> Year:</p>
                                                <p class="mb-3">{{ $reservation->car->year }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Reservation Summary</h5>
                                    <hr>
                                    
                                    <div class="card-info">
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
                                            @endif
                                        </div>
                                        
                                        <p><strong>Total Amount:</strong> <span class="fw-bold text-primary">${{ number_format($reservation->prix_total, 2) }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('client.reservations.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i> Back to Reservations
                                </a>
                                
                                @if($reservation->status === 'pending' || $reservation->status === 'confirmed')
                                    @if(\Carbon\Carbon::parse($reservation->date_debut)->isFuture())
                                        <form action="{{ route('reservations.cancel', $reservation) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this reservation?')">
                                                <i class="fas fa-times me-2"></i> Cancel Reservation
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 