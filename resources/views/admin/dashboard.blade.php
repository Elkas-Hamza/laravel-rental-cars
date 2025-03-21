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
    </style>
@endsection

@section('content')
    <div class="container-fluid my-4">
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h1 class="mb-0">Welcome, {{ auth()->user()->name }}</h1>
                <p class="text-muted">Dashboard Overview</p>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#reportModal">
                        <i class="bi bi-file-earmark-bar-graph me-2"></i>Generate Report
                    </button>
                    <a href="{{ route('admin.settings') }}" class="btn btn-outline-primary">
                        <i class="bi bi-gear me-2"></i>Settings
                    </a>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card dashboard-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Total Revenue</h6>
                                <h2 class="mb-0">${{ number_format($totalRevenue ?? 25840, 2) }}</h2>
                                <p class="text-success mb-0">
                                    <i class="bi bi-arrow-up-right"></i>
                                    <span>{{ $revenueGrowth ?? 12.5 }}%</span> since last month
                                </p>
                            </div>
                            <div class="dashboard-icon">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card dashboard-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Active Reservations</h6>
                                <h2 class="mb-0">{{ $activeReservations ?? 42 }}</h2>
                                <p class="text-success mb-0">
                                    <i class="bi bi-arrow-up-right"></i>
                                    <span>{{ $reservationGrowth ?? 8.3 }}%</span> since last month
                                </p>
                            </div>
                            <div class="dashboard-icon">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card dashboard-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Total Cars</h6>
                                <h2 class="mb-0">{{ $totalCars ?? 156 }}</h2>
                                <p class="text-danger mb-0">
                                    <i class="bi bi-arrow-down-right"></i>
                                    <span>{{ $carsAvailable ?? 78 }}</span> available now
                                </p>
                            </div>
                            <div class="dashboard-icon">
                                <i class="bi bi-car-front"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card dashboard-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Total Customers</h6>
                                <h2 class="mb-0">{{ $totalCustomers ?? 872 }}</h2>
                                <p class="text-success mb-0">
                                    <i class="bi bi-arrow-up-right"></i>
                                    <span>{{ $newCustomers ?? 15 }}</span> new this week
                                </p>
                            </div>
                            <div class="dashboard-icon">
                                <i class="bi bi-people"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Revenue Overview</h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                id="revenueTimeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Last 6 Months
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="revenueTimeDropdown">
                                <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                                <li><a class="dropdown-item" href="#">Last 6 Months</a></li>
                                <li><a class="dropdown-item" href="#">Last Year</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart" height="300"></canvas>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Reservations</h5>
                        <a href="{{ route('admin.reservations.index') }}" class="btn btn-sm btn-primary">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer</th>
                                        <th>Car</th>
                                        <th>Pickup Date</th>
                                        <th>Return Date</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentReservations ?? [] as $reservation)
                                        <tr>
                                            <td>{{ $reservation->id }}</td>
                                            <td>{{ $reservation->user->name }}</td>
                                            <td>{{ $reservation->car->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($reservation->pickup_date)->format('M d, Y') }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($reservation->return_date)->format('M d, Y') }}
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $reservation->status_color }}">{{ $reservation->status }}</span>
                                            </td>
                                            <td>${{ number_format($reservation->total_price, 2) }}</td>
                                            <td>
                                                <a href="{{ route('admin.reservations.show', $reservation->id) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    <!-- Sample data if no reservations are provided -->
                                    @if (empty($recentReservations))
                                        <tr>
                                            <td>#RES-5439</td>
                                            <td>John Smith</td>
                                            <td>Toyota Camry</td>
                                            <td>Mar 15, 2025</td>
                                            <td>Mar 18, 2025</td>
                                            <td><span class="badge bg-success">Active</span></td>
                                            <td>$243.00</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>#RES-5438</td>
                                            <td>Sarah Johnson</td>
                                            <td>Honda Civic</td>
                                            <td>Mar 14, 2025</td>
                                            <td>Mar 21, 2025</td>
                                            <td><span class="badge bg-success">Active</span></td>
                                            <td>$480.00</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>#RES-5437</td>
                                            <td>Michael Brown</td>
                                            <td>Mercedes-Benz E-Class</td>
                                            <td>Mar 12, 2025</td>
                                            <td>Mar 19, 2025</td>
                                            <td><span class="badge bg-warning">Pending</span></td>
                                            <td>$1,250.00</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>#RES-5436</td>
                                            <td>Emily Wilson</td>
                                            <td>Kia Sportage</td>
                                            <td>Mar 10, 2025</td>
                                            <td>Mar 13, 2025</td>
                                            <td><span class="badge bg-primary">Completed</span></td>
                                            <td>$210.00</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>#RES-5435</td>
                                            <td>David Clark</td>
                                            <td>Nissan Altima</td>
                                            <td>Mar 08, 2025</td>
                                            <td>Mar 11, 2025</td>
                                            <td><span class="badge bg-danger">Cancelled</span></td>
                                            <td>$180.00</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Car Availability</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="availabilityChart" height="260"></canvas>
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Recent Activity</h5>
                    </div>
                    <div class="card-body">
                        <div class="activity-timeline">
                            @foreach ($recentActivities ?? [] as $activity)
                                <div class="timeline-item">
                                    <div class="timeline-point"></div>
                                    <div class="timeline-content">
                                        <p class="mb-1">{{ $activity->description }}</p>
                                        <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Sample data if no activities are provided -->
                            @if (empty($recentActivities))
                                <div class="timeline-item">
                                    <div class="timeline-point"></div>
                                    <div class="timeline-content">
                                        <p class="mb-1">New reservation created by <strong>John Smith</strong></p>
                                        <small class="text-muted">10 minutes ago</small>
                                    </div>
                                </div>

                                <div class="timeline-item">
                                    <div class="timeline-point"></div>
                                    <div class="timeline-content">
                                        <p class="mb-1">Car <strong>Toyota Camry (ABC-123)</strong> returned</p>
                                        <small class="text-muted">1 hour ago</small>
                                    </div>
                                </div>

                                <div class="timeline-item">
                                    <div class="timeline-point"></div>
                                    <div class="timeline-content">
                                        <p class="mb-1">New car <strong>Mercedes-Benz GLC</strong> added to fleet</p>
                                        <small class="text-muted">3 hours ago</small>
                                    </div>
                                </div>

                                <div class="timeline-item">
                                    <div class="timeline-point"></div>
                                    <div class="timeline-content">
                                        <p class="mb-1">Payment received from <strong>Sarah Johnson</strong></p>
                                        <small class="text-muted">5 hours ago</small>
                                    </div>
                                </div>

                                <div class="timeline-item">
                                    <div class="timeline-point"></div>
                                    <div class="timeline-content">
                                        <p class="mb-1">Maintenance scheduled for <strong>Honda Civic (XYZ-789)</strong>
                                        </p>
                                        <small class="text-muted">Yesterday</small>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.cars.create') }}" class="btn btn-outline-primary">
                                <i class="bi bi-plus-circle me-2"></i>Add New Car
                            </a>
                            <a href="{{ route('admin.reservations.create') }}" class="btn btn-outline-primary">
                                <i class="bi bi-calendar-plus me-2"></i>Create Reservation
                            </a>
                            <a href="{{ route('admin.users.create') }}" class="btn btn-outline-primary">
                                <i class="bi bi-person-plus me-2"></i>Add New User
                            </a>
                            <a href="{{ route('admin.maintenance.index') }}" class="btn btn-outline-primary">
                                <i class="bi bi-tools me-2"></i>Schedule Maintenance
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Modal -->
    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel">Generate Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="reportType" class="form-label">Report Type</label>
                            <select class="form-select" id="reportType" required>
                                <option value="">Select report type</option>
                                <option value="revenue">Revenue Report</option>
                                <option value="reservations">Reservations Report</option>
                                <option value="cars">Car Utilization Report</option>
                                <option value="customers">Customer Activity Report</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="dateRange" class="form-label">Date Range</label>
                            <select class="form-select" id="dateRange" required>
                                <option value="">Select date range</option>
                                <option value="last_week">Last Week</option>
                                <option value="last_month">Last Month</option>
                                <option value="last_quarter">Last Quarter</option>
                                <option value="last_year">Last Year</option>
                                <option value="custom">Custom Range</option>
                            </select>
                        </div>

                        <div class="row mb-3" id="customDateRange" style="display: none;">
                            <div class="col-md-6">
                                <label for="startDate" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="startDate">
                            </div>
                            <div class="col-md-6">
                                <label for="endDate" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="endDate">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="fileFormat" class="form-label">Format</label>
                            <select class="form-select" id="fileFormat" required>
                                <option value="pdf">PDF</option>
                                <option value="excel">Excel</option>
                                <option value="csv">CSV</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Generate Report</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            const revenueChart = new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: ['October', 'November', 'December', 'January', 'February', 'March'],
                    datasets: [{
                        label: 'Revenue',
                        data: [4500, 5200, 7800, 6200, 8100, 9300],
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '$' + value;
                                }
                            }
                        }
                    }
                }
            });

            // Car Availability Chart
            const availabilityCtx = document.getElementById('availabilityChart').getContext('2d');
            const availabilityChart = new Chart(availabilityCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Available', 'Rented', 'Maintenance'],
                    datasets: [{
                        data: [78, 42, 36],
                        backgroundColor: ['#0d6efd', '#dc3545', '#ffc107'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // Show custom date range when custom option is selected
            document.getElementById('dateRange').addEventListener('change', function() {
                const customDateRange = document.getElementById('customDateRange');
                customDateRange.style.display = this.value === 'custom' ? 'flex' : 'none';
            });
        });
    </script>
@endsection
