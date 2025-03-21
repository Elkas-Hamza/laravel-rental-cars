@extends('layouts.app')

@section('title', 'Edit Reservation')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Edit Reservation</h1>
            <div>
                <a href="{{ route('admin.reservations.show', $reservation) }}" class="btn btn-outline-primary">
                    <i class="fas fa-eye me-1"></i> View Details
                </a>
                <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary ms-2">
                    <i class="fas fa-arrow-left me-1"></i> Back to List
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0">Reservation Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.reservations.update', $reservation) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="user_id" class="form-label">Customer</label>
                                    <select class="form-select @error('user_id') is-invalid @enderror" id="user_id"
                                        name="user_id">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('user_id', $reservation->user_id) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="status" class="form-label">Reservation Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status"
                                        name="status">
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status }}"
                                                {{ old('status', $reservation->status) == $status ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Note: Changing status may affect car availability.
                                    </small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="car_id" class="form-label">Car</label>
                                <select class="form-select @error('car_id') is-invalid @enderror" id="car_id"
                                    name="car_id">
                                    @foreach ($cars as $car)
                                        <option value="{{ $car->id }}"
                                            {{ old('car_id', $reservation->car_id) == $car->id ? 'selected' : '' }}
                                            data-price="{{ $car->price_per_day }}">
                                            {{ $car->name }} - {{ $car->license_plate }}
                                            ({{ $car->id == $reservation->car_id ? 'Current Selection' : ($car->status == 'available' ? 'Available' : 'Not Available') }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('car_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                        id="start_date" name="start_date"
                                        value="{{ old('start_date', $reservation->start_date->format('Y-m-d')) }}">
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                        id="end_date" name="end_date"
                                        value="{{ old('end_date', $reservation->end_date->format('Y-m-d')) }}">
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="total_price" class="form-label">Total Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01"
                                        class="form-control @error('total_price') is-invalid @enderror" id="total_price"
                                        name="total_price" value="{{ old('total_price', $reservation->total_price) }}">
                                </div>
                                @error('total_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small id="price_calculation" class="form-text text-muted">
                                    Base calculation:
                                    <span id="daily_rate">${{ $reservation->car->price_per_day }}</span> ×
                                    <span
                                        id="num_days">{{ $reservation->start_date->diffInDays($reservation->end_date) }}</span>
                                    days =
                                    <span
                                        id="subtotal">${{ $reservation->car->price_per_day * $reservation->start_date->diffInDays($reservation->end_date) }}</span>
                                </small>
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Notes (Optional)</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $reservation->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.reservations.index') }}"
                                    class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Reservation</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0">Current Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">Reservation #{{ $reservation->id }}</h6>
                            <div class="d-flex align-items-center mb-2">
                                <span class="me-2">Status:</span>
                                @if ($reservation->status == 'active')
                                    <span class="badge bg-success">Active</span>
                                @elseif($reservation->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($reservation->status == 'cancelled')
                                    <span class="badge bg-danger">Cancelled</span>
                                @elseif($reservation->status == 'completed')
                                    <span class="badge bg-info">Completed</span>
                                @endif
                            </div>
                            <p><strong>Created:</strong> {{ $reservation->created_at->format('M d, Y H:i') }}</p>
                            <p><strong>Last Updated:</strong> {{ $reservation->updated_at->format('M d, Y H:i') }}</p>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <h6 class="text-muted mb-2">Customer Information</h6>
                            <p class="mb-1"><strong>Name:</strong> {{ $reservation->user->name }}</p>
                            <p class="mb-1"><strong>Email:</strong> {{ $reservation->user->email }}</p>
                            @if ($reservation->user->phone)
                                <p class="mb-0"><strong>Phone:</strong> {{ $reservation->user->phone }}</p>
                            @endif
                        </div>

                        <hr>

                        <div>
                            <h6 class="text-muted mb-2">Current Car</h6>
                            <p class="mb-1"><strong>Model:</strong> {{ $reservation->car->name }}</p>
                            <p class="mb-1"><strong>License Plate:</strong> {{ $reservation->car->license_plate }}</p>
                            <p class="mb-0"><strong>Daily Rate:</strong>
                                ${{ number_format($reservation->car->price_per_day, 2) }}</p>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm bg-light">
                    <div class="card-body">
                        <h6 class="text-muted mb-3">Edit Instructions</h6>
                        <ul class="mb-0">
                            <li class="mb-2">Changing the car or dates will affect the price calculation.</li>
                            <li class="mb-2">If you change status to "active", the car will be marked as rented.</li>
                            <li class="mb-2">If you change status to "completed" or "cancelled", the car will be made
                                available.</li>
                            <li class="mb-2">You can adjust the final price to account for additional fees or discounts.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carSelect = document.getElementById('car_id');
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const dailyRateSpan = document.getElementById('daily_rate');
            const numDaysSpan = document.getElementById('num_days');
            const subtotalSpan = document.getElementById('subtotal');
            const totalPriceInput = document.getElementById('total_price');

            // Function to calculate rental duration
            function calculateDuration() {
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(endDateInput.value);

                if (startDate && endDate && endDate > startDate) {
                    // Calculate the time difference in milliseconds
                    const timeDiff = endDate - startDate;

                    // Convert time difference to days
                    const days = Math.ceil(timeDiff / (1000 * 3600 * 24));
                    return days;
                }

                return 0;
            }

            // Function to update price calculation
            function updatePriceCalculation() {
                const selectedCar = carSelect.options[carSelect.selectedIndex];
                const dailyRate = parseFloat(selectedCar.dataset.price);
                const days = calculateDuration();

                dailyRateSpan.textContent = '$' + dailyRate.toFixed(2);
                numDaysSpan.textContent = days;

                const subtotal = dailyRate * days;
                subtotalSpan.textContent = '$' + subtotal.toFixed(2);

                // Update total price if it matches the calculated subtotal
                const currentTotal = parseFloat(totalPriceInput.value);
                if (Math.abs(currentTotal - subtotal) < 0.01) {
                    totalPriceInput.value = subtotal.toFixed(2);
                }
            }

            // Set up event listeners
            carSelect.addEventListener('change', updatePriceCalculation);
            startDateInput.addEventListener('change', updatePriceCalculation);
            endDateInput.addEventListener('change', updatePriceCalculation);

            // Initialize calculation on page load
            updatePriceCalculation();
        });
    </script>
@endsection
