@extends('layouts.app')

@section('title', 'New Reservation')

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .car-image {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .car-card {
            transition: all 0.3s;
            cursor: pointer;
        }

        .car-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .car-card.selected {
            border: 2px solid var(--primary-color);
        }

        .car-features {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .car-feature {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
@endsection

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">Book a Car</h2>

                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-calendar-date me-2"></i>Reservation Details</h5>
                        <hr>

                        <form action="{{ route('reservations.store') }}" method="POST" id="reservationForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="pickup_date" class="form-label">Pickup Date & Time</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                        <input type="text" class="form-control" id="pickup_date" name="pickup_date"
                                            placeholder="Select date and time" required>
                                    </div>
                                    @error('pickup_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="return_date" class="form-label">Return Date & Time</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                        <input type="text" class="form-control" id="return_date" name="return_date"
                                            placeholder="Select date and time" required>
                                    </div>
                                    @error('return_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="pickup_location" class="form-label">Pickup Location</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                        <select class="form-select" id="pickup_location" name="pickup_location" required>
                                            <option value="">Select location</option>
                                            @foreach ($locations ?? [] as $location)
                                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('pickup_location')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="return_location" class="form-label">Return Location</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                        <select class="form-select" id="return_location" name="return_location" required>
                                            <option value="">Select location</option>
                                            @foreach ($locations ?? [] as $location)
                                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('return_location')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                                <button type="button" id="checkAvailability" class="btn btn-primary">
                                    <i class="bi bi-search me-2"></i>Check Availability
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="availableCars" class="mt-4" style="display: none;">
                    <h3 class="mb-3">Available Cars</h3>
                    <div class="row" id="carList">
                        <!-- Car items will be loaded here -->
                    </div>
                </div>

                <div id="bookingDetails" class="card shadow-sm mt-4" style="display: none;">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-receipt me-2"></i>Booking Summary</h5>
                        <hr>

                        <div class="row">
                            <div class="col-md-8">
                                <div id="selectedCarDetails">
                                    <!-- Selected car details will appear here -->
                                </div>

                                <div class="mt-4">
                                    <h6>Rental Period</h6>
                                    <p><strong>Pickup:</strong> <span id="summaryPickupDate"></span> at <span
                                            id="summaryPickupLocation"></span></p>
                                    <p><strong>Return:</strong> <span id="summaryReturnDate"></span> at <span
                                            id="summaryReturnLocation"></span></p>
                                    <p><strong>Duration:</strong> <span id="summaryDuration"></span></p>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">Price Details</h6>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Base Rate:</span>
                                            <span id="baseRate">$0.00</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Insurance:</span>
                                            <span id="insurance">$0.00</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Taxes & Fees:</span>
                                            <span id="taxes">$0.00</span>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between fw-bold">
                                            <span>Total:</span>
                                            <span id="totalPrice">$0.00</span>
                                        </div>
                                    </div>
                                </div>

                                <form action="{{ route('reservations.store') }}" method="POST" class="mt-3">
                                    @csrf
                                    <input type="hidden" name="car_id" id="car_id">
                                    <input type="hidden" name="pickup_date" id="form_pickup_date">
                                    <input type="hidden" name="return_date" id="form_return_date">
                                    <input type="hidden" name="pickup_location" id="form_pickup_location">
                                    <input type="hidden" name="return_location" id="form_return_location">
                                    <input type="hidden" name="total_price" id="form_total_price">

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="bi bi-check-circle me-2"></i>Confirm Booking
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize date pickers
            flatpickr("#pickup_date", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                minDate: "today",
                defaultHour: 10
            });

            flatpickr("#return_date", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                minDate: "today",
                defaultHour: 10
            });

            // Check availability button click handler
            document.getElementById('checkAvailability').addEventListener('click', function() {
                // This would normally be an AJAX call to the server
                // For now, we'll just show some sample cars
                document.getElementById('availableCars').style.display = 'block';

                // Sample car data - in a real app, this would come from the server
                const cars = [{
                        id: 1,
                        name: 'Toyota Camry',
                        image: '/images/cars/camry.jpg',
                        price: 45,
                        year: 2023,
                        fuel: 'Gasoline',
                        transmission: 'Automatic',
                        seats: 5,
                        luggage: 3
                    },
                    {
                        id: 2,
                        name: 'Honda Civic',
                        image: '/images/cars/civic.jpg',
                        price: 40,
                        year: 2022,
                        fuel: 'Gasoline',
                        transmission: 'Automatic',
                        seats: 5,
                        luggage: 2
                    },
                    {
                        id: 3,
                        name: 'Mercedes-Benz E-Class',
                        image: '/images/slideshow/mercidice.jpeg',
                        price: 85,
                        year: 2023,
                        fuel: 'Hybrid',
                        transmission: 'Automatic',
                        seats: 5,
                        luggage: 4
                    }
                ];

                const carList = document.getElementById('carList');
                carList.innerHTML = '';

                // Generate the HTML for each car
                cars.forEach(car => {
                    const carCard = document.createElement('div');
                    carCard.className = 'col-md-4 mb-4';
                    carCard.innerHTML = `
                    <div class="card car-card shadow-sm" data-car-id="${car.id}" data-car-name="${car.name}" data-car-price="${car.price}">
                        <img src="${car.image}" class="card-img-top car-image" alt="${car.name}">
                        <div class="card-body">
                            <h5 class="card-title">${car.name}</h5>
                            <p class="text-primary fw-bold">$${car.price} / day</p>
                            <div class="car-features">
                                <div class="car-feature"><i class="bi bi-calendar-event"></i> ${car.year}</div>
                                <div class="car-feature"><i class="bi bi-fuel-pump"></i> ${car.fuel}</div>
                                <div class="car-feature"><i class="bi bi-gear"></i> ${car.transmission}</div>
                            </div>
                            <div class="car-features">
                                <div class="car-feature"><i class="bi bi-people"></i> ${car.seats} Seats</div>
                                <div class="car-feature"><i class="bi bi-briefcase"></i> ${car.luggage} Luggage</div>
                            </div>
                        </div>
                    </div>
                `;
                    carList.appendChild(carCard);

                    // Add click event to select a car
                    carCard.querySelector('.car-card').addEventListener('click', function() {
                        // Remove selected class from all cars
                        document.querySelectorAll('.car-card').forEach(card => {
                            card.classList.remove('selected');
                        });

                        // Add selected class to the clicked car
                        this.classList.add('selected');

                        // Show booking details section
                        document.getElementById('bookingDetails').style.display = 'block';

                        // Calculate rental details
                        const pickupDate = new Date(document.getElementById('pickup_date')
                            .value);
                        const returnDate = new Date(document.getElementById('return_date')
                            .value);
                        const days = Math.ceil((returnDate - pickupDate) / (1000 * 60 * 60 *
                            24));

                        // Update form fields
                        document.getElementById('car_id').value = car.id;
                        document.getElementById('form_pickup_date').value = document
                            .getElementById('pickup_date').value;
                        document.getElementById('form_return_date').value = document
                            .getElementById('return_date').value;
                        document.getElementById('form_pickup_location').value = document
                            .getElementById('pickup_location').value;
                        document.getElementById('form_return_location').value = document
                            .getElementById('return_location').value;

                        // Update summary details
                        const pickupLocationText = document.getElementById(
                            'pickup_location').options[document.getElementById(
                            'pickup_location').selectedIndex].text;
                        const returnLocationText = document.getElementById(
                            'return_location').options[document.getElementById(
                            'return_location').selectedIndex].text;

                        document.getElementById('summaryPickupDate').textContent =
                            formatDate(pickupDate);
                        document.getElementById('summaryPickupLocation').textContent =
                            pickupLocationText;
                        document.getElementById('summaryReturnDate').textContent =
                            formatDate(returnDate);
                        document.getElementById('summaryReturnLocation').textContent =
                            returnLocationText;
                        document.getElementById('summaryDuration').textContent = days + (
                            days === 1 ? ' day' : ' days');

                        // Update selected car details
                        document.getElementById('selectedCarDetails').innerHTML = `
                        <h6>Selected Vehicle</h6>
                        <div class="d-flex align-items-center">
                            <img src="${car.image}" alt="${car.name}" style="width: 100px; height: 60px; object-fit: cover; border-radius: 4px;">
                            <div class="ms-3">
                                <h5 class="mb-0">${car.name}</h5>
                                <div class="d-flex mt-1">
                                    <span class="badge bg-light text-dark me-2"><i class="bi bi-people"></i> ${car.seats} Seats</span>
                                    <span class="badge bg-light text-dark me-2"><i class="bi bi-gear"></i> ${car.transmission}</span>
                                    <span class="badge bg-light text-dark"><i class="bi bi-fuel-pump"></i> ${car.fuel}</span>
                                </div>
                            </div>
                        </div>
                    `;

                        // Calculate and update price details
                        const baseRate = car.price * days;
                        const insurance = baseRate * 0.1; // 10% of base rate
                        const taxes = baseRate * 0.05; // 5% of base rate
                        const totalPrice = baseRate + insurance + taxes;

                        document.getElementById('baseRate').textContent = '$' + baseRate
                            .toFixed(2);
                        document.getElementById('insurance').textContent = '$' + insurance
                            .toFixed(2);
                        document.getElementById('taxes').textContent = '$' + taxes.toFixed(
                            2);
                        document.getElementById('totalPrice').textContent = '$' + totalPrice
                            .toFixed(2);
                        document.getElementById('form_total_price').value = totalPrice
                            .toFixed(2);
                    });
                });
            });

            // Helper function to format dates
            function formatDate(date) {
                const options = {
                    weekday: 'short',
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                };
                return date.toLocaleDateString('en-US', options);
            }
        });
    </script>
@endsection
