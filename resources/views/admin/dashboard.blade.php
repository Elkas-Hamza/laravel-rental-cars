@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('styles')
    <style>
        .dashboard-card {
            transition: all 0.3s;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .dashboard-icon {
            font-size: 3rem;
            color: var(--primary-color);
        }

        .text-primary-gradient {
            background: linear-gradient(45deg, var(--primary-color), #4da3ff);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }

        .activity-timeline .timeline-item {
            position: relative;
            padding-left: 30px;
            margin-bottom: 20px;
        }

        .activity-timeline .timeline-item:before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 2px;
            background-color: #e9ecef;
        }

        .activity-timeline .timeline-item:last-child:before {
            height: 50%;
        }

        .activity-timeline .timeline-point {
            position: absolute;
            left: -6px;
            top: 0;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background-color: var(--primary-color);
            border: 2px solid white;
        }

        .activity-timeline .timeline-content {
            padding-bottom: 10px;
        }

        .border-left-primary {
            border-left: 4px solid #4e73df;
        }

        .border-left-success {
            border-left: 4px solid #1cc88a;
        }

        .border-left-info {
            border-left: 4px solid #36b9cc;
        }

        .border-left-warning {
            border-left: 4px solid #f6c23e;
        }

        .chart-pie {
            position: relative;
            height: 15rem;
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="container py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="mb-0">Admin Dashboard</h1>
                    <a href="{{ route('admin.cars.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> Add New Car
                    </a>
                </div>
                <hr>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Cars</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCars ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-car fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Available Cars</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $availableCars ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Active Reservations</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeReservations ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Total Users</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Recent Reservations</h6>
                        <a href="{{ route('admin.reservations.index') }}" class="btn btn-sm btn-primary">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Car</th>
                                        <th>Dates</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($recentReservations) && count($recentReservations) > 0)
                                        @foreach ($recentReservations as $reservation)
                                            <tr>
                                                <td>{{ $reservation->id }}</td>
                                                <td>{{ $reservation->user->name }}</td>
                                                <td>{{ $reservation->car->name }}</td>
                                                <td>{{ $reservation->start_date->format('M d, Y') }} -
                                                    {{ $reservation->end_date->format('M d, Y') }}</td>
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
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">No recent reservations</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Car Categories</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="carCategoriesChart"></canvas>
                        </div>
                        <div class="mt-4 text-center small">
                            @if (isset($carCategories) && count($carCategories) > 0)
                                @foreach ($carCategories as $category)
                                    <span class="mr-2">
                                        <i class="fas fa-circle"
                                            style="color: #{{ dechex(rand(0x000000, 0xffffff)) }}"></i>
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            @else
                                <p>No categories available</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Sample chart for car categories
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('carCategoriesChart');

            // Check if car categories data exists
            @if (isset($carCategories) && count($carCategories) > 0)
                const categoryNames = {!! json_encode($carCategories->pluck('name')) !!};
                const categoryCounts = {!! json_encode($carCategories->pluck('count')) !!};

                // Generate random colors
                const backgroundColors = [];
                for (let i = 0; i < categoryNames.length; i++) {
                    backgroundColors.push('#' + Math.floor(Math.random() * 16777215).toString(16));
                }

                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: categoryNames,
                        datasets: [{
                            data: categoryCounts,
                            backgroundColor: backgroundColors,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            @else
                // Display "No Data" message if no car categories
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['No Data Available'],
                        datasets: [{
                            data: [1],
                            backgroundColor: ['#d1d1d1'],
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            @endif
        });
    </script>
@endsection
