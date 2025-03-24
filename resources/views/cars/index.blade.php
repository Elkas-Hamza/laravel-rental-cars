@extends('layouts.app')

@section('title', 'Browse Our Fleet - Car Rental System')

@section('content')
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <h1>Our Cars</h1>
                    <p>Browse our complete fleet of vehicles available for rent</p>
                </div>

                <!-- Search Bar -->
                <div class="col-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('cars.index') }}" method="GET" class="row g-3 align-items-center">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                                        <input type="text" class="form-control" name="search"
                                            placeholder="Search by brand, model, or year..."
                                            value="{{ request('search') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary w-100"><i
                                            class="fas fa-search me-2"></i>Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Date Selection Form -->
                <div class="col-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3"><i class="fas fa-calendar-alt me-2"></i>Select Rental Dates</h5>
                            <form action="{{ route('cars.available') }}" method="GET" class="row g-3 align-items-end">
                                <div class="col-md-5">
                                    <label for="date_de_location" class="form-label">Pick-up Date</label>
                                    <input type="date" class="form-control" id="date_de_location" name="date_de_location"
                                        min="{{ date('Y-m-d') }}" value="{{ session('date_de_location', date('Y-m-d')) }}"
                                        required>
                                </div>
                                <div class="col-md-5">
                                    <label for="date_de_retour" class="form-label">Return Date</label>
                                    <input type="date" class="form-control" id="date_de_retour" name="date_de_retour"
                                        min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                        value="{{ session('date_de_retour', date('Y-m-d', strtotime('+1 day'))) }}"
                                        required>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fas fa-calendar-check me-2"></i>Check
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-12">
                    <div class="custom-block-filter shadow-sm p-4 rounded">
                        <h5 class="mb-4"><i class="fas fa-filter me-2"></i>Filter Cars</h5>

                        <form action="{{ route('cars.index') }}" method="GET" id="filter-form">
                            <div class="mb-3">
                                <label for="marque" class="form-label">Brand</label>
                                <select class="form-select" id="marque" name="marque">
                                    <option value="">All Brands</option>
                                    @php
                                        $brands = $cars->pluck('marque')->unique()->sort();
                                    @endphp
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand }}"
                                            {{ request('marque') == $brand ? 'selected' : '' }}>{{ $brand }}
                                        </option>
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
                                        <option value="{{ $model }}"
                                            {{ request('model') == $model ? 'selected' : '' }}>{{ $model }}
                                        </option>
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
                                        <option value="{{ $type }}"
                                            {{ request('fuel_type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <hr>
                            <h6 class="mb-3">Price Range (per day)</h6>
                            <div class="mb-3">
                                <label for="price_min" class="form-label">Min Price ($)</label>
                                <input type="number" class="form-control" id="price_min" name="price_min" min="0"
                                    value="{{ request('price_min') }}">
                            </div>

                            <div class="mb-3">
                                <label for="price_max" class="form-label">Max Price ($)</label>
                                <input type="number" class="form-control" id="price_max" name="price_max" min="0"
                                    value="{{ request('price_max') }}">
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-filter me-2"></i>Apply
                                    Filters</button>
                                <a href="{{ route('cars.index') }}" class="btn btn-outline-secondary"><i
                                        class="fas fa-redo me-2"></i>Reset Filters</a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-9 col-md-8 col-12">
                    @if (request('search') ||
                            request('marque') ||
                            request('model') ||
                            request('fuel_type') ||
                            request('price_min') ||
                            request('price_max'))
                        <div class="mb-3">
                            <div class="alert alert-info">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-info-circle me-2"></i>
                                        Showing filtered results.
                                        <strong>{{ $cars->count() }}</strong> car(s) found.
                                    </div>
                                    <a href="{{ route('cars.index') }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-times me-1"></i>Clear Filters
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        @if ($cars->count() > 0)
                            @foreach ($cars as $car)
                                <div class="col-lg-4 col-md-6 col-12 mb-4">
                                    <div class="card h-100 shadow-sm">
                                        <img src="{{ asset($car->image) }}" class="card-img-top"
                                            alt="{{ $car->brand }} {{ $car->model }}"
                                            style="height: 200px; object-fit: cover;">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $car->brand }} {{ $car->model }}</h5>
                                            <p class="card-text mb-3">
                                            <div class="car-feature"><i class="fas fa-calendar-alt"></i>
                                                {{ $car->year }}</div>
                                            <div class="car-feature"><i class="fas fa-palette"></i> {{ $car->color }}
                                            </div>
                                            <div class="car-feature"><i class="fas fa-gas-pump"></i>
                                                {{ $car->fuel_type }}</div>
                                            <div class="car-feature"><i class="fas fa-dollar-sign"></i>
                                                ${{ number_format($car->price_per_day, 2) }}/day</div>
                                            </p>
                                            <div class="d-grid">
                                                <a href="{{ route('cars.show', $car) }}" class="btn btn-primary">View
                                                    Details</a>
                                            </div>
                                        </div>
                                        <div class="card-footer text-center">
                                            <span class="badge {{ $car->disponible ? 'bg-success' : 'bg-danger' }}">
                                                {{ $car->disponible ? 'Available' : 'Not Available' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12 text-center">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i> No cars found matching your criteria. Please
                                    try different filters.
                                </div>
                            </div>
                        @endif
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

                    fetch(`{{ route('cars.index') }}?${searchParams.toString()}`, {
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
                            `{{ asset('/') }}${car.image}` :
                            '{{ asset('images/no-image.jpg') }}';

                        const availabilityClass = car.disponible ? 'bg-success' : 'bg-danger';
                        const availabilityText = car.disponible ? 'Available' : 'Not Available';

                        const carCard = `
                        <div class="col-lg-4 col-md-6 col-12 mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="${carImage}" class="card-img-top" alt="${car.brand} ${car.model}" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title">${car.brand} ${car.model}</h5>
                                    <p class="card-text mb-3">
                                        <div class="car-feature"><i class="fas fa-calendar-alt"></i> ${car.year}</div>
                                        <div class="car-feature"><i class="fas fa-palette"></i> ${car.color}</div>
                                        <div class="car-feature"><i class="fas fa-gas-pump"></i> ${car.fuel_type}</div>
                                        <div class="car-feature"><i class="fas fa-dollar-sign"></i> $${parseFloat(car.price_per_day).toFixed(2)}/day</div>
                                    </p>
                                    <div class="d-grid">
                                        <a href="/cars/${car.id}" class="btn btn-primary">View Details</a>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <span class="badge ${availabilityClass}">
                                        ${availabilityText}
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
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> No cars found matching your criteria. Please try different filters.
                        </div>
                    </div>
                `;
                }
            }

            // Add this new script for the date picker functionality
            const pickupDateInput = document.getElementById('date_de_location');
            const returnDateInput = document.getElementById('date_de_retour');

            if (pickupDateInput && returnDateInput) {
                // When pickup date changes, update the min attribute of return date
                pickupDateInput.addEventListener('change', function() {
                    const newPickupDate = this.value;
                    returnDateInput.min = newPickupDate;

                    // If current return date is before the new pickup date, update it
                    if (returnDateInput.value < newPickupDate) {
                        // Set return date to the day after the new pickup date
                        const nextDay = new Date(newPickupDate);
                        nextDay.setDate(nextDay.getDate() + 1);
                        returnDateInput.value = nextDay.toISOString().split('T')[0];
                    }
                });
            }
        });
    </script>
@endsection
