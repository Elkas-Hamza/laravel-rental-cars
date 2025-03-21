@extends('layouts.app')

@section('title', 'Browse Cars - Car Rental System')

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

        .car-img {
            height: 200px;
            object-fit: cover;
        }

        .car-title {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .car-price {
            font-weight: 600;
            color: #3490dc;
        }

        .car-detail {
            display: flex;
            align-items: center;
            margin-right: 1rem;
            color: #6c757d;
        }

        .car-detail i {
            margin-right: 0.5rem;
        }

        .search-container {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection

@section('content')
    <div class="container my-5">
        <h1 class="mb-4 text-center">Browse Our Cars</h1>

        <div class="search-container">
            <form action="{{ route('cars.browse') }}" method="GET">
                <div class="row">
                    <div class="col-md-10">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search by brand, model, or year..." value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('cars.browse') }}" class="btn btn-outline-secondary w-100">Reset</a>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-3">
                        <select name="category" class="form-control">
                            <option value="">All Categories</option>
                            <option value="Sedan" {{ request('category') == 'Sedan' ? 'selected' : '' }}>Sedan</option>
                            <option value="SUV" {{ request('category') == 'SUV' ? 'selected' : '' }}>SUV</option>
                            <option value="Sports" {{ request('category') == 'Sports' ? 'selected' : '' }}>Sports</option>
                            <option value="Compact" {{ request('category') == 'Compact' ? 'selected' : '' }}>Compact
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="fuel_type" class="form-control">
                            <option value="">All Fuel Types</option>
                            <option value="Gasoline" {{ request('fuel_type') == 'Gasoline' ? 'selected' : '' }}>Gasoline
                            </option>
                            <option value="Diesel" {{ request('fuel_type') == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                            <option value="Electric" {{ request('fuel_type') == 'Electric' ? 'selected' : '' }}>Electric
                            </option>
                            <option value="Hybrid" {{ request('fuel_type') == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="price_min" class="form-control" placeholder="Min Price"
                            value="{{ request('price_min') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="price_max" class="form-control" placeholder="Max Price"
                            value="{{ request('price_max') }}">
                    </div>
                </div>
            </form>
        </div>

        <div class="row">
            @if ($cars->count() > 0)
                @foreach ($cars as $car)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card car-card h-100 shadow-sm">
                            <img src="{{ $car->image && strpos($car->image, 'http') === false ? asset('images/' . $car->image) : $car->image ?? asset('images/no-image.jpg') }}"
                                alt="{{ $car->brand ?? $car->marque }} {{ $car->model }}" class="card-img-top car-img">
                            <div class="card-body">
                                <h5 class="car-title">{{ $car->brand ?? $car->marque }} {{ $car->model }}
                                    ({{ $car->year }})</h5>
                                <p class="car-price mb-2">
                                    ${{ number_format($car->price_per_day ?? $car->prix_journalier, 2) }} / day</p>
                                <div class="d-flex mb-3 flex-wrap">
                                    <div class="car-detail mr-3">
                                        <i class="fas fa-gas-pump"></i> {{ ucfirst($car->fuel_type) }}
                                    </div>
                                    <div class="car-detail mr-3">
                                        <i class="fas fa-cog"></i> {{ ucfirst($car->transmission) }}
                                    </div>
                                    <div class="car-detail">
                                        <i class="fas fa-users"></i> {{ $car->seats }} seats
                                    </div>
                                </div>
                                <p class="card-text text-muted mb-3">
                                    {{ \Illuminate\Support\Str::limit($car->description, 100) }}</p>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('cars.show', $car) }}" class="btn btn-outline-primary">View
                                        Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center my-5">
                    <div class="alert alert-info">
                        <h4 class="alert-heading">No cars found!</h4>
                        <p>We couldn't find any cars matching your criteria. Please try different search parameters or
                            browse all vehicles.</p>
                    </div>
                </div>
            @endif
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $cars->links() }}
        </div>
    </div>
@endsection
