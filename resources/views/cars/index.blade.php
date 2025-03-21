@extends('layouts.app')

@section('title', 'Browse Our Fleet - Car Rental System')

@section('content')
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h1>Our Cars</h1>
                    <p>Browse our complete fleet of vehicles available for rent</p>
                </div>

                <div class="col-lg-3 col-md-4 col-12">
                    <div class="custom-block-filter shadow-sm p-4 rounded">
                        <h5 class="mb-4">Filter by</h5>

                        <form action="{{ route('cars.filter') }}" method="GET" id="filter-form">
                            <div class="mb-3">
                                <label for="marque" class="form-label">Brand</label>
                                <select class="form-select" id="marque" name="marque">
                                    <option value="">All Brands</option>
                                    @php
                                        $brands = $cars->pluck('marque')->unique()->sort();
                                    @endphp
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand }}">{{ $brand }}</option>
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
                                        <option value="{{ $model }}">{{ $model }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="price_min" class="form-label">Min Price (per day)</label>
                                <input type="number" class="form-control" id="price_min" name="price_min" min="0">
                            </div>

                            <div class="mb-3">
                                <label for="price_max" class="form-label">Max Price (per day)</label>
                                <input type="number" class="form-control" id="price_max" name="price_max" min="0">
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-9 col-md-8 col-12">
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
                                    <i class="fas fa-info-circle me-2"></i> No cars available at the moment.
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

                    fetch(`{{ route('cars.filter') }}?${searchParams.toString()}`, {
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

                        const availabilityClass = car.disponible ? 'bg-success' : 'bg-danger';
                        const availabilityText = car.disponible ? 'Available' : 'Not Available';

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
                            <i class="fas fa-info-circle me-2"></i> No cars available with the selected filters.
                        </div>
                    </div>
                `;
                }
            }
        });
    </script>
@endsection
