@extends('layouts.app')

@section('title', 'Create Reservation')

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .car-image {
            height: 300px;
            object-fit: cover;
            border-radius: 8px;
        }

        .reservation-form {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
        }

        .car-details {
            transition: all 0.3s;
        }

        .car-details:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .feature-icon {
            width: 32px;
            height: 32px;
            background-color: #e9ecef;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
        }

        .feature-icon i {
            color: var(--primary-color);
        }

        /* Time selection styles */
        .time-selects {
            display: flex;
            align-items: center;
        }

        .time-selects select {
            border-radius: 0 0.375rem 0.375rem 0;
        }

        .time-separator {
            margin: 0 5px;
            font-weight: bold;
        }

        /* Additional options styles */
        .addon-option {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 15px;
            margin-bottom: 10px;
            transition: all 0.2s;
        }

        .addon-option:hover {
            background-color: #f8f9fa;
        }

        .addon-option.selected {
            border-color: var(--primary-color);
            background-color: rgba(var(--primary-rgb), 0.05);
        }

        .addon-option .form-check-input {
            margin-top: 0.2rem;
        }

        .addon-icon {
            font-size: 1.25rem;
            margin-right: 10px;
            color: #6c757d;
        }

        .addon-option.selected .addon-icon {
            color: var(--primary-color);
        }

        /* Add this to your existing styles */
        #addon-fees {
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .addon-fee {
            display: flex;
            justify-content: space-between;
            opacity: 0;
            max-height: 0;
            overflow: hidden;
            transition: opacity 0.3s ease, max-height 0.3s ease, margin-bottom 0.3s ease;
        }

        .addon-fee.visible {
            opacity: 1;
            max-height: 50px;
            /* Adjust based on your content */
            margin-bottom: 0.5rem;
        }
    </style>
