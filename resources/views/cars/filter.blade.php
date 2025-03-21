@extends('layouts.app')

@section('title', 'Filtered Cars')

@section('content')
    <div class="container my-5">
        <h1 class="mb-4">Filtered Cars</h1>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <p class="mb-0">Showing {{ $cars->count() }} cars</p>
            <a href="{{ route('cars.available') }}" class="btn btn-outline-primary">
                <i class="bi bi-funnel me-1"></i>Modify Filters
            </a>
        </div>

        <div class="row g-4">
            @forelse($cars as $car)
                <div class="col-md-6 col-lg-4">
                    <div class="card car-card shadow-sm h-100">
                        <div class="car-image-container">
                            <img src="{{ asset($car->image_url) }}" class="car-image" alt="{{ $car->name }}">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $car->name }}</h5>
                            <p class="card-text text-muted mb-2">{{ $car->category }} • {{ $car->year }}</p>

                            <div class="car-spec">
                                <i class="bi bi-gear-fill"></i>
                                <span>{{ $car->transmission }}</span>
                            </div>
                            <div class="car-spec">
                                <i class="bi bi-fuel-pump-fill"></i>
                                <span>{{ $car->fuel_type }}</span>
                            </div>
                            <div class="car-spec">
                                <i class="bi bi-people-fill"></i>
                                <span>{{ $car->seats }} Seats</span>
                            </div>

                            <div class="mt-3">
                                <h5 class="text-primary mb-0">${{ number_format($car->price_per_day, 2) }} / day
                                </h5>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top-0">
                            <a href="{{ route('cars.show', $car->id) }}" class="btn btn-primary w-100">View
                                Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">No cars found matching your criteria. Try adjusting your filters.</div>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .car-card {
            transition: all 0.3s ease;
            border: none;
        }

        .car-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .car-image-container {
            height: 220px;
            overflow: hidden;
            border-radius: 0.25rem 0.25rem 0 0;
        }

        .car-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .car-card:hover .car-image {
            transform: scale(1.1);
        }

        .car-spec {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .car-spec i {
            width: 20px;
            margin-right: 8px;
            color: var(--primary-color);
        }
    </style>
@endsection
