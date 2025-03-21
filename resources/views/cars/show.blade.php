@extends('layouts.app')

@section('title', $car->marque . ' ' . $car->model)

@section('styles')
    <style>
        .car-image {
            max-height: 400px;
            object-fit: cover;
            border-radius: 0.25rem;
        }

        .spec-item {
            margin-bottom: 1.5rem;
        }

        .spec-icon {
            width: 40px;
            height: 40px;
            background-color: #f8f9fa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }

        .spec-icon i {
            color: var(--primary-color);
            font-size: 1.25rem;
        }

        .status-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 0.5rem 1rem;
            border-radius: 30px;
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="mb-0">{{ $car->marque }} {{ $car->model }}</h1>
                    <div>
                        <a href="{{ route('cars.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Back to Cars
                        </a>
                    </div>
                </div>
                <nav aria-label="breadcrumb" class="mt-2">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cars.index') }}">Cars</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $car->marque }} {{ $car->model }}</li>
                    </ol>
                </nav>
            </div>

            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm position-relative">
                    <span class="status-badge {{ $car->disponible ? 'bg-success' : 'bg-danger' }}">
                        {{ $car->disponible ? 'Available' : 'Not Available' }}
                    </span>
                    <img src="{{ $car->image ? asset('images/cars/' . $car->image) : asset('images/no-image.jpg') }}" class="car-image card-img-top" alt="{{ $car->marque }} {{ $car->model }}">
                    <div class="card-body">
                        <h4 class="card-title mb-3">{{ $car->marque }} {{ $car->model }} ({{ $car->year }})</h4>
                        <div class="mb-4">
                            <span class="badge bg-light text-dark me-2">{{ $car->year }}</span>
                            <span class="badge bg-light text-dark me-2">{{ ucfirst($car->marque) }}</span>
                            <span class="badge bg-light text-dark">{{ $car->color }}</span>
                        </div>
                        <h5>Description</h5>
                        <p class="card-text">{{ $car->description }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Car Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="spec-item d-flex align-items-center">
                            <div class="spec-icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Daily Rate</h6>
                                <p class="mb-0 text-primary fw-bold">${{ number_format($car->prix_journalier, 2) }}</p>
                            </div>
                        </div>

                        <div class="spec-item d-flex align-items-center">
                            <div class="spec-icon">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Transmission</h6>
                                <p class="mb-0">{{ ucfirst($car->transmission) }}</p>
                            </div>
                        </div>

                        <div class="spec-item d-flex align-items-center">
                            <div class="spec-icon">
                                <i class="fas fa-gas-pump"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Fuel Type</h6>
                                <p class="mb-0">{{ ucfirst($car->fuel_type) }}</p>
                            </div>
                        </div>

                        <div class="spec-item d-flex align-items-center">
                            <div class="spec-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Seating Capacity</h6>
                                <p class="mb-0">{{ $car->seats }} Seats</p>
                            </div>
                        </div>

                        <div class="spec-item d-flex align-items-center">
                            <div class="spec-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Model Year</h6>
                                <p class="mb-0">{{ $car->year }}</p>
                            </div>
                        </div>
                        
                        <div class="spec-item d-flex align-items-center">
                            <div class="spec-icon">
                                <i class="fas fa-palette"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Color</h6>
                                <p class="mb-0">{{ ucfirst($car->color) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Rent This Car</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="d-block mb-2">Current Status:</span>
                            <span class="badge {{ $car->disponible ? 'bg-success' : 'bg-danger' }} p-2">
                                {{ $car->disponible ? 'Available for Rent' : 'Currently Unavailable' }}
                            </span>
                        </div>

                        @if ($car->disponible)
                            @auth
                                <div class="mt-4">
                                    <a href="{{ route('client.reservations.create', $car->id) }}" class="btn btn-primary w-100">
                                        <i class="fas fa-calendar-plus me-2"></i>Rent This Car
                                    </a>
                                </div>
                            @else
                                <div class="mt-4">
                                    <a href="{{ route('login') }}" class="btn btn-outline-primary w-100" onclick="event.preventDefault(); document.getElementById('store-car-form').submit();">
                                        <i class="fas fa-sign-in-alt me-2"></i>Login to Rent
                                    </a>
                                    <form id="store-car-form" action="{{ route('store.car.session') }}" method="POST" style="display: none;">
                                        @csrf
                                        <input type="hidden" name="car_id" value="{{ $car->id }}">
                                    </form>
                                </div>
                            @endauth
                        @else
                            <div class="mt-4 alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                This car is currently unavailable for rent.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