@endsection

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-12 mb-4">
                <h1>Rent a Car</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cars.index') }}">Cars</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cars.show', $car) }}">{{ $car->brand }}
                                {{ $car->model }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">New Reservation</li>
                    </ol>
                </nav>
            </div>

            <!-- Car Details Section -->
            <div class="col-lg-5 mb-4">
                <div class="card shadow-sm car-details h-100">
                    <div class="card-body">
                        <h5 class="card-title">Selected Vehicle</h5>
                        <hr>
                        <div class="text-center mb-3">
                            <img src="{{ asset($car->image) }}" class="car-image img-fluid"
                                alt="{{ $car->brand }} {{ $car->model }}">
                        </div>
                        <h4 class="mt-3">{{ $car->brand }} {{ $car->model }} ({{ $car->year }})</h4>
                        <p class="text-muted">{{ $car->description }}</p>

                        <div class="mt-4">
                            <h5>Car Specifications</h5>
                            <div class="d-flex align-items-center mb-2">
                                <div class="feature-icon">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                                <div>
                                    <strong>Price:</strong> ${{ number_format($car->price_per_day, 2) }} per day
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="feature-icon">
                                    <i class="fas fa-gas-pump"></i>
                                </div>
                                <div>
                                    <strong>Fuel Type:</strong> {{ ucfirst($car->fuel_type) }}
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="feature-icon">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <div>
                                    <strong>Transmission:</strong> {{ ucfirst($car->transmission) }}
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="feature-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <strong>Seats:</strong> {{ $car->seats }} passengers
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reservation Form Section -->
            <div class="col-lg-7">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Reservation Details</h5>
                        <hr>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('client.reservations.store', $car) }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Pickup Date & Time -->
                                <div class="col-md-6 mb-3">
                                    <label for="date_debut" class="form-label">Pick-up Date & Time</label>
                                    <div class="mb-2">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            <input type="text" class="form-control" id="date_debut" name="date_debut"
                                                placeholder="Select date" value="{{ $startDate ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="time-selects">
                                        <select class="form-select" id="pickup_hour" name="pickup_hour">
                                            @for ($i = 8; $i <= 20; $i++)
                                                <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}
                                                </option>
                                            @endfor
                                        </select>
                                        <span class="time-separator">:</span>
                                        <select class="form-select" id="pickup_minute" name="pickup_minute">
                                            <option value="00">00</option>
                                            <option value="15">15</option>
                                            <option value="30">30</option>
                                            <option value="45">45</option>
                                        </select>
                                    </div>
                                    <small class="form-text text-muted">Pickup available from 8:00 AM to 8:00 PM</small>
                                </div>

                                <!-- Return Date & Time -->
                                <div class="col-md-6 mb-3">
                                    <label for="date_fin" class="form-label">Return Date & Time</label>
                                    <div class="mb-2">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            <input type="text" class="form-control" id="date_fin" name="date_fin"
                                                placeholder="Select date" value="{{ $endDate ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="time-selects">
                                        <select class="form-select" id="return_hour" name="return_hour">
                                            @for ($i = 8; $i <= 20; $i++)
                                                <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}
                                                </option>
                                            @endfor
                                        </select>
                                        <span class="time-separator">:</span>
                                        <select class="form-select" id="return_minute" name="return_minute">
                                            <option value="00">00</option>
                                            <option value="15">15</option>
                                            <option value="30">30</option>
                                            <option value="45">45</option>
                                        </select>
                                    </div>
                                    <small class="form-text text-muted">Return available from 8:00 AM to 8:00 PM</small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="pickup_location" class="form-label">Pick-up Location</label>
                                    <select class="form-select" id="pickup_location" name="pickup_location" required>
                                        <option value="">Select location</option>
                                        <option value="Main Office">Main Office</option>
                                        <option value="Airport">Airport Terminal</option>
                                        <option value="Downtown">Your Location</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="return_location" class="form-label">Return Location</label>
                                    <select class="form-select" id="return_location" name="return_location" required>
                                        <option value="">Select location</option>
                                        <option value="Main Office">Main Office</option>
                                        <option value="Airport">Airport Terminal</option>
                                        <option value="Downtown">Your Location</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Additional Options Section -->
                            <div class="mt-4 mb-4">
                                <h5>Additional Options</h5>
                                <p class="text-muted small">Enhance your rental experience with these additional services
                                </p>

                                <div class="row">
                                    <!-- GPS Navigation -->
                                    <div class="col-md-6 mb-3">
                                        <div class="addon-option d-flex align-items-start" onclick="toggleAddon('gps')">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    id="gps" name="add_gps">
                                            </div>
                                            <div class="ms-2">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-map-marker-alt addon-icon"></i>
                                                    <label class="form-check-label fw-bold" for="gps">
                                                        GPS Navigation
                                                    </label>
                                                </div>
                                                <div class="text-muted small mt-1">
                                                    Never get lost with built-in GPS navigation system
                                                </div>
                                                <div class="addon-price mt-2">$15.00 per rental</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Wi-Fi Hotspot -->
                                    <div class="col-md-6 mb-3">
                                        <div class="addon-option d-flex align-items-start" onclick="toggleAddon('wifi')">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    id="wifi" name="add_wifi">
                                            </div>
                                            <div class="ms-2 w-100">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-wifi addon-icon"></i>
                                                    <label class="form-check-label fw-bold" for="wifi">
                                                        Wi-Fi Hotspot
                                                    </label>
                                                </div>
                                                <div class="text-muted small mt-1">
                                                    Stay connected with 4G LTE Wi-Fi for all your devices
                                                </div>
                                                <div class="d-flex align-items-center mt-2">
                                                    <span class="me-2">$1.50 per GB:</span>
                                                    <div class="input-group" style="width: 120px;"
                                                        onclick="event.stopPropagation();">
                                                        <button type="button" class="btn btn-outline-secondary btn-sm"
                                                            onclick="decrementWifi(event)">-</button>
                                                        <input type="number"
                                                            class="form-control form-control-sm text-center"
                                                            id="wifi_gb" name="wifi_gb" min="1" max="50"
                                                            value="5" onclick="event.stopPropagation();">
                                                        <button type="button" class="btn btn-outline-secondary btn-sm"
                                                            onclick="incrementWifi(event)">+</button>
                                                    </div>
                                                    <span class="ms-1">GB</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Full Fuel Tank -->
                                    <div class="col-md-6 mb-3">
                                        <div class="addon-option d-flex align-items-start" onclick="toggleAddon('fuel')">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    id="fuel" name="add_fuel">
                                            </div>
                                            <div class="ms-2">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-gas-pump addon-icon"></i>
                                                    <label class="form-check-label fw-bold" for="fuel">
                                                        Full Fuel Tank
                                                    </label>
                                                </div>
                                                <div class="text-muted small mt-1">
                                                    Return the car with any fuel level without additional fees
                                                </div>
                                                <div class="addon-price mt-2">$25.00 flat fee</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Baby Seat -->
                                    <div class="col-md-6 mb-3">
                                        <div class="addon-option d-flex align-items-start"
                                            onclick="toggleAddon('baby_seat')">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    id="baby_seat" name="add_baby_seat">
                                            </div>
                                            <div class="ms-2">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-baby addon-icon"></i>
                                                    <label class="form-check-label fw-bold" for="baby_seat">
                                                        Baby Seat
                                                    </label>
                                                </div>
                                                <div class="text-muted small mt-1">
                                                    Safe and comfortable certified child safety seat
                                                </div>
                                                <div class="addon-price mt-2">$20.00 per rental</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4" id="price-calculation">
                                <h5>Price Calculation</h5>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Daily Rate:</span>
                                            <span>${{ number_format($car->price_per_day, 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Rental Period:</span>
                                            <span id="rental-period">{{ $days ?? 0 }} days</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Pickup Location Fee:</span>
                                            <span id="pickup-fee">$0.00</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Return Location Fee:</span>
                                            <span id="return-fee">$0.00</span>
                                        </div>

                                        <!-- Additional options fees -->
                                        <div id="addon-fees" style="margin-top: 1rem;">
                                            <div class="fw-bold mb-2" id="addon-options-header" style="display: none;">
                                                Additional Options:
                                            </div>
                                            <div class="addon-fee" id="gps-fee-row">
                                                <span>GPS Navigation:</span>
                                                <span id="gps-fee">$0.00</span>
                                            </div>
                                            <div class="addon-fee" id="wifi-fee-row">
                                                <span>Wi-Fi Hotspot:</span>
                                                <span id="wifi-fee">$0.00</span>
                                            </div>
                                            <div class="addon-fee" id="fuel-fee-row">
                                                <span>Full Fuel Tank:</span>
                                                <span id="fuel-fee">$0.00</span>
                                            </div>
                                            <div class="addon-fee" id="baby-seat-fee-row">
                                                <span>Baby Seat:</span>
                                                <span id="baby-seat-fee">$0.00</span>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="d-flex justify-content-between fw-bold">
                                            <span>Total Price:</span>
                                            <span
                                                id="total-price">${{ isset($totalPrice) ? number_format($totalPrice, 2) : '0.00' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 small text-muted">
                                    <i class="fas fa-info-circle"></i> A displacement fee of $7.00 is applied for each
                                    pickup or return at locations other than the Main Office.
                                </div>
                                <input type="hidden" name="prix_total" id="prix_total" value="{{ $totalPrice ?? 0 }}">
                                <input type="hidden" name="pickup_fee" id="pickup_fee_input" value="0">
                                <input type="hidden" name="return_fee" id="return_fee_input" value="0">
                                <input type="hidden" name="date_debut_time" id="date_debut_time">
                                <input type="hidden" name="date_fin_time" id="date_fin_time">
                                <input type="hidden" name="gps_fee" id="gps_fee_input" value="0">
                                <input type="hidden" name="wifi_fee" id="wifi_fee_input" value="0">
                                <input type="hidden" name="fuel_fee" id="fuel_fee_input" value="0">
                                <input type="hidden" name="baby_seat_fee" id="baby_seat_fee_input" value="0">
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">Continue to Payment</button>
                            </div>
                        </form>
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
            const pickupDatePicker = flatpickr("#date_debut", {
                enableTime: false,
                dateFormat: "Y-m-d",
                minDate: "today",
                onChange: calculatePrice
            });

            const returnDatePicker = flatpickr("#date_fin", {
                enableTime: false,
                dateFormat: "Y-m-d",
                minDate: "today",
                onChange: calculatePrice
            });

            // Hour and minute selectors
            const pickupHourSelect = document.getElementById('pickup_hour');
            const pickupMinuteSelect = document.getElementById('pickup_minute');
            const returnHourSelect = document.getElementById('return_hour');
            const returnMinuteSelect = document.getElementById('return_minute');

            // Set default hours (e.g., 10:00 AM for pickup and 2:00 PM for return)
            pickupHourSelect.value = '10';
            pickupMinuteSelect.value = '00';
            returnHourSelect.value = '14';
            returnMinuteSelect.value = '00';

            // Add event listeners for time changes
            pickupHourSelect.addEventListener('change', calculatePrice);
            pickupMinuteSelect.addEventListener('change', calculatePrice);
            returnHourSelect.addEventListener('change', calculatePrice);
            returnMinuteSelect.addEventListener('change', calculatePrice);

            // Location fee handlers
            const pickupLocationSelect = document.getElementById('pickup_location');
            const returnLocationSelect = document.getElementById('return_location');

            pickupLocationSelect.addEventListener('change', calculatePrice);
            returnLocationSelect.addEventListener('change', calculatePrice);

            // Additional options handlers
            const gpsCheckbox = document.getElementById('gps');
            const wifiCheckbox = document.getElementById('wifi');
            const fuelCheckbox = document.getElementById('fuel');
            const babySeatCheckbox = document.getElementById('baby_seat');

            gpsCheckbox.addEventListener('change', calculatePrice);
            wifiCheckbox.addEventListener('change', calculatePrice);
            fuelCheckbox.addEventListener('change', calculatePrice);
            babySeatCheckbox.addEventListener('change', calculatePrice);

            // Calculate price based on selected dates, times and locations
            function calculatePrice() {
                // Get date values
                const pickupDateStr = document.getElementById('date_debut').value;
                const returnDateStr = document.getElementById('date_fin').value;

                if (!pickupDateStr || !returnDateStr) return;

                // Get time values
                const pickupHour = pickupHourSelect.value;
                const pickupMinute = pickupMinuteSelect.value;
                const returnHour = returnHourSelect.value;
                const returnMinute = returnMinuteSelect.value;

                // Create full datetime objects
                const pickupDateTime = new Date(`${pickupDateStr}T${pickupHour}:${pickupMinute}:00`);
                const returnDateTime = new Date(`${returnDateStr}T${returnHour}:${returnMinute}:00`);

                // Set the hidden input values for form submission
                document.getElementById('date_debut_time').value =
                    `${pickupDateStr} ${pickupHour}:${pickupMinute}:00`;
                document.getElementById('date_fin_time').value =
                    `${returnDateStr} ${returnHour}:${returnMinute}:00`;

                // Calculate hours difference
                const diffHours = Math.abs(returnDateTime - pickupDateTime) /
                    36e5; // 36e5 is the number of milliseconds in an hour

                // Calculate days (round up to nearest day for partial days)
                const days = Math.ceil(diffHours / 24);

                // Ensure at least 1 day
                const rentalDays = Math.max(1, days);

                // Show rental period in days and hours
                const hoursFraction = diffHours % 24;
                let rentalPeriodText = `${rentalDays} day${rentalDays !== 1 ? 's' : ''}`;

                if (hoursFraction > 0) {
                    // If there's a partial day, show the hours
                    const extraHours = Math.round(hoursFraction);
                    if (extraHours > 0) {
                        rentalPeriodText += ` (${Math.floor(diffHours)} hours total)`;
                    }
                }

                document.getElementById('rental-period').textContent = rentalPeriodText;

                // Calculate base price
                const dailyRate = {{ $car->price_per_day }};
                let totalPrice = dailyRate * rentalDays;

                // Calculate location fees
                const pickupLocation = pickupLocationSelect.value;
                const returnLocation = returnLocationSelect.value;

                const pickupFee = (pickupLocation && pickupLocation !== 'Main Office') ? 7 : 0;
                const returnFee = (returnLocation && returnLocation !== 'Main Office') ? 7 : 0;

                // Update fee displays
                document.getElementById('pickup-fee').textContent = '$' + pickupFee.toFixed(2);
                document.getElementById('return-fee').textContent = '$' + returnFee.toFixed(2);

                // Update hidden inputs
                document.getElementById('pickup_fee_input').value = pickupFee;
                document.getElementById('return_fee_input').value = returnFee;

                // Calculate additional options fees
                // GPS - $15 per rental
                let gpsFee = 0;
                if (gpsCheckbox.checked) {
                    gpsFee = 15;
                    document.getElementById('gps-fee-row').classList.add('visible');
                    document.getElementById('gps-fee').textContent = '$' + gpsFee.toFixed(2);
                } else {
                    document.getElementById('gps-fee-row').classList.remove('visible');
                }
                document.getElementById('gps_fee_input').value = gpsFee;

                // Wi-Fi - $1.50 per GB
                let wifiFee = 0;
                if (wifiCheckbox.checked) {
                    const wifiGB = parseInt(document.getElementById('wifi_gb').value, 10);
                    wifiFee = 1.5 * wifiGB;
                    document.getElementById('wifi-fee-row').classList.add('visible');
                    document.getElementById('wifi-fee').textContent = '$' + wifiFee.toFixed(2) + ' (' + wifiGB +
                        ' GB)';
                } else {
                    document.getElementById('wifi-fee-row').classList.remove('visible');
                }
                document.getElementById('wifi_fee_input').value = wifiFee;

                // Full tank - flat $25 fee
                let fuelFee = 0;
                if (fuelCheckbox.checked) {
                    fuelFee = 25;
                    document.getElementById('fuel-fee-row').classList.add('visible');
                    document.getElementById('fuel-fee').textContent = '$' + fuelFee.toFixed(2);
                } else {
                    document.getElementById('fuel-fee-row').classList.remove('visible');
                }
                document.getElementById('fuel_fee_input').value = fuelFee;

                // Baby seat - $20 per rental
                let babySeatFee = 0;
                if (babySeatCheckbox.checked) {
                    babySeatFee = 20;
                    document.getElementById('baby-seat-fee-row').classList.add('visible');
                    document.getElementById('baby-seat-fee').textContent = '$' + babySeatFee.toFixed(2);
                } else {
                    document.getElementById('baby-seat-fee-row').classList.remove('visible');
                }
                document.getElementById('baby_seat_fee_input').value = babySeatFee;

                // Add all fees to total
                totalPrice += pickupFee + returnFee + gpsFee + wifiFee + fuelFee + babySeatFee;

                // Update total price
                document.getElementById('total-price').textContent = '$' + totalPrice.toFixed(2);
                document.getElementById('prix_total').value = totalPrice.toFixed(2);

                // Update the visibility of the addon fees section
                updateAddonFeesSectionVisibility();
            }

            // Function to toggle addon selection
            window.toggleAddon = function(id) {
                const checkbox = document.getElementById(id);
                checkbox.checked = !checkbox.checked;

                // Update visual style
                const addonDiv = checkbox.closest('.addon-option');
                if (checkbox.checked) {
                    addonDiv.classList.add('selected');
                } else {
                    addonDiv.classList.remove('selected');
                }

                calculatePrice();
            };

            // Function to increment Wi-Fi GB
            window.incrementWifi = function(event) {
                event.stopPropagation();
                const wifiGBInput = document.getElementById('wifi_gb');
                let wifiGB = parseInt(wifiGBInput.value, 10);
                if (wifiGB < 50) {
                    wifiGBInput.value = wifiGB + 1;
                    calculatePrice();
                }
            };

            // Function to decrement Wi-Fi GB
            window.decrementWifi = function(event) {
                event.stopPropagation();
                const wifiGBInput = document.getElementById('wifi_gb');
                let wifiGB = parseInt(wifiGBInput.value, 10);
                if (wifiGB > 1) {
                    wifiGBInput.value = wifiGB - 1;
                    calculatePrice();
                }
            };

            // Calculate initial price if dates are pre-filled
            calculatePrice();

            // Form submission validation
            document.querySelector('form').addEventListener('submit', function(e) {
                const pickupDateStr = document.getElementById('date_debut').value;
                const returnDateStr = document.getElementById('date_fin').value;
                const pickupHour = pickupHourSelect.value;
                const pickupMinute = pickupMinuteSelect.value;
                const returnHour = returnHourSelect.value;
                const returnMinute = returnMinuteSelect.value;

                // Create full datetime objects
                const pickupDateTime = new Date(`${pickupDateStr}T${pickupHour}:${pickupMinute}:00`);
                const returnDateTime = new Date(`${returnDateStr}T${returnHour}:${returnMinute}:00`);

                // Check if return time is after pickup time
                if (returnDateTime <= pickupDateTime) {
                    e.preventDefault();
                    alert('Return date and time must be after pickup date and time.');
                }
            });

            // Check if any addon is selected and show/hide the addon-fees section
            function updateAddonFeesSectionVisibility() {
                const addonFeesSection = document.getElementById('addon-fees');

                // Check if any addon is selected
                if (gpsCheckbox.checked || wifiCheckbox.checked || fuelCheckbox.checked || babySeatCheckbox
                    .checked) {
                    addonFeesSection.style.display = 'block';
                } else {
                    addonFeesSection.style.display = 'none';
                }
            }

            // Check if any addon is selected and show/hide the addon-fees header
            function updateAddonFeesSectionVisibility() {
                const addonOptionsHeader = document.getElementById('addon-options-header');

                // Check if any addon is selected
                if (gpsCheckbox.checked || wifiCheckbox.checked || fuelCheckbox.checked || babySeatCheckbox
                    .checked) {
                    addonOptionsHeader.style.display = 'block';
                } else {
                    addonOptionsHeader.style.display = 'none';
                }
            }
        });
    </script>
@endsection
