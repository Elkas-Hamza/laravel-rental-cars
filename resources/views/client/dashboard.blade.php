@extends('layouts.app')

@section('title', 'Client Dashboard')

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-user-circle fs-1 text-primary mb-3"></i>
                        <h5 class="card-title">Welcome, {{ auth()->user()->name }}</h5>
                        <p class="card-text">Manage your reservations and account details</p>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title"><i class="fas fa-calendar-check me-2"></i>Active Reservations
                                    </h5>
                                    <span class="badge bg-primary rounded-pill">{{ $activeReservations ?? 0 }}</span>
                                </div>
                                <p class="card-text">Manage your current car reservations</p>
                                <a href="{{ route('reservations.index') }}" class="btn btn-sm btn-outline-primary">View
                                    Reservations</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title"><i class="fas fa-car me-2"></i>Browse Cars</h5>
                                    <i class="fas fa-arrow-circle-right fs-4 text-primary"></i>
                                </div>
                                <p class="card-text">Explore our collection of available cars</p>
                                <a href="{{ route('cars.index') }}" class="btn btn-sm btn-outline-primary">Browse Cars</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title"><i class="fas fa-history me-2"></i>Rental History</h5>
                                    <span class="badge bg-secondary rounded-pill">{{ $pastReservations ?? 0 }}</span>
                                </div>
                                <p class="card-text">View your past rental history and invoices</p>
                                <a href="{{ route('reservations.history') }}" class="btn btn-sm btn-outline-primary">View
                                    History</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title"><i class="fas fa-cog me-2"></i>Profile Settings</h5>
                                    <i class="fas fa-user-cog fs-4 text-primary"></i>
                                </div>
                                <p class="card-text">Update your personal information and preferences</p>
                                <a href="{{ route('profile') }}" class="btn btn-sm btn-outline-primary">Edit Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3 col-6 mb-3">
                                <a href="{{ route('reservations.create') }}" class="text-decoration-none">
                                    <div class="p-3 rounded bg-light">
                                        <i class="fas fa-plus-circle fs-1 text-primary"></i>
                                        <p class="mt-2 mb-0">New Reservation</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="{{ route('cars.index') }}" class="text-decoration-none">
                                    <div class="p-3 rounded bg-light">
                                        <i class="fas fa-search fs-1 text-primary"></i>
                                        <p class="mt-2 mb-0">Search Cars</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="{{ route('support') }}" class="text-decoration-none">
                                    <div class="p-3 rounded bg-light">
                                        <i class="fas fa-headset fs-1 text-primary"></i>
                                        <p class="mt-2 mb-0">Support</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="{{ route('faq') }}" class="text-decoration-none">
                                    <div class="p-3 rounded bg-light">
                                        <i class="fas fa-question-circle fs-1 text-primary"></i>
                                        <p class="mt-2 mb-0">FAQ</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities Section -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Recent Activities</h5>
                    </div>
                    <div class="card-body">
                        @if (isset($recentActivities) && count($recentActivities) > 0)
                            <ul class="list-group list-group-flush">
                                @foreach ($recentActivities as $activity)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <i
                                                class="fas {{ $activity->type == 'reservation' ? 'fa-calendar-plus' : 'fa-car' }} me-2 text-primary"></i>
                                            {{ $activity->description }}
                                            <small
                                                class="text-muted d-block">{{ $activity->created_at->diffForHumans() }}</small>
                                        </div>
                                        <a href="{{ $activity->link }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-external-link-alt me-1"></i>View
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-info-circle fs-1 text-muted mb-3"></i>
                                <p class="mb-0">No recent activities found</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
