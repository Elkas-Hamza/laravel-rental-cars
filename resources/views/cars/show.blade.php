@extends('layouts.app')

@section('title', $car->brand . ' ' . $car->model)

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

        .thumbnail {
            height: 80px;
            object-fit: cover;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.3s;
        }

        .thumbnail:hover,
        .thumbnail.active {
            opacity: 1;
            border: 2px solid #007bff;
        }
    </style>
@endsection

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8">
                {{-- Main Image --}}
                <div class="position-relative mb-4">
                    <img src="{{ asset($car->image) }}" class="img-fluid car-image w-100" id="mainImage"
                        alt="{{ $car->brand }} {{ $car->model }}">
                    @if ($car->status === 'available')
                        <span class="status-badge bg-success text-white">Available</span>
                    @else
                        <span class="status-badge bg-danger text-white">Unavailable</span>
                    @endif
                </div>

                {{-- Thumbnails --}}
                @if ($car->images)
                    <div class="row mb-4">
                        @foreach (json_decode($car->images) as $index => $image)
                            <div class="col-3 mb-3">
                                <img src="{{ asset($image) }}"
                                    class="img-fluid thumbnail rounded {{ $index === 0 ? 'active' : '' }}"
                                    alt="{{ $car->brand }} {{ $car->model }}"
                                    onclick="changeMainImage('{{ asset($image) }}', this)">
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Car Description --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">About this Car</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ $car->description }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm sticky-top" style="top: 2rem;">
                    <div class="card-body">
                        <h2 class="card-title">{{ $car->brand }} {{ $car->model }}</h2>
                        <h5 class="text-muted mb-4">{{ $car->year }} · {{ $car->color }}</h5>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="text-primary mb-0">${{ number_format($car->price_per_day, 2) }}</h3>
                            <span class="text-muted">per day</span>
                        </div>

                        {{-- Specifications --}}
                        <div class="mb-4">
                            <div class="d-flex align-items-center spec-item">
                                <div class="spec-icon">
                                    <i class="fas fa-gas-pump"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Fuel Type</h6>
                                    <p class="mb-0">{{ $car->fuel_type }}</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-center spec-item">
                                <div class="spec-icon">
                                    <i class="fas fa-cog"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Transmission</h6>
                                    <p class="mb-0">{{ ucfirst($car->transmission) }}</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-center spec-item">
                                <div class="spec-icon">
                                    <i class="fas fa-user-friends"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Seats</h6>
                                    <p class="mb-0">{{ $car->seats }} Persons</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-center spec-item">
                                <div class="spec-icon">
                                    <i class="fas fa-snowflake"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Air Conditioner</h6>
                                    <p class="mb-0">{{ $car->air_conditioner ? 'Yes' : 'No' }}</p>
                                </div>
                            </div>
                        </div>

                        @if ($car->disponible)
                            @auth
                                <div class="mt-4">
                                    <a href="{{ route('client.reservations.create', $car->id) }}"
                                        class="btn btn-primary w-100">
                                        <i class="fas fa-calendar-plus me-2"></i>Rent This Car
                                    </a>
                                </div>
                            @else
                                <div class="mt-4">
                                    <a href="{{ route('login') }}" class="btn btn-outline-primary w-100"
                                        onclick="event.preventDefault(); document.getElementById('store-car-form').submit();">
                                        <i class="fas fa-sign-in-alt me-2"></i>Login to Rent
                                    </a>
                                    <form id="store-car-form" action="{{ route('store.car.session') }}" method="POST"
                                        style="display: none;">
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

    <script>
        function changeMainImage(src, thumbnail) {
            // Update main image
            document.getElementById('mainImage').src = src;

            // Update active thumbnail
            document.querySelectorAll('.thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
            });
            thumbnail.classList.add('active');
        }
    </script>
@endsection
