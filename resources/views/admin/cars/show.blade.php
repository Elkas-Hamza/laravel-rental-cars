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
                        <a href="{{ route('admin.cars.index') }}" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-arrow-left me-1"></i>Back to Cars
                        </a>
                        <a href="{{ route('admin.cars.edit', $car->id) }}" class="btn btn-primary me-2">
                            <i class="fas fa-pencil-alt me-1"></i>Edit
                        </a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteCarModal">
                            <i class="fas fa-trash-alt me-1"></i>Delete
                        </button>
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
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Daily Rate</h6>
                                <p class="mb-0 text-primary fw-bold">${{ number_format($car->price_per_day, 2) }}</p>
                            </div>
                        </div>

                        <div class="spec-item d-flex align-items-center">
                            <div class="spec-icon">
                                <i class="fas fa-cog"></i>
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
                                <i class="fas fa-tag"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">License Plate</h6>
                                <p class="mb-0">{{ $car->license_plate }}</p>
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

                        @if ($car->status == 'rented')
                            <div class="mb-3">
                                <span class="d-block mb-2">Currently rented by:</span>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-person-circle fs-4 me-2"></i>
                                    <div>
                                        <span
                                            class="d-block fw-bold">{{ $car->currentRental->user->name ?? 'Client Name' }}</span>
                                        <small class="text-muted">Until
                                            {{ $car->currentRental ? \Carbon\Carbon::parse($car->currentRental->return_date)->format('M d, Y') : 'May 15, 2025' }}</small>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($car->status == 'maintenance')
                            <div class="mb-3">
                                <span class="d-block mb-2">Maintenance Details:</span>
                                <p>In service for regular maintenance. Expected to be available by
                                    {{ \Carbon\Carbon::now()->addDays(3)->format('M d, Y') }}.</p>
                            </div>
                        @endif

                        <div class="mt-4">
                            <a href="#" class="btn btn-outline-primary w-100 mb-2">View Rental History</a>
                            @if ($car->status != 'available')
                                <button type="button" class="btn btn-success w-100">Mark as Available</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Car Modal -->
    <div class="modal fade" id="deleteCarModal" tabindex="-1" aria-labelledby="deleteCarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCarModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong>{{ $car->name }}</strong>?</p>
                    <p class="text-danger mb-0">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
