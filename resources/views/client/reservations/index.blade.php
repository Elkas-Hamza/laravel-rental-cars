@extends('layouts.app')

@section('title', 'My Reservations')

@section('styles')
    <style>
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-active {
            background-color: rgba(25, 135, 84, 0.1);
            color: #198754;
        }

        .status-completed {
            background-color: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
        }

        .status-cancelled {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .status-pending {
            background-color: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .reservation-card {
            transition: all 0.3s;
            cursor: pointer;
        }

        .reservation-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .car-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 4px;
        }

        .rental-dates {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .date-divider {
            flex-grow: 1;
            height: 1px;
            background-color: rgba(0, 0, 0, 0.1);
            margin: 0 10px;
            position: relative;
        }

        .date-divider::after {
            content: '→';
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            background-color: white;
            padding: 0 5px;
        }
    </style>
@endsection

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>My Reservations</h2>
            <a href="{{ route('reservations.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>New Reservation
            </a>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <ul class="nav nav-tabs card-header-tabs" id="reservationTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="active-tab" data-bs-toggle="tab" data-bs-target="#active"
                            type="button" role="tab" aria-controls="active" aria-selected="true">
                            Active <span class="badge bg-primary ms-1">{{ count($activeReservations ?? []) }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming"
                            type="button" role="tab" aria-controls="upcoming" aria-selected="false">
                            Upcoming <span class="badge bg-primary ms-1">{{ count($upcomingReservations ?? []) }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed"
                            type="button" role="tab" aria-controls="completed" aria-selected="false">
                            Completed <span class="badge bg-primary ms-1">{{ count($completedReservations ?? []) }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled"
                            type="button" role="tab" aria-controls="cancelled" aria-selected="false">
                            Cancelled <span class="badge bg-primary ms-1">{{ count($cancelledReservations ?? []) }}</span>
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content" id="reservationsTabContent">
                    <!-- Active Reservations Tab -->
                    <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
                        @if (isset($activeReservations) && count($activeReservations) > 0)
                            <div class="row">
                                @foreach ($activeReservations as $reservation)
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="card reservation-card shadow-sm h-100"
                                            onclick="window.location.href='{{ route('reservations.show', $reservation->id) }}'">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start mb-3">
                                                    <h5 class="card-title mb-0">{{ $reservation->car->name }}</h5>
                                                    <span class="status-badge status-active">Active</span>
                                                </div>

                                                <img src="{{ asset($reservation->car->image) }}"
                                                    alt="{{ $reservation->car->name }}" class="car-image mb-3">

                                                <div class="rental-dates">
                                                    <div class="text-center">
                                                        <small class="text-muted d-block">Pickup</small>
                                                        <strong>{{ \Carbon\Carbon::parse($reservation->pickup_date)->format('M d, Y') }}</strong>
                                                    </div>
                                                    <div class="date-divider"></div>
                                                    <div class="text-center">
                                                        <small class="text-muted d-block">Return</small>
                                                        <strong>{{ \Carbon\Carbon::parse($reservation->return_date)->format('M d, Y') }}</strong>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between mt-3">
                                                    <div>
                                                        <small class="text-muted d-block">Location</small>
                                                        <span>{{ $reservation->pickupLocation->name }}</span>
                                                    </div>
                                                    <div class="text-end">
                                                        <small class="text-muted d-block">Total</small>
                                                        <span
                                                            class="fw-bold">${{ number_format($reservation->total_price, 2) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-car display-1 text-muted"></i>
                                <h4 class="mt-3">No active reservations</h4>
                                <p class="text-muted">You don't have any active car rentals at the moment.</p>
                                <a href="{{ route('reservations.create') }}" class="btn btn-primary mt-2">
                                    <i class="fas fa-plus-circle me-2"></i>Make a Reservation
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Upcoming Reservations Tab -->
                    <div class="tab-pane fade" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
                        @if (isset($upcomingReservations) && count($upcomingReservations) > 0)
                            <div class="row">
                                @foreach ($upcomingReservations as $reservation)
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="card reservation-card shadow-sm h-100"
                                            onclick="window.location.href='{{ route('reservations.show', $reservation->id) }}'">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start mb-3">
                                                    <h5 class="card-title mb-0">{{ $reservation->car->name }}</h5>
                                                    <span class="status-badge status-pending">Upcoming</span>
                                                </div>

                                                <img src="{{ asset($reservation->car->image) }}"
                                                    alt="{{ $reservation->car->name }}" class="car-image mb-3">

                                                <div class="rental-dates">
                                                    <div class="text-center">
                                                        <small class="text-muted d-block">Pickup</small>
                                                        <strong>{{ \Carbon\Carbon::parse($reservation->pickup_date)->format('M d, Y') }}</strong>
                                                    </div>
                                                    <div class="date-divider"></div>
                                                    <div class="text-center">
                                                        <small class="text-muted d-block">Return</small>
                                                        <strong>{{ \Carbon\Carbon::parse($reservation->return_date)->format('M d, Y') }}</strong>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between mt-3">
                                                    <div>
                                                        <small class="text-muted d-block">Location</small>
                                                        <span>{{ $reservation->pickupLocation->name }}</span>
                                                    </div>
                                                    <div class="text-end">
                                                        <small class="text-muted d-block">Total</small>
                                                        <span
                                                            class="fw-bold">${{ number_format($reservation->total_price, 2) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-calendar display-1 text-muted"></i>
                                <h4 class="mt-3">No upcoming reservations</h4>
                                <p class="text-muted">You don't have any upcoming car rentals scheduled.</p>
                                <a href="{{ route('reservations.create') }}" class="btn btn-primary mt-2">
                                    <i class="fas fa-plus-circle me-2"></i>Schedule a Reservation
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Completed Reservations Tab -->
                    <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
                        @if (isset($completedReservations) && count($completedReservations) > 0)
                            <div class="row">
                                @foreach ($completedReservations as $reservation)
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="card reservation-card shadow-sm h-100"
                                            onclick="window.location.href='{{ route('reservations.show', $reservation->id) }}'">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start mb-3">
                                                    <h5 class="card-title mb-0">{{ $reservation->car->name }}</h5>
                                                    <span class="status-badge status-completed">Completed</span>
                                                </div>

                                                <img src="{{ asset($reservation->car->image) }}"
                                                    alt="{{ $reservation->car->name }}" class="car-image mb-3">

                                                <div class="rental-dates">
                                                    <div class="text-center">
                                                        <small class="text-muted d-block">Pickup</small>
                                                        <strong>{{ \Carbon\Carbon::parse($reservation->pickup_date)->format('M d, Y') }}</strong>
                                                    </div>
                                                    <div class="date-divider"></div>
                                                    <div class="text-center">
                                                        <small class="text-muted d-block">Return</small>
                                                        <strong>{{ \Carbon\Carbon::parse($reservation->return_date)->format('M d, Y') }}</strong>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between mt-3">
                                                    <div>
                                                        <small class="text-muted d-block">Location</small>
                                                        <span>{{ $reservation->pickupLocation->name }}</span>
                                                    </div>
                                                    <div class="text-end">
                                                        <small class="text-muted d-block">Total</small>
                                                        <span
                                                            class="fw-bold">${{ number_format($reservation->total_price, 2) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-check-circle display-1 text-muted"></i>
                                <h4 class="mt-3">No completed reservations</h4>
                                <p class="text-muted">You don't have any completed car rentals yet.</p>
                                <a href="{{ route('reservations.create') }}" class="btn btn-primary mt-2">
                                    <i class="fas fa-plus-circle me-2"></i>Make a Reservation
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Cancelled Reservations Tab -->
                    <div class="tab-pane fade" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">
                        @if (isset($cancelledReservations) && count($cancelledReservations) > 0)
                            <div class="row">
                                @foreach ($cancelledReservations as $reservation)
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="card reservation-card shadow-sm h-100"
                                            onclick="window.location.href='{{ route('reservations.show', $reservation->id) }}'">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start mb-3">
                                                    <h5 class="card-title mb-0">{{ $reservation->car->name }}</h5>
                                                    <span class="status-badge status-cancelled">Cancelled</span>
                                                </div>

                                                <img src="{{ asset($reservation->car->image) }}"
                                                    alt="{{ $reservation->car->name }}" class="car-image mb-3">

                                                <div class="rental-dates">
                                                    <div class="text-center">
                                                        <small class="text-muted d-block">Pickup</small>
                                                        <strong>{{ \Carbon\Carbon::parse($reservation->pickup_date)->format('M d, Y') }}</strong>
                                                    </div>
                                                    <div class="date-divider"></div>
                                                    <div class="text-center">
                                                        <small class="text-muted d-block">Return</small>
                                                        <strong>{{ \Carbon\Carbon::parse($reservation->return_date)->format('M d, Y') }}</strong>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between mt-3">
                                                    <div>
                                                        <small class="text-muted d-block">Location</small>
                                                        <span>{{ $reservation->pickupLocation->name }}</span>
                                                    </div>
                                                    <div class="text-end">
                                                        <small class="text-muted d-block">Total</small>
                                                        <span
                                                            class="fw-bold">${{ number_format($reservation->total_price, 2) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-times-circle display-1 text-muted"></i>
                                <h4 class="mt-3">No cancelled reservations</h4>
                                <p class="text-muted">You don't have any cancelled car rentals.</p>
                                <a href="{{ route('reservations.create') }}" class="btn btn-primary mt-2">
                                    <i class="fas fa-plus-circle me-2"></i>Make a Reservation
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
