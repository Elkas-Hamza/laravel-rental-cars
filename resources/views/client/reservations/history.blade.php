@extends('layouts.app')

@section('title', 'Rental History')

@section('content')
    <div class="container my-5">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="mb-4">Your Rental History</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('client.reservations.index') }}">My Reservations</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Rental History</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-3 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Account Menu</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('profile') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-user-cog me-2"></i>Profile Settings
                        </a>
                        <a href="{{ route('client.reservations.index') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-calendar-check me-2"></i>Active Reservations
                        </a>
                        <a href="{{ route('client.reservations.history') }}"
                            class="list-group-item list-group-item-action active">
                            <i class="fas fa-history me-2"></i>Rental History
                        </a>
                        <a href="{{ route('cars.index') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-car me-2"></i>Browse Cars
                        </a>
                        <a href="{{ route('support') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-question-circle me-2"></i>Help & Support
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-history me-2 text-primary"></i>Past Rentals</h5>
                            <a href="{{ route('client.reservations.index') }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-calendar-alt me-1"></i>Active Reservations
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Debug info - remove in production -->
                        @if (app()->environment('local'))
                            <div class="alert alert-info mb-3">
                                <p><strong>Debug Info:</strong></p>
                                <p>Found {{ $completedReservations->count() }} reservation(s)</p>
                                @if ($completedReservations->count() > 0)
                                    <p>First reservation ID: {{ $completedReservations->first()->id }}</p>
                                @endif
                            </div>
                        @endif

                        @if ($completedReservations->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Rental ID</th>
                                            <th>Car</th>
                                            <th>Dates</th>
                                            <th>Total Amount</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($completedReservations as $reservation)
                                            <tr>
                                                <td>#{{ $reservation->id }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if ($reservation->car->image)
                                                            <img src="{{ asset('storage/' . $reservation->car->image) }}"
                                                                alt="{{ $reservation->car->name }}"
                                                                class="img-thumbnail me-2"
                                                                style="width: 40px; height: 40px; object-fit: cover;">
                                                        @else
                                                            <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center"
                                                                style="width: 40px; height: 40px;">
                                                                <i class="fas fa-car text-primary"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="fw-bold">{{ $reservation->car->name }}</div>
                                                            <small
                                                                class="text-muted">{{ $reservation->car->license_plate }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div><i class="fas fa-calendar-day me-1 text-primary"></i>
                                                        {{ date('M d, Y', strtotime($reservation->date_debut)) }}</div>
                                                    <div><i class="fas fa-calendar-day me-1 text-danger"></i>
                                                        {{ date('M d, Y', strtotime($reservation->date_fin)) }}</div>
                                                    <small class="text-muted">
                                                        {{ ceil((strtotime($reservation->date_fin) - strtotime($reservation->date_debut)) / 86400) }}
                                                        days
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="fw-bold">${{ number_format($reservation->prix_total, 2) }}
                                                    </div>
                                                    <small
                                                        class="text-muted">${{ number_format($reservation->car->prix_journalier, 2) }}/day</small>
                                                </td>
                                                <td>
                                                    @if ($reservation->status == 'completed')
                                                        <span class="badge bg-success">Completed</span>
                                                    @elseif($reservation->status == 'cancelled')
                                                        <span class="badge bg-danger">Cancelled</span>
                                                    @elseif($reservation->status == 'confirmed' && strtotime($reservation->date_fin) < time())
                                                        <span class="badge bg-success">Completed</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Actions
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('cars.show', $reservation->car) }}">
                                                                    <i class="fas fa-eye me-2"></i>View Car
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item" type="button"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#viewDetailsModal{{ $reservation->id }}">
                                                                    <i class="fas fa-file-alt me-2"></i>Rental Details
                                                                </button>
                                                            </li>
                                                            @if ($reservation->status != 'cancelled')
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('reservations.create', $reservation->car) }}">
                                                                        <i class="fas fa-redo me-2"></i>Rent Again
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>

                                                    <!-- Reservation Details Modal -->
                                                    <div class="modal fade" id="viewDetailsModal{{ $reservation->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="viewDetailsModalLabel{{ $reservation->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="viewDetailsModalLabel{{ $reservation->id }}">
                                                                        Rental Details #{{ $reservation->id }}
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="mb-3 text-center">
                                                                        @if ($reservation->car->image)
                                                                            <img src="{{ asset('storage/' . $reservation->car->image) }}"
                                                                                alt="{{ $reservation->car->name }}"
                                                                                class="img-fluid rounded mb-3"
                                                                                style="max-height: 150px; object-fit: cover;">
                                                                        @endif
                                                                        <h4>{{ $reservation->car->name }}</h4>
                                                                        <p class="text-muted">
                                                                            {{ $reservation->car->category }} |
                                                                            {{ $reservation->car->transmission }} |
                                                                            {{ $reservation->car->fuel_type }}</p>
                                                                    </div>

                                                                    <div class="row mb-3">
                                                                        <div class="col-6">
                                                                            <div class="border rounded p-3 h-100">
                                                                                <small class="text-muted d-block">Pick-up
                                                                                    Date</small>
                                                                                <div class="fw-bold">
                                                                                    {{ date('F d, Y', strtotime($reservation->date_debut)) }}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="border rounded p-3 h-100">
                                                                                <small class="text-muted d-block">Return
                                                                                    Date</small>
                                                                                <div class="fw-bold">
                                                                                    {{ date('F d, Y', strtotime($reservation->date_fin)) }}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row mb-3">
                                                                        <div class="col-6">
                                                                            <div class="border rounded p-3 h-100">
                                                                                <small
                                                                                    class="text-muted d-block">Status</small>
                                                                                @if ($reservation->status == 'completed')
                                                                                    <div class="fw-bold text-success">
                                                                                        Completed</div>
                                                                                @elseif($reservation->status == 'cancelled')
                                                                                    <div class="fw-bold text-danger">
                                                                                        Cancelled</div>
                                                                                @elseif($reservation->status == 'confirmed' && strtotime($reservation->date_fin) < time())
                                                                                    <div class="fw-bold text-success">
                                                                                        Completed</div>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="border rounded p-3 h-100">
                                                                                <small
                                                                                    class="text-muted d-block">Duration</small>
                                                                                <div class="fw-bold">
                                                                                    {{ ceil((strtotime($reservation->date_fin) - strtotime($reservation->date_debut)) / 86400) }}
                                                                                    days</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="border rounded p-3 mb-3">
                                                                        <small class="text-muted d-block">Payment
                                                                            Information</small>
                                                                        <div class="row mt-2">
                                                                            <div class="col-8">Daily Rate</div>
                                                                            <div class="col-4 text-end">
                                                                                ${{ number_format($reservation->car->prix_journalier, 2) }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-8">Number of Days</div>
                                                                            <div class="col-4 text-end">
                                                                                {{ ceil((strtotime($reservation->date_fin) - strtotime($reservation->date_debut)) / 86400) }}
                                                                            </div>
                                                                        </div>
                                                                        <hr>
                                                                        <div class="row fw-bold">
                                                                            <div class="col-8">Total Amount</div>
                                                                            <div class="col-4 text-end">
                                                                                ${{ number_format($reservation->prix_total, 2) }}
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="border rounded p-3">
                                                                        <small class="text-muted d-block">Reservation Made
                                                                            On</small>
                                                                        <div class="fw-bold">
                                                                            {{ date('F d, Y', strtotime($reservation->created_at)) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    @if ($reservation->status != 'cancelled')
                                                                        <a href="{{ route('reservations.create', $reservation->car) }}"
                                                                            class="btn btn-primary">
                                                                            <i class="fas fa-redo me-1"></i>Rent Again
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-history fs-1 text-muted mb-3"></i>
                                <h4>No Rental History Yet</h4>
                                <p class="text-muted">You don't have any completed or cancelled rentals at this time.</p>
                                <a href="{{ route('cars.index') }}" class="btn btn-primary mt-3">
                                    <i class="fas fa-car me-1"></i>Browse Available Cars
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
