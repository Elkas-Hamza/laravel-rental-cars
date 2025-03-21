@extends('layouts.app')

@section('title', $user->name)

@section('styles')
    <style>
        .user-header {
            position: relative;
            background-color: #f8f9fa;
            padding: 2rem;
            border-radius: 0.5rem;
            margin-bottom: 2rem;
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--primary-color);
            margin-right: 1.5rem;
        }

        .stat-card {
            transition: all 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .timeline-item {
            position: relative;
            padding-left: 45px;
            margin-bottom: 20px;
        }

        .timeline-item:before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #dee2e6;
        }

        .timeline-icon {
            position: absolute;
            left: 0;
            top: 0;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            z-index: 1;
        }
    </style>
@endsection

@section('content')
    <div class="container my-4">
        <!-- User Header -->
        <div class="user-header shadow-sm">
            <div class="d-md-flex align-items-center">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <div>
                            <h1 class="mb-0">{{ $user->name }}</h1>
                            <p class="text-muted mb-2">{{ $user->email }}</p>
                            <div class="d-flex align-items-center">
                                <span class="badge {{ $user->is_admin ? 'bg-primary' : 'bg-success' }} me-2">
                                    {{ $user->is_admin ? 'Admin' : 'Client' }}
                                </span>
                                <span class="text-muted">Member since {{ $user->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                        <div class="mt-3 mt-md-0">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary me-2">
                                <i class="fas fa-pencil-alt me-2"></i>Edit User
                            </a>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteUserModal">
                                <i class="fas fa-trash-alt me-2"></i>Delete User
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Left Column - User Details -->
            <div class="col-lg-4 mb-4">
                <!-- User Info Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">User Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="text-muted d-block">Name</label>
                            <div class="fw-bold">{{ $user->name }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted d-block">Email</label>
                            <div class="fw-bold">{{ $user->email }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted d-block">Phone</label>
                            <div class="fw-bold">{{ $user->phone ?? 'Not provided' }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted d-block">Role</label>
                            <div class="fw-bold">{{ $user->is_admin ? 'Administrator' : 'Client' }}</div>
                        </div>
                        <div>
                            <label class="text-muted d-block">Account Created</label>
                            <div class="fw-bold">{{ $user->created_at->format('F d, Y') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Card -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Customer Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="stat-card card h-100 border-0 bg-light">
                                    <div class="card-body text-center">
                                        <div class="text-primary mb-2">
                                            <i class="fas fa-calendar-check fa-2x"></i>
                                        </div>
                                        <h3 class="mb-0">{{ $activeReservations }}</h3>
                                        <div class="text-muted">Active Rentals</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-card card h-100 border-0 bg-light">
                                    <div class="card-body text-center">
                                        <div class="text-success mb-2">
                                            <i class="fas fa-check-circle fa-2x"></i>
                                        </div>
                                        <h3 class="mb-0">{{ $completedReservations }}</h3>
                                        <div class="text-muted">Completed</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-card card h-100 border-0 bg-light">
                                    <div class="card-body text-center">
                                        <div class="text-danger mb-2">
                                            <i class="fas fa-times-circle fa-2x"></i>
                                        </div>
                                        <h3 class="mb-0">{{ $cancelledReservations }}</h3>
                                        <div class="text-muted">Cancelled</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-card card h-100 border-0 bg-light">
                                    <div class="card-body text-center">
                                        <div class="text-info mb-2">
                                            <i class="fas fa-dollar-sign fa-2x"></i>
                                        </div>
                                        <h3 class="mb-0">${{ number_format($totalSpent, 2) }}</h3>
                                        <div class="text-muted">Total Spent</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Reservations -->
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Reservation History</h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-filter me-1"></i>Filter
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="#">All Reservations</a></li>
                                <li><a class="dropdown-item" href="#">Active Only</a></li>
                                <li><a class="dropdown-item" href="#">Completed Only</a></li>
                                <li><a class="dropdown-item" href="#">Cancelled Only</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($reservations->count() > 0)
                            <div class="timeline">
                                @foreach ($reservations as $reservation)
                                    <div class="timeline-item">
                                        <div class="timeline-icon">
                                            @if ($reservation->status == 'active')
                                                <i class="fas fa-car"></i>
                                            @elseif($reservation->status == 'completed')
                                                <i class="fas fa-check"></i>
                                            @elseif($reservation->status == 'cancelled')
                                                <i class="fas fa-times"></i>
                                            @else
                                                <i class="fas fa-clock"></i>
                                            @endif
                                        </div>
                                        <div class="card mb-0">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h6 class="mb-0">
                                                        {{ $reservation->car->name ?? 'Unknown Car' }}
                                                    </h6>
                                                    <span
                                                        class="badge bg-{{ $reservation->status == 'active'
                                                            ? 'success'
                                                            : ($reservation->status == 'completed'
                                                                ? 'info'
                                                                : ($reservation->status == 'cancelled'
                                                                    ? 'danger'
                                                                    : 'warning')) }}">
                                                        {{ ucfirst($reservation->status) }}
                                                    </span>
                                                </div>
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block">Pickup Date</small>
                                                        <div>
                                                            {{ \Carbon\Carbon::parse($reservation->pickup_date)->format('M d, Y h:i A') }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block">Return Date</small>
                                                        <div>
                                                            {{ \Carbon\Carbon::parse($reservation->return_date)->format('M d, Y h:i A') }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block">Pickup Location</small>
                                                        <div>{{ $reservation->pickup_location ?? 'Main Office' }}</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <small class="text-muted d-block">Return Location</small>
                                                        <div>{{ $reservation->return_location ?? 'Main Office' }}</div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <small class="text-muted">Total Price:</small>
                                                        <strong
                                                            class="ms-2">${{ number_format($reservation->total_price, 2) }}</strong>
                                                    </div>
                                                    <a href="#" class="btn btn-sm btn-outline-primary">View
                                                        Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-calendar display-1 text-muted"></i>
                                <h4 class="mt-3">No reservations yet</h4>
                                <p class="text-muted">This user hasn't made any car reservations.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this user?</p>
                    <p class="fw-bold">{{ $user->name }}</p>
                    <p class="text-danger">This action cannot be undone.</p>

                    @if ($activeReservations > 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            This user has {{ $activeReservations }} active reservations. These must be handled before
                            deletion.
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" {{ $activeReservations > 0 ? 'disabled' : '' }}>
                            Delete User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
