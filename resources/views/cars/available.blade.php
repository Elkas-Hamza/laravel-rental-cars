@extends('layouts.app')

@section('title', 'Available Cars')

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
    <div class="container my-5">
        <h1 class="mb-4">Available Cars</h1>

        <div class="row">
            <!-- Filters Sidebar -->
            <div class="col-lg-3 mb-4">
                <div class="filter-section p-3 shadow-sm mb-4">
                    <h5 class="mb-3">Filter Cars</h5>

                    <form id="filterForm">
                        <div class="mb-3">
                            <label for="searchInput" class="form-label">Search</label>
                            <input type="text" class="form-control" id="searchInput" placeholder="Car name or model">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="sedanCheck" value="sedan">
                                <label class="form-check-label" for="sedanCheck">Sedan</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="suvCheck" value="suv">
                                <label class="form-check-label" for="suvCheck">SUV</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="luxuryCheck" value="luxury">
                                <label class="form-check-label" for="luxuryCheck">Luxury</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="sportsCheck" value="sports">
                                <label class="form-check-label" for="sportsCheck">Sports</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="electricCheck" value="electric">
                                <label class="form-check-label" for="electricCheck">Electric</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Transmission</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="automaticCheck" value="automatic">
                                <label class="form-check-label" for="automaticCheck">Automatic</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="manualCheck" value="manual">
                                <label class="form-check-label" for="manualCheck">Manual</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fuel Type</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gasolineCheck" value="gasoline">
                                <label class="form-check-label" for="gasolineCheck">Gasoline</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="dieselCheck" value="diesel">
                                <label class="form-check-label" for="dieselCheck">Diesel</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="hybridCheck" value="hybrid">
                                <label class="form-check-label" for="hybridCheck">Hybrid</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="electricFuelCheck" value="electric">
                                <label class="form-check-label" for="electricFuelCheck">Electric</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price Range (per day)</label>
                            <div id="priceRange" class="price-range-container mb-2">
                                <div class="price-range-track"></div>
                                <div id="priceRangeProgress" class="price-range-progress"></div>
                                <div id="minPriceHandle" class="price-range-handle"></div>
                                <div id="maxPriceHandle" class="price-range-handle"></div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span id="minPriceLabel">$0</span>
                                <span id="maxPriceLabel">$300</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Seating Capacity</label>
                            <select class="form-select" id="seatsFilter">
                                <option value="">Any</option>
                                <option value="2">2+ seats</option>
                                <option value="4">4+ seats</option>
                                <option value="5">5+ seats</option>
                                <option value="7">7+ seats</option>
                            </select>
                        </div>

                        <button type="button" id="applyFilters" class="btn btn-primary w-100">Apply Filters</button>
                    </form>
                </div>
            </div>

            <!-- Cars Grid -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <p class="mb-0">Showing <span id="carCount">{{ $cars->count() }}</span> cars</p>
                    <div class="d-flex align-items-center">
                        <label for="sortBy" class="me-2">Sort by:</label>
                        <select class="form-select form-select-sm" id="sortBy" style="width: auto;">
                            <option value="price_asc">Price: Low to High</option>
                            <option value="price_desc">Price: High to Low</option>
                            <option value="name_asc">Name: A to Z</option>
                            <option value="name_desc">Name: Z to A</option>
                            <option value="year_desc">Year: Newest First</option>
                            <option value="year_asc">Year: Oldest First</option>
                        </select>
                    </div>
                </div>

                <div class="row g-4" id="carsGrid">
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
                        <!-- Sample data if no cars are provided -->
                        @for ($i = 1; $i <= 6; $i++)
                            <div class="col-md-6 col-lg-4">
                                <div class="card car-card shadow-sm h-100">
                                    <div class="car-image-container">
                                        <img src="{{ asset('images/cars/car' . (($i % 4) + 1) . '.jpg') }}"
                                            class="car-image" alt="Car Sample">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            @if ($i % 4 == 0)
                                                Honda Civic
                                            @elseif($i % 4 == 1)
                                                Toyota Camry
                                            @elseif($i % 4 == 2)
                                                Tesla Model 3
                                            @else
                                                Mercedes-Benz C-Class
                                            @endif
                                        </h5>
                                        <p class="card-text text-muted mb-2">
                                            @if ($i % 4 == 0)
                                                Sedan • 2023
                                            @elseif($i % 4 == 1)
                                                Sedan • 2022
                                            @elseif($i % 4 == 2)
                                                Electric • 2024
                                            @else
                                                Luxury • 2023
                                            @endif
                                        </p>

                                        <div class="car-spec">
                                            <i class="bi bi-gear-fill"></i>
                                            <span>{{ $i % 2 == 0 ? 'Automatic' : 'Manual' }}</span>
                                        </div>
                                        <div class="car-spec">
                                            <i class="bi bi-fuel-pump-fill"></i>
                                            <span>
                                                @if ($i % 4 == 0)
                                                    Gasoline
                                                @elseif($i % 4 == 1)
                                                    Hybrid
                                                @elseif($i % 4 == 2)
                                                    Electric
                                                @else
                                                    Diesel
                                                @endif
                                            </span>
                                        </div>
                                        <div class="car-spec">
                                            <i class="bi bi-people-fill"></i>
                                            <span>{{ 4 + ($i % 3) }} Seats</span>
                                        </div>

                                        <div class="mt-3">
                                            <h5 class="text-primary mb-0">
                                                @if ($i % 4 == 0)
                                                    $35.00 / day
                                                @elseif($i % 4 == 1)
                                                    $45.00 / day
                                                @elseif($i % 4 == 2)
                                                    $75.00 / day
                                                @else
                                                    $120.00 / day
                                                @endif
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-white border-top-0">
                                        <a href="#" class="btn btn-primary w-100">View Details</a>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    @endforelse
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $cars->links() }}

                    @if (empty($cars) || $cars->isEmpty())
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Price range slider functionality
            const minPrice = 0;
            const maxPrice = 300;
            let currentMinPrice = minPrice;
            let currentMaxPrice = maxPrice;

            // Initialize price range slider positions
            updatePriceRangeUI();

            // Make handles draggable
            if ($.ui && $.ui.draggable) {
                $("#minPriceHandle, #maxPriceHandle").draggable({
                    axis: "x",
                    containment: "#priceRange",
                    drag: function(event, ui) {
                        const isMinHandle = $(this).attr('id') === 'minPriceHandle';
                        const totalWidth = $("#priceRange").width();

                        // Calculate price based on position
                        const percentage = ui.position.left / totalWidth;
                        const price = Math.round(percentage * (maxPrice - minPrice) + minPrice);

                        if (isMinHandle) {
                            currentMinPrice = price;
                            if (currentMinPrice >= currentMaxPrice) {
                                currentMinPrice = currentMaxPrice - 1;
                                return false;
                            }
                        } else {
                            currentMaxPrice = price;
                            if (currentMaxPrice <= currentMinPrice) {
                                currentMaxPrice = currentMinPrice + 1;
                                return false;
                            }
                        }

                        updatePriceRangeUI();
                    }
                });
            } else {
                // Fallback if jQuery UI draggable is not available
                console.log("jQuery UI draggable not available, using click handler instead");

                // Add click handler to the price range track
                $("#priceRange").on("click", function(e) {
                    const rangeWidth = $(this).width();
                    const clickPos = e.pageX - $(this).offset().left;
                    const percentage = clickPos / rangeWidth;
                    const price = Math.round(percentage * (maxPrice - minPrice) + minPrice);

                    // Determine which handle to move (the closest one)
                    const minPos = (currentMinPrice - minPrice) / (maxPrice - minPrice) * rangeWidth;
                    const maxPos = (currentMaxPrice - minPrice) / (maxPrice - minPrice) * rangeWidth;

                    if (Math.abs(clickPos - minPos) < Math.abs(clickPos - maxPos)) {
                        // Move min handle
                        currentMinPrice = Math.min(price, currentMaxPrice - 1);
                    } else {
                        // Move max handle
                        currentMaxPrice = Math.max(price, currentMinPrice + 1);
                    }

                    updatePriceRangeUI();
                });
            }

            // Update price range UI elements
            function updatePriceRangeUI() {
                const totalWidth = $("#priceRange").width();
                const minPercentage = (currentMinPrice - minPrice) / (maxPrice - minPrice);
                const maxPercentage = (currentMaxPrice - minPrice) / (maxPrice - minPrice);

                // Update handle positions
                $("#minPriceHandle").css("left", minPercentage * totalWidth);
                $("#maxPriceHandle").css("left", maxPercentage * totalWidth);

                // Update progress bar
                $("#priceRangeProgress").css({
                    "left": minPercentage * totalWidth,
                    "width": (maxPercentage - minPercentage) * totalWidth
                });

                // Update labels
                $("#minPriceLabel").text(`$${currentMinPrice}`);
                $("#maxPriceLabel").text(`$${currentMaxPrice}`);
            }

            // Handle apply filters button click
            $("#applyFilters").click(function() {
                applyFilters();
            });

            // Handle sort by change
            $("#sortBy").change(function() {
                applyFilters();
            });

            // Helper function to get checkbox values
            function getCheckboxValues(type) {
                const values = [];

                if (type === "category") {
                    if ($("#sedanCheck").is(":checked")) values.push("sedan");
                    if ($("#suvCheck").is(":checked")) values.push("suv");
                    if ($("#luxuryCheck").is(":checked")) values.push("luxury");
                    if ($("#sportsCheck").is(":checked")) values.push("sports");
                    if ($("#electricCheck").is(":checked")) values.push("electric");
                } else if (type === "transmission") {
                    if ($("#automaticCheck").is(":checked")) values.push("automatic");
                    if ($("#manualCheck").is(":checked")) values.push("manual");
                } else if (type === "fuel") {
                    if ($("#gasolineCheck").is(":checked")) values.push("gasoline");
                    if ($("#dieselCheck").is(":checked")) values.push("diesel");
                    if ($("#hybridCheck").is(":checked")) values.push("hybrid");
                    if ($("#electricFuelCheck").is(":checked")) values.push("electric");
                }

                return values;
            }

            // Function to collect all filter values and make AJAX request
            function applyFilters() {
                // Show loading state
                $("#carsGrid").html(
                    '<div class="col-12 text-center py-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Loading cars...</p></div>'
                );

                // Get all filter values
                const categories = getCheckboxValues("category");
                const transmissions = getCheckboxValues("transmission");
                const fuel_types = getCheckboxValues("fuel");

                // Build data object
                const data = {
                    search: $("#searchInput").val(),
                    price_min: currentMinPrice,
                    price_max: currentMaxPrice,
                    seats: $("#seatsFilter").val(),
                    sort: $("#sortBy").val()
                };

                // Add array parameters with proper formatting for PHP
                if (categories.length > 0) {
                    categories.forEach((value, index) => {
                        data[`categories[${index}]`] = value;
                    });
                }

                if (transmissions.length > 0) {
                    transmissions.forEach((value, index) => {
                        data[`transmissions[${index}]`] = value;
                    });
                }

                if (fuel_types.length > 0) {
                    fuel_types.forEach((value, index) => {
                        data[`fuel_types[${index}]`] = value;
                    });
                }

                // Make AJAX request to filter cars
                $.ajax({
                    url: "{{ route('cars.filter') }}",
                    type: "GET",
                    data: data,
                    success: function(response) {
                        console.log("Filter success response:", response);
                        updateCarsGrid(response.cars);
                        $("#carCount").text(response.count);
                    },
                    error: function(xhr, status, error) {
                        console.error("Filter error:", error);
                        console.error("Response:", xhr.responseText);
                        $("#carsGrid").html(
                            '<div class="col-12 text-center py-5"><div class="alert alert-danger">Error loading cars. Please try again.</div></div>'
                        );
                    }
                });
            }

            // Function to update cars grid with filtered results
            function updateCarsGrid(cars) {
                console.log("Cars data received:", cars);

                if (!cars || cars.length === 0) {
                    $("#carsGrid").html(
                        '<div class="col-12 text-center py-5"><div class="alert alert-info">No cars found matching your criteria. Try adjusting your filters.</div></div>'
                    );
                    return;
                }

                let html = '';

                cars.forEach(car => {
                    html += `
                    <div class="col-md-6 col-lg-4">
                        <div class="card car-card shadow-sm h-100">
                            <div class="car-image-container">
                                <img src="${car.image_url}" class="car-image" alt="${car.name}">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">${car.name}</h5>
                                <p class="card-text text-muted mb-2">${car.category} • ${car.year}</p>

                                <div class="car-spec">
                                    <i class="bi bi-gear-fill"></i>
                                    <span>${car.transmission}</span>
                                </div>
                                <div class="car-spec">
                                    <i class="bi bi-fuel-pump-fill"></i>
                                    <span>${car.fuel_type}</span>
                                </div>
                                <div class="car-spec">
                                    <i class="bi bi-people-fill"></i>
                                    <span>${car.seats} Seats</span>
                                </div>

                                <div class="mt-3">
                                    <h5 class="text-primary mb-0">$${parseFloat(car.price_per_day).toFixed(2)} / day</h5>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-top-0">
                                <a href="/cars/${car.id}" class="btn btn-primary w-100">View Details</a>
                            </div>
                        </div>
                    </div>`;
                });

                $("#carsGrid").html(html);
            }
        });
    </script>
@endsection
