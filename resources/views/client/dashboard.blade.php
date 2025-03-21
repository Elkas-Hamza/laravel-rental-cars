@extends('layouts.app')

@section('title', 'Client Dashboard')

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-person-circle fs-1 text-primary mb-3"></i>
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
                                    <h5 class="card-title"><i class="bi bi-calendar-check me-2"></i>Active Reservations</h5>
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
                                    <h5 class="card-title"><i class="bi bi-car-front me-2"></i>Browse Cars</h5>
                                    <i class="bi bi-arrow-right-circle fs-4 text-primary"></i>
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
                                    <h5 class="card-title"><i class="bi bi-clock-history me-2"></i>Rental History</h5>
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
                                    <h5 class="card-title"><i class="bi bi-gear me-2"></i>Profile Settings</h5>
                                    <i class="bi bi-person-gear fs-4 text-primary"></i>
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
                        <h5 class="mb-0"><i class="bi bi-lightning-charge me-2"></i>Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3 col-6 mb-3">
                                <a href="{{ route('reservations.create') }}" class="text-decoration-none">
                                    <div class="p-3 rounded bg-light">
                                        <i class="bi bi-plus-circle fs-1 text-primary"></i>
                                        <p class="mt-2 mb-0">New Reservation</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="{{ route('cars.index') }}" class="text-decoration-none">
                                    <div class="p-3 rounded bg-light">
                                        <i class="bi bi-search fs-1 text-primary"></i>
                                        <p class="mt-2 mb-0">Search Cars</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="{{ route('support') }}" class="text-decoration-none">
                                    <div class="p-3 rounded bg-light">
                                        <i class="bi bi-headset fs-1 text-primary"></i>
                                        <p class="mt-2 mb-0">Support</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="{{ route('faq') }}" class="text-decoration-none">
                                    <div class="p-3 rounded bg-light">
                                        <i class="bi bi-question-circle fs-1 text-primary"></i>
                                        <p class="mt-2 mb-0">FAQ</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
