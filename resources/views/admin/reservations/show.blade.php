@extends('layouts.app')

@section('title', 'Reservation Details')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Reservation Details</h1>
            <div>
                <a href="{{ route('admin.reservations.edit', $reservation) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit Reservation
                </a>
                <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary ms-2">
                    <i class="fas fa-arrow-left me-1"></i> Back to List
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0">
                            Reservation #{{ $reservation->id }}
                            @if ($reservation->status == 'active')
                                <span class="badge bg-success ms-2">Active</span>
                            @elseif($reservation->status == 'pending')
                                <span class="badge bg-warning ms-2">Pending</span>
                            @elseif($reservation->status == 'cancelled')
                                <span class="badge bg-danger ms-2">Cancelled</span>
                            @elseif($reservation->status == 'completed')
                                <span class="badge bg-info ms-2">Completed</span>
                            @endif
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="text-muted mb-2">Reservation Details</h6>
                                <p><strong>Created:</strong> {{ $reservation->created_at->format('M d, Y H:i') }}</p>
                                <p><strong>Last Updated:</strong> {{ $reservation->updated_at->format('M d, Y H:i') }}</p>
                                <p>
                                    <strong>Rental Period:</strong><br>
                                    {{ $reservation->start_date->format('M d, Y') }} -
                                    {{ $reservation->end_date->format('M d, Y') }}
                                    <span
                                        class="text-muted ms-2">({{ $reservation->start_date->diffInDays($reservation->end_date) }}
                                        days)</span>
                                </p>
                                <p><strong>Total Price:</strong> ${{ number_format($reservation->total_price, 2) }}</p>

                                @if ($reservation->notes)
                                    <p><strong>Notes:</strong> {{ $reservation->notes }}</p>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted mb-2">Customer Information</h6>
                                <p><strong>Name:</strong> {{ $reservation->user->name }}</p>
                                <p><strong>Email:</strong> {{ $reservation->user->email }}</p>
                                @if ($reservation->user->phone)
                                    <p><strong>Phone:</strong> {{ $reservation->user->phone }}</p>
                                @endif
                                <a href="{{ route('admin.users.show', $reservation->user->id) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-user me-1"></i> View User Profile
                                </a>
                            </div>
                        </div>

                        <h6 class="text-muted mb-3">Rental Status Timeline</h6>
                        <div class="timeline mb-4">
                            <div class="timeline-item">
                                <div class="timeline-point bg-primary"></div>
                                <div class="timeline-content">
                                    <p class="mb-0"><strong>Reservation Created</strong></p>
                                    <small class="text-muted">{{ $reservation->created_at->format('M d, Y H:i') }}</small>
                                </div>
                            </div>

                            @if ($reservation->status != 'pending')
                                <div class="timeline-item">
                                    <div
                                        class="timeline-point {{ $reservation->status == 'cancelled' ? 'bg-danger' : 'bg-success' }}">
                                    </div>
                                    <div class="timeline-content">
                                        <p class="mb-0">
                                            <strong>
                                                @if ($reservation->status == 'active')
                                                    Reservation Activated
                                                @elseif($reservation->status == 'cancelled')
                                                    Reservation Cancelled
                                                @elseif($reservation->status == 'completed')
                                                    Rental Completed
                                                @endif
                                            </strong>
                                        </p>
                                        <small
                                            class="text-muted">{{ $reservation->updated_at->format('M d, Y H:i') }}</small>
                                    </div>
                                </div>
                            @endif

                            @if ($reservation->status == 'active')
                                <div class="timeline-item">
                                    <div class="timeline-point bg-light"></div>
                                    <div class="timeline-content">
                                        <p class="mb-0"><strong>Expected Return</strong></p>
                                        <small class="text-muted">{{ $reservation->end_date->format('M d, Y') }}</small>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteModal">
                                <i class="fas fa-trash me-1"></i> Delete Reservation
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0">Payment Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th width="30%">Rental Rate</th>
                                        <td>${{ number_format($reservation->car->price_per_day, 2) }} per day</td>
                                    </tr>
                                    <tr>
                                        <th>Rental Duration</th>
                                        <td>{{ $reservation->start_date->diffInDays($reservation->end_date) }} days</td>
                                    </tr>
                                    <tr>
                                        <th>Subtotal</th>
                                        <td>${{ number_format($reservation->car->price_per_day * $reservation->start_date->diffInDays($reservation->end_date), 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Taxes & Fees</th>
                                        <td>${{ number_format($reservation->total_price - $reservation->car->price_per_day * $reservation->start_date->diffInDays($reservation->end_date), 2) }}
                                        </td>
                                    </tr>
                                    <tr class="table-active">
                                        <th>Total Amount</th>
                                        <td><strong>${{ number_format($reservation->total_price, 2) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Payment Status</th>
                                        <td>
                                            <span class="badge bg-success">Paid</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Car Details</h5>
                        <a href="{{ route('admin.cars.show', $reservation->car) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-car me-1"></i> View Car
                        </a>
                    </div>
                    <div class="card-body">
                        @if ($reservation->car->image)
                            <img src="{{ asset('storage/' . $reservation->car->image) }}"
                                alt="{{ $reservation->car->name }}" class="img-fluid rounded mb-3">
                        @else
                            <div class="bg-light rounded text-center py-5 mb-3">
                                <i class="fas fa-car fa-3x text-muted"></i>
                                <p class="mt-2 mb-0 text-muted">No image available</p>
                            </div>
                        @endif

                        <h5>{{ $reservation->car->name }}</h5>
                        <p class="text-muted mb-3">{{ $reservation->car->category }}</p>

                        <div class="mb-3">
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="border rounded p-2 h-100">
                                        <small class="text-muted d-block">License Plate</small>
                                        <span>{{ $reservation->car->license_plate }}</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border rounded p-2 h-100">
                                        <small class="text-muted d-block">Year</small>
                                        <span>{{ $reservation->car->year }}</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border rounded p-2 h-100">
                                        <small class="text-muted d-block">Seats</small>
                                        <span>{{ $reservation->car->seats }}</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border rounded p-2 h-100">
                                        <small class="text-muted d-block">Transmission</small>
                                        <span>{{ ucfirst($reservation->car->transmission) }}</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border rounded p-2 h-100">
                                        <small class="text-muted d-block">Fuel Type</small>
                                        <span>{{ ucfirst($reservation->car->fuel_type) }}</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border rounded p-2 h-100">
                                        <small class="text-muted d-block">Status</small>
                                        <span>{{ ucfirst($reservation->car->status) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p class="mb-0"><strong>Daily Rate:</strong>
                            ${{ number_format($reservation->car->price_per_day, 2) }}</p>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.reservations.edit', $reservation) }}"
                                class="btn btn-outline-primary">
                                <i class="fas fa-edit me-2"></i> Edit Reservation
                            </a>

                            @if ($reservation->status == 'pending')
                                <form action="{{ route('admin.reservations.update', $reservation) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="active">
                                    <input type="hidden" name="user_id" value="{{ $reservation->user_id }}">
                                    <input type="hidden" name="car_id" value="{{ $reservation->car_id }}">
                                    <input type="hidden" name="start_date"
                                        value="{{ $reservation->start_date->format('Y-m-d') }}">
                                    <input type="hidden" name="end_date"
                                        value="{{ $reservation->end_date->format('Y-m-d') }}">
                                    <input type="hidden" name="total_price" value="{{ $reservation->total_price }}">
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fas fa-check-circle me-2"></i> Approve Reservation
                                    </button>
                                </form>
                            @endif

                            @if ($reservation->status == 'active')
                                <form action="{{ route('admin.reservations.update', $reservation) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="completed">
                                    <input type="hidden" name="user_id" value="{{ $reservation->user_id }}">
                                    <input type="hidden" name="car_id" value="{{ $reservation->car_id }}">
                                    <input type="hidden" name="start_date"
                                        value="{{ $reservation->start_date->format('Y-m-d') }}">
                                    <input type="hidden" name="end_date"
                                        value="{{ $reservation->end_date->format('Y-m-d') }}">
                                    <input type="hidden" name="total_price" value="{{ $reservation->total_price }}">
                                    <button type="submit" class="btn btn-info w-100">
                                        <i class="fas fa-flag-checkered me-2"></i> Mark as Completed
                                    </button>
                                </form>
                            @endif

                            @if ($reservation->status == 'pending' || $reservation->status == 'active')
                                <form action="{{ route('admin.reservations.update', $reservation) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="cancelled">
                                    <input type="hidden" name="user_id" value="{{ $reservation->user_id }}">
                                    <input type="hidden" name="car_id" value="{{ $reservation->car_id }}">
                                    <input type="hidden" name="start_date"
                                        value="{{ $reservation->start_date->format('Y-m-d') }}">
                                    <input type="hidden" name="end_date"
                                        value="{{ $reservation->end_date->format('Y-m-d') }}">
                                    <input type="hidden" name="total_price" value="{{ $reservation->total_price }}">
                                    <button type="submit" class="btn btn-outline-danger w-100">
                                        <i class="fas fa-ban me-2"></i> Cancel Reservation
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this reservation?</p>
                    <p><strong>ID:</strong> {{ $reservation->id }}</p>
                    <p><strong>User:</strong> {{ $reservation->user->name }}</p>
                    <p><strong>Car:</strong> {{ $reservation->car->name }}</p>
                    <p><strong>Dates:</strong> {{ $reservation->start_date->format('M d, Y') }} -
                        {{ $reservation->end_date->format('M d, Y') }}</p>
                    <p class="text-danger">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.reservations.destroy', $reservation) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .timeline {
            position: relative;
        }

        .timeline:before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 7px;
            width: 2px;
            background-color: #e0e0e0;
        }

        .timeline-item {
            position: relative;
            padding-left: 30px;
            padding-bottom: 20px;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-point {
            position: absolute;
            left: 0;
            top: 5px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background-color: #0d6efd;
        }

        .timeline-point.bg-success {
            background-color: #198754;
        }

        .timeline-point.bg-danger {
            background-color: #dc3545;
        }

        .timeline-point.bg-light {
            background-color: #f8f9fa;
            border: 2px solid #e0e0e0;
        }
    </style>
@endsection
