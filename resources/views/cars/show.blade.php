@extends('layouts.app')

@section('title', $car->name)

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
    <div class="container my-4">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="mb-0">{{ $car->name }}</h1>
                    <div>
                        <a href="{{ route('cars.index') }}" class="btn btn-outline-secondary me-2">
                            <i class="bi bi-arrow-left me-1"></i>Back to Cars
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm position-relative">
                    <span
                        class="status-badge bg-{{ $car->status == 'available' ? 'success' : ($car->status == 'rented' ? 'danger' : 'warning') }}">
                        {{ ucfirst($car->status) }}
                    </span>
                    <img src="{{ asset($car->image_url) }}" class="car-image card-img-top" alt="{{ $car->name }}">
                    <div class="card-body">
                        <h4 class="card-title mb-3">{{ $car->name }}</h4>
                        <div class="mb-4">
                            <span class="badge bg-light text-dark me-2">{{ $car->category }}</span>
                            <span class="badge bg-light text-dark me-2">{{ $car->year }}</span>
                            <span class="badge bg-light text-dark">{{ $car->license_plate }}</span>
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
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Daily Rate</h6>
                                <p class="mb-0 text-primary fw-bold">${{ number_format($car->price_per_day, 2) }}</p>
                            </div>
                        </div>

                        <div class="spec-item d-flex align-items-center">
                            <div class="spec-icon">
                                <i class="bi bi-gear-fill"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Transmission</h6>
                                <p class="mb-0">{{ ucfirst($car->transmission) }}</p>
                            </div>
                        </div>

                        <div class="spec-item d-flex align-items-center">
                            <div class="spec-icon">
                                <i class="bi bi-fuel-pump-fill"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Fuel Type</h6>
                                <p class="mb-0">{{ ucfirst($car->fuel_type) }}</p>
                            </div>
                        </div>

                        <div class="spec-item d-flex align-items-center">
                            <div class="spec-icon">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Seating Capacity</h6>
                                <p class="mb-0">{{ $car->seats }} Seats</p>
                            </div>
                        </div>

                        <div class="spec-item d-flex align-items-center">
                            <div class="spec-icon">
                                <i class="bi bi-calendar-event"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Model Year</h6>
                                <p class="mb-0">{{ $car->year }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Availability</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="d-block mb-2">Current Status:</span>
                            <span
                                class="badge bg-{{ $car->status == 'available' ? 'success' : ($car->status == 'rented' ? 'danger' : 'warning') }} p-2">
                                {{ ucfirst($car->status) }}
                            </span>
                        </div>

                        @if ($car->status == 'available')
                            <div class="mt-4">
                                <a href="{{ route('reservations.create', $car->id) }}" class="btn btn-primary w-100">Rent
                                    This Car</a>
                            </div>
                        @else
                            <div class="mt-4">
                                <button disabled class="btn btn-secondary w-100">Currently Unavailable</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
