@extends('layouts.app')

@section('title', 'Available Cars - Car Rental System')

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

        .filter-section {
            background-color: #f8f9fa;
            border-radius: 0.25rem;
        }

        .price-range-container {
            position: relative;
            height: 30px;
        }

        .price-range-track {
            position: absolute;
            width: 100%;
            height: 5px;
            background-color: #dee2e6;
            border-radius: 5px;
            top: 50%;
            transform: translateY(-50%);
        }

        .price-range-progress {
            position: absolute;
            height: 5px;
            background-color: var(--primary-color);
            border-radius: 5px;
            top: 50%;
            transform: translateY(-50%);
        }

        .price-range-handle {
            position: absolute;
            width: 16px;
            height: 16px;
            background-color: white;
            border: 2px solid var(--primary-color);
            border-radius: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <h1>Available Cars</h1> 
                    <p>Cars available for rent during your selected dates: {{ $startDate }} to {{ $endDate }}</p>
                </div>

                <!-- Search Bar -->
                <div class="col-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('cars.available') }}" method="GET" class="row g-3 align-items-center">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                                        <input type="text" class="form-control" name="search" placeholder="Search by brand, model, or year..." value="{{ request('search') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-2"></i>Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-12">
                    <div class="custom-block-filter shadow-sm p-4 rounded">
                        <h5 class="mb-4"><i class="fas fa-filter me-2"></i>Filter Cars</h5>

                        <form action="{{ route('cars.available') }}" method="GET" id="filter-form">
                            <div class="mb-3">
                                <label for="marque" class="form-label">Brand</label>
                                <select class="form-select" id="marque" name="marque">
                                    <option value="">All Brands</option>
                                    @php
                                        $brands = $cars->pluck('marque')->unique()->sort();
                                    @endphp
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand }}" {{ request('marque') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="model" class="form-label">Model</label>
                                <select class="form-select" id="model" name="model">
                                    <option value="">All Models</option>
                                    @php
                                        $models = $cars->pluck('model')->unique()->sort();
                                    @endphp
                                    @foreach ($models as $model)
                                        <option value="{{ $model }}" {{ request('model') == $model ? 'selected' : '' }}>{{ $model }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="fuel_type" class="form-label">Fuel Type</label>
                                <select class="form-select" id="fuel_type" name="fuel_type">
                                    <option value="">All Types</option>
                                    @php
                                        $fuelTypes = $cars->pluck('fuel_type')->unique()->sort();
                                    @endphp
                                    @foreach ($fuelTypes as $type)
                                        <option value="{{ $type }}" {{ request('fuel_type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <hr>
                            <h6 class="mb-3">Price Range (per day)</h6>
                            <div class="mb-3">
                                <label for="price_min" class="form-label">Min Price ($)</label>
                                <input type="number" class="form-control" id="price_min" name="price_min" min="0" value="{{ request('price_min') }}">
                            </div>

                            <div class="mb-3">
                                <label for="price_max" class="form-label">Max Price ($)</label>
                                <input type="number" class="form-control" id="price_max" name="price_max" min="0" value="{{ request('price_max') }}">
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-filter me-2"></i>Apply Filters</button>
                                <a href="{{ route('cars.available') }}" class="btn btn-outline-secondary"><i class="fas fa-redo me-2"></i>Reset Filters</a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-9 col-md-8 col-12">
                    <div class="alert alert-info mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-calendar-check me-2"></i>
                                <strong>{{ $cars->count() }}</strong> cars available from 
                                <strong>{{ $startDate }}</strong> to <strong>{{ $endDate }}</strong>
                            </div>
                            <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-calendar-alt me-1"></i>Change Dates
                            </a>
                        </div>
                    </div>
                
                    <div class="row">
                        @if ($cars->count() > 0)
                            @foreach ($cars as $car)
                                <div class="col-lg-4 col-md-6 col-12 mb-4">
                                    <div class="card h-100 shadow-sm">
                                        <img src="{{ $car->image ? asset('images/cars/' . $car->image) : asset('images/no-image.jpg') }}"
                                            class="card-img-top" alt="{{ $car->marque }} {{ $car->model }}" style="height: 200px; object-fit: cover;">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $car->marque }} {{ $car->model }}</h5>
                                            <p class="card-text mb-3">
                                                <div class="car-feature"><i class="fas fa-calendar-alt"></i> {{ $car->year }}</div>
                                                <div class="car-feature"><i class="fas fa-palette"></i> {{ $car->color }}</div>
                                                <div class="car-feature"><i class="fas fa-gas-pump"></i> {{ $car->fuel_type }}</div>
                                                <div class="car-feature"><i class="fas fa-dollar-sign"></i> ${{ number_format($car->prix_journalier, 2) }}/day</div>
                                            </p>
                                            <div class="d-grid">
                                                <a href="{{ route('cars.show', $car) }}" class="btn btn-primary">View Details</a>
                                            </div>
                                        </div>
                                        <div class="card-footer text-center">
                                            <span class="badge bg-success">
                                                Available
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12 text-center">
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i> No cars available for the selected dates. Please try different dates.
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $cars->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle form submission with AJAX
            const filterForm = document.getElementById('filter-form');
            if (filterForm) {
                filterForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(filterForm);
                    const searchParams = new URLSearchParams();

                    for (const pair of formData) {
                        searchParams.append(pair[0], pair[1]);
                    }

                    fetch(`{{ route('cars.available') }}?${searchParams.toString()}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            updateCarList(data.cars);
                        })
                        .catch(error => console.error('Error:', error));
                });
            }

            function updateCarList(cars) {
                const carsContainer = document.querySelector('.col-lg-9 .row');
                carsContainer.innerHTML = '';

                if (cars.length > 0) {
                    cars.forEach(car => {
                        const carImage = car.image ?
                            `{{ asset('images/cars/') }}/${car.image}` :
                            '{{ asset('images/no-image.jpg') }}';

                        const carCard = `
                        <div class="col-lg-4 col-md-6 col-12 mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="${carImage}" class="card-img-top" alt="${car.marque} ${car.model}" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title">${car.marque} ${car.model}</h5>
                                    <p class="card-text mb-3">
                                        <div class="car-feature"><i class="fas fa-calendar-alt"></i> ${car.year}</div>
                                        <div class="car-feature"><i class="fas fa-palette"></i> ${car.color}</div>
                                        <div class="car-feature"><i class="fas fa-gas-pump"></i> ${car.fuel_type}</div>
                                        <div class="car-feature"><i class="fas fa-dollar-sign"></i> $${parseFloat(car.prix_journalier).toFixed(2)}/day</div>
                                    </p>
                                    <div class="d-grid">
                                        <a href="/cars/${car.id}" class="btn btn-primary">View Details</a>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <span class="badge bg-success">
                                        Available
                                    </span>
                                </div>
                            </div>
                        </div>
                    `;

                        carsContainer.innerHTML += carCard;
                    });
                } else {
                    carsContainer.innerHTML = `
                    <div class="col-12 text-center">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i> No cars available for the selected dates. Please try different dates.
                        </div>
                    </div>
                `;
                }
            }
        });
    </script>
@endsection
