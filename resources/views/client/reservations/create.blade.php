@extends('layouts.app')

@section('title', 'New Reservation')

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
        
        /* Accessory item styling */
        #additional-options-fees {
            font-size: 0.95rem;
            color: #6c757d;
            transition: all 0.3s ease;
        }
        
        #additional-options-fees .d-flex {
            padding: 3px 0;
            border-bottom: 1px dotted #e9ecef;
        }
        
        #additional-options-fees .d-flex:last-child {
            border-bottom: none;
        }
        
        #accessories-subtotal {
            border-left: 3px solid #28a745;
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
                        <li class="breadcrumb-item"><a href="{{ route('cars.show', $car) }}">{{ $car->marque }} {{ $car->model }}</a></li>
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
                            <img src="{{ $car->image ? asset('images/cars/' . $car->image) : asset('images/no-image.jpg') }}" 
                                 class="car-image img-fluid" alt="{{ $car->marque }} {{ $car->model }}">
                        </div>
                        <h4 class="mt-3">{{ $car->marque }} {{ $car->model }} ({{ $car->year }})</h4>
                        <p class="text-muted">{{ $car->description }}</p>
                        
                        <div class="mt-4">
                            <h5>Car Specifications</h5>
                            <div class="d-flex align-items-center mb-2">
                                <div class="feature-icon">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                                <div>
                                    <strong>Price:</strong> ${{ number_format($car->prix_journalier, 2) }} per day
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
                                <div class="col-md-6 mb-3">
                                    <label for="date_debut" class="form-label">Pick-up Date</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="text" class="form-control" id="date_debut" name="date_debut" 
                                               placeholder="Select date" value="{{ $startDate ?? '' }}" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="date_fin" class="form-label">Return Date</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="text" class="form-control" id="date_fin" name="date_fin" 
                                               placeholder="Select date" value="{{ $endDate ?? '' }}" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="pickup_location" class="form-label">Pick-up Location</label>
                                    <select class="form-select" id="pickup_location" name="pickup_location" required>
                                        <option value="">Select location</option>
                                        <option value="Main Office">Main Office - 123 Main St</option>
                                        <option value="Airport">Airport Terminal</option>
                                        <option value="Downtown">Downtown Branch - 456 City Center</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="return_location" class="form-label">Return Location</label>
                                    <select class="form-select" id="return_location" name="return_location" required>
                                        <option value="">Select location</option>
                                        <option value="Main Office">Main Office - 123 Main St</option>
                                        <option value="Airport">Airport Terminal</option>
                                        <option value="Downtown">Downtown Branch - 456 City Center</option>
                                    </select>
                                </div>

                                <!-- Additional Options Section -->
                                <div class="col-12 mt-2">
                                    <h5 class="mb-3">Additional Options</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" id="gps" name="add_gps" value="1">
                                                <label class="form-check-label d-flex justify-content-between" for="gps">
                                                    <span><i class="fas fa-map-marker-alt me-2"></i> GPS Navigation</span>
                                                    <span class="fw-bold">$20/rental</span>
                                                </label>
                                                <div class="form-text">Never get lost with our GPS navigation system</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" id="wifi" name="add_wifi" value="1">
                                                <label class="form-check-label d-flex justify-content-between" for="wifi">
                                                    <span><i class="fas fa-wifi me-2"></i> In-car WiFi</span>
                                                    <span class="fw-bold">$2/day</span>
                                                </label>
                                                <div class="form-text">Stay connected during your trip</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" id="baby_seat" name="add_baby_seat" value="1">
                                                <label class="form-check-label d-flex justify-content-between" for="baby_seat">
                                                    <span><i class="fas fa-baby me-2"></i> Baby/Child Seat</span>
                                                    <span class="fw-bold">$10/rental</span>
                                                </label>
                                                <div class="form-text">Safety first for your little ones</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" id="full_tank" name="add_full_tank" value="1">
                                                <label class="form-check-label d-flex justify-content-between" for="full_tank">
                                                    <span><i class="fas fa-gas-pump me-2"></i> Full Fuel Tank</span>
                                                    <span class="fw-bold">$45</span>
                                                </label>
                                                <div class="form-text">Skip the gas station on return</div>
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
                                            <span>${{ number_format($car->prix_journalier, 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Number of Days:</span>
                                            <span id="duration">{{ $days ?? 0 }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Pickup Location Fee:</span>
                                            <span id="pickup-fee">$0.00</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Return Location Fee:</span>
                                            <span id="return-fee">$0.00</span>
                                        </div>
                                        <div id="accessories-subtotal" class="d-flex justify-content-between mb-2" style="display: none; padding: 8px; background-color: #f8f9fa; border-radius: 5px; margin-top: 10px;">
                                            <span><strong>Accessories Subtotal:</strong></span>
                                            <span class="text-success" id="accessories-total">$0.00</span>
                                        </div>
                                        <div id="additional-options-fees" style="padding-left: 15px; margin-top: 5px; border-left: 2px solid #e9ecef;">
                                            <!-- Additional fees will be added dynamically here -->
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between fw-bold">
                                            <span>Total Price:</span>
                                            <span id="total-price">${{ isset($totalPrice) ? number_format($totalPrice, 2) : '0.00' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 small text-muted">
                                    <i class="fas fa-info-circle"></i> A displacement fee of $7.00 is applied for each pickup or return at locations other than the Main Office.
                                </div>
                                <div id="price-summary" class="mt-2 alert alert-info" style="display:none;">
                                    <i class="fas fa-info-circle"></i> <span id="price-summary-text"></span>
                                </div>
                                <input type="hidden" name="prix_total" id="prix_total" value="{{ $totalPrice ?? 0 }}">
                                <input type="hidden" name="pickup_fee" id="pickup_fee_input" value="0">
                                <input type="hidden" name="return_fee" id="return_fee_input" value="0">
                                <input type="hidden" name="accessories_fee" id="accessories_fee_input" value="0">
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
            
            // Location fee handlers
            const pickupLocationSelect = document.getElementById('pickup_location');
            const returnLocationSelect = document.getElementById('return_location');
            
            pickupLocationSelect.addEventListener('change', calculatePrice);
            returnLocationSelect.addEventListener('change', calculatePrice);
            
            // Initialize option change listeners
            const gpsCheckbox = document.getElementById('gps');
            const wifiCheckbox = document.getElementById('wifi');
            const babySeatCheckbox = document.getElementById('baby_seat');
            const fullTankCheckbox = document.getElementById('full_tank');
            
            // Add click event listeners to all checkboxes for immediate feedback
            gpsCheckbox.addEventListener('change', function() {
                highlightCheckboxLabel(this);
                calculatePrice();
            });
            
            wifiCheckbox.addEventListener('change', function() {
                highlightCheckboxLabel(this);
                calculatePrice();
            });
            
            babySeatCheckbox.addEventListener('change', function() {
                highlightCheckboxLabel(this);
                calculatePrice();
            });
            
            fullTankCheckbox.addEventListener('change', function() {
                highlightCheckboxLabel(this);
                calculatePrice();
            });
            
            // Function to provide visual feedback when an option is selected
            function highlightCheckboxLabel(checkbox) {
                const label = checkbox.nextElementSibling;
                if (checkbox.checked) {
                    label.classList.add('text-primary');
                    label.style.transition = 'all 0.2s';
                    label.style.transform = 'scale(1.05)';
                    setTimeout(() => {
                        label.style.transform = 'scale(1)';
                    }, 200);
                } else {
                    label.classList.remove('text-primary');
                }
            }
            
            // Calculate price based on selected dates and locations
            function calculatePrice() {
                const pickupDate = new Date(document.getElementById('date_debut').value);
                const returnDate = new Date(document.getElementById('date_fin').value);
                
                // Calculate base price from dates
                let totalPrice = 0;
                let days = 0;
                
                if (pickupDate && returnDate && pickupDate < returnDate) {
                    // Calculate days difference
                    const diffTime = Math.abs(returnDate - pickupDate);
                    days = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    
                    // Update days
                    document.getElementById('duration').textContent = days;
                    
                    // Calculate base price
                    const dailyRate = {{ $car->prix_journalier }};
                    totalPrice = dailyRate * days;
                }
                
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
                let additionalFees = 0;
                let additionalFeesHtml = '';
                
                if (gpsCheckbox.checked) {
                    const gpsFee = 20; // flat fee per rental
                    additionalFees += gpsFee;
                    additionalFeesHtml += `
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-map-marker-alt text-muted me-1"></i> GPS Navigation (flat fee):</span>
                            <span>$${gpsFee.toFixed(2)}</span>
                        </div>
                    `;
                }
                
                if (wifiCheckbox.checked) {
                    const wifiFee = 2 * days;
                    additionalFees += wifiFee;
                    additionalFeesHtml += `
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-wifi text-muted me-1"></i> In-car WiFi ($2/day):</span>
                            <span>$${wifiFee.toFixed(2)}</span>
                        </div>
                    `;
                }
                
                if (babySeatCheckbox.checked) {
                    const babySeatFee = 10;
                    additionalFees += babySeatFee;
                    additionalFeesHtml += `
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-baby text-muted me-1"></i> Baby/Child Seat:</span>
                            <span>$${babySeatFee.toFixed(2)}</span>
                        </div>
                    `;
                }
                
                if (fullTankCheckbox.checked) {
                    const fullTankFee = 45;
                    additionalFees += fullTankFee;
                    additionalFeesHtml += `
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-gas-pump text-muted me-1"></i> Full Fuel Tank:</span>
                            <span>$${fullTankFee.toFixed(2)}</span>
                        </div>
                    `;
                }
                
                document.getElementById('additional-options-fees').innerHTML = additionalFeesHtml;
                
                // Show or hide accessories subtotal
                const accessoriesSubtotal = document.getElementById('accessories-subtotal');
                const additionalOptionsFeesDiv = document.getElementById('additional-options-fees');
                
                if (additionalFees > 0) {
                    accessoriesSubtotal.style.display = 'flex';
                    additionalOptionsFeesDiv.style.display = 'block';
                    document.getElementById('accessories-total').textContent = '$' + additionalFees.toFixed(2);
                } else {
                    accessoriesSubtotal.style.display = 'none';
                    additionalOptionsFeesDiv.style.display = 'none';
                }
                
                // Update accessories fee hidden input
                document.getElementById('accessories_fee_input').value = additionalFees.toFixed(2);
                
                // Flash the price calculation area if accessories have changed
                const priceCard = document.querySelector('#price-calculation .card');
                if (additionalFees > 0) {
                    priceCard.style.transition = 'background-color 0.3s';
                    priceCard.style.backgroundColor = '#e8f4ff';
                    setTimeout(() => {
                        priceCard.style.backgroundColor = '';
                    }, 300);
                }
                
                // Add fees to total - Ensure accessories are added
                const oldTotalPrice = parseFloat(document.getElementById('prix_total').value) || 0;
                
                // Make sure additionalFees are included in the total
                totalPrice = totalPrice + pickupFee + returnFee + additionalFees;
                
                // For debugging/verification - add an informative text to show calculations
                console.log('Base price: ' + (totalPrice - pickupFee - returnFee - additionalFees));
                console.log('Pickup fee: ' + pickupFee);
                console.log('Return fee: ' + returnFee);
                console.log('Accessories fee: ' + additionalFees);
                console.log('Total price: ' + totalPrice);
                
                // Update the price summary text
                const priceSummary = document.getElementById('price-summary');
                const priceSummaryText = document.getElementById('price-summary-text');
                
                if (totalPrice !== oldTotalPrice) {
                    const difference = totalPrice - oldTotalPrice;
                    let summaryText = '';
                    
                    if (additionalFees > 0) {
                        const accessories = [];
                        if (gpsCheckbox.checked) accessories.push('GPS');
                        if (wifiCheckbox.checked) accessories.push('WiFi');
                        if (babySeatCheckbox.checked) accessories.push('Baby Seat');
                        if (fullTankCheckbox.checked) accessories.push('Full Tank');
                        
                        summaryText = `Your selected accessories (${accessories.join(', ')}) add $${additionalFees.toFixed(2)} to the total price.`;
                    }
                    
                    if (pickupFee > 0 || returnFee > 0) {
                        const locationFees = pickupFee + returnFee;
                        summaryText += summaryText ? ' ' : '';
                        summaryText += `Location fees add $${locationFees.toFixed(2)} to the total price.`;
                    }
                    
                    if (summaryText) {
                        priceSummaryText.textContent = summaryText;
                        priceSummary.style.display = 'block';
                    } else {
                        priceSummary.style.display = 'none';
                    }
                } else if (!additionalFees && !pickupFee && !returnFee) {
                    priceSummary.style.display = 'none';
                }
                
                // Update total price
                const totalPriceElement = document.getElementById('total-price');
                const oldPrice = parseFloat(totalPriceElement.textContent.replace('$', '')) || 0;
                
                // Update total price with animation if changed
                if (totalPrice !== oldPrice) {
                    totalPriceElement.classList.add('text-primary');
                    totalPriceElement.style.transition = 'all 0.3s';
                    totalPriceElement.style.transform = 'scale(1.1)';
                    
                    setTimeout(() => {
                        totalPriceElement.textContent = '$' + totalPrice.toFixed(2);
                        totalPriceElement.style.transform = 'scale(1)';
                    }, 150);
                } else {
                    totalPriceElement.textContent = '$' + totalPrice.toFixed(2);
                }
                
                document.getElementById('prix_total').value = totalPrice.toFixed(2);
            }
            
            // Calculate initial price if dates are pre-filled
            calculatePrice();
        });
    </script>
@endsection
