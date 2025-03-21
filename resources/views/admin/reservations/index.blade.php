@extends('layouts.app')

@section('title', 'Manage Reservations')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Manage Reservations</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
            </a>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Filter Reservations</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.reservations.index') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" class="form-control" id="search" name="search"
                            placeholder="Reservation ID, User or Car" value="{{ request('search') }}">
                    </div>

                    <div class="col-md-2">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status == 'all' ? 'All Statuses' : $status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="user_id" class="form-label">User</label>
                        <select class="form-select" id="user_id" name="user_id">
                            <option value="">All Users</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="car_id" class="form-label">Car</label>
                        <select class="form-select" id="car_id" name="car_id">
                            <option value="">All Cars</option>
                            @foreach ($cars as $car)
                                <option value="{{ $car->id }}" {{ request('car_id') == $car->id ? 'selected' : '' }}>
                                    {{ $car->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter me-1"></i> Apply Filters
                        </button>
                        <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-undo me-1"></i> Clear Filters
                        </a>
                    </div>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Car</th>
                                <th>Dates</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reservations as $reservation)
                                <tr>
                                    <td>{{ $reservation->id }}</td>
                                    <td>
                                        {{ $reservation->user->name }}
                                        <small class="d-block text-muted">{{ $reservation->user->email }}</small>
                                    </td>
                                    <td>
                                        {{ $reservation->car->name }}
                                        <small class="d-block text-muted">{{ $reservation->car->license_plate }}</small>
                                    </td>
                                    <td>
                                        {{ $reservation->start_date->format('M d, Y') }} -
                                        {{ $reservation->end_date->format('M d, Y') }}
                                        <small class="d-block text-muted">
                                            {{ $reservation->start_date->diffInDays($reservation->end_date) }} days
                                        </small>
                                    </td>
                                    <td>${{ number_format($reservation->total_price, 2) }}</td>
                                    <td>
                                        @if ($reservation->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif($reservation->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($reservation->status == 'cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @elseif($reservation->status == 'completed')
                                            <span class="badge bg-info">Completed</span>
                                        @endif
                                    </td>
                                    <td>{{ $reservation->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.reservations.show', $reservation) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.reservations.edit', $reservation) }}"
                                                class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $reservation->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $reservation->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Confirm Delete</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete this reservation?</p>
                                                        <p><strong>ID:</strong> {{ $reservation->id }}</p>
                                                        <p><strong>User:</strong> {{ $reservation->user->name }}</p>
                                                        <p><strong>Car:</strong> {{ $reservation->car->name }}</p>
                                                        <p><strong>Dates:</strong>
                                                            {{ $reservation->start_date->format('M d, Y') }} -
                                                            {{ $reservation->end_date->format('M d, Y') }}</p>
                                                        <p class="text-danger">This action cannot be undone.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <form
                                                            action="{{ route('admin.reservations.destroy', $reservation) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-calendar-times fa-3x mb-3"></i>
                                            <p>No reservations found.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $reservations->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
