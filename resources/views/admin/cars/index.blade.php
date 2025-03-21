@extends('layouts.app')

@section('title', 'Car Management')

@section('styles')
    <style>
        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }

        .status-available {
            background-color: #28a745;
        }

        .status-rented {
            background-color: #dc3545;
        }

        .status-maintenance {
            background-color: #ffc107;
        }

        .car-card {
            transition: all 0.3s ease;
            border: none;
        }

        .car-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .car-image-container {
            height: 200px;
            overflow: hidden;
            border-radius: 0.25rem 0.25rem 0 0;
        }

        .car-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .car-card:hover .car-image {
            transform: scale(1.1);
        }

        .car-spec {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .car-spec i {
            width: 20px;
            margin-right: 8px;
            color: var(--primary-color);
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid my-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Car Management</h1>
            <a href="{{ route('admin.cars.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-2"></i>Add New Car
            </a>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                            <input type="text" id="searchInput" class="form-control border-start-0"
                                placeholder="Search cars...">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <select id="statusFilter" class="form-select">
                            <option value="">All Statuses</option>
                            <option value="available">Available</option>
                            <option value="rented">Rented</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select id="categoryFilter" class="form-select">
                            <option value="">All Categories</option>
                            <option value="sedan">Sedan</option>
                            <option value="suv">SUV</option>
                            <option value="luxury">Luxury</option>
                            <option value="sports">Sports</option>
                            <option value="electric">Electric</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select id="sortBy" class="form-select">
                            <option value="newest">Newest First</option>
                            <option value="oldest">Oldest First</option>
                            <option value="price_asc">Price: Low to High</option>
                            <option value="price_desc">Price: High to Low</option>
                            <option value="name_asc">Name: A to Z</option>
                            <option value="name_desc">Name: Z to A</option>
                        </select>
                    </div>

                    <div class="col-md-3 text-md-end">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-primary active" id="gridViewBtn">
                                <i class="bi bi-grid-3x3-gap-fill"></i>
                            </button>
                            <button type="button" class="btn btn-outline-primary" id="listViewBtn">
                                <i class="bi bi-list-ul"></i>
                            </button>
                        </div>
                        <button type="button" class="btn btn-outline-primary ms-2" id="downloadCarList">
                            <i class="bi bi-download me-2"></i>Export
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <span class="text-muted">Showing <span id="countCars">{{ $cars->count() ?? 24 }}</span> of <span
                    id="totalCars">{{ $cars->total() ?? 58 }}</span> cars</span>
        </div>

        <!-- Grid View -->
        <div id="gridView" class="row g-4">
            @forelse($cars ?? [] as $car)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card car-card shadow-sm h-100">
                        <div class="car-image-container">
                            <img src="{{ asset($car->image_url) }}" class="car-image" alt="{{ $car->name }}">
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title mb-0">{{ $car->name }}</h5>
                                <span
                                    class="badge bg-{{ $car->status == 'available' ? 'success' : ($car->status == 'rented' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($car->status) }}
                                </span>
                            </div>
                            <p class="card-text text-muted">{{ $car->category }} • {{ $car->year }}</p>
                            <div class="car-spec">
                                <i class="bi bi-gear-fill"></i>
                                <span>{{ $car->transmission }}</span>
                            </div>
                            <div class="car-spec">
                                <i class="bi bi-fuel-pump-fill"></i>
                                <span>{{ $car->fuel_type }}</span>
                            </div>
                            <div class="car-spec">
                                <i class="bi bi-people-fill"></i>
                                <span>{{ $car->seats }} Seats</span>
                            </div>
                            <div class="mt-3">
                                <h6 class="mb-0">${{ number_format($car->price_per_day, 2) }} / day</h6>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top-0">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.cars.show', $car->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i>View
                                </a>
                                <a href="{{ route('admin.cars.edit', $car->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteCarModal" data-car-id="{{ $car->id }}"
                                    data-car-name="{{ $car->name }}">
                                    <i class="bi bi-trash me-1"></i>Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Sample data if no cars are provided -->
                @for ($i = 1; $i <= 8; $i++)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="card car-card shadow-sm h-100">
                            <div class="car-image-container">
                                <img src="{{ asset('images/cars/car' . (($i % 4) + 1) . '.jpg') }}" class="car-image"
                                    alt="Car Sample">
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="card-title mb-0">
                                        @if ($i % 4 == 0)
                                            Honda Civic
                                        @elseif($i % 4 == 1)
                                            Toyota Camry
                                        @elseif($i % 4 == 2)
                                            Tesla Model 3
                                        @else
                                            Mercedes-Benz C-Class
                                        @endif
                                    </h5>
                                    <span
                                        class="badge bg-{{ $i % 3 == 0 ? 'success' : ($i % 3 == 1 ? 'danger' : 'warning') }}">
                                        {{ $i % 3 == 0 ? 'Available' : ($i % 3 == 1 ? 'Rented' : 'Maintenance') }}
                                    </span>
                                </div>
                                <p class="card-text text-muted">
                                    @if ($i % 4 == 0)
                                        Sedan • 2023
                                    @elseif($i % 4 == 1)
                                        Sedan • 2022
                                    @elseif($i % 4 == 2)
                                        Electric • 2024
                                    @else
                                        Luxury • 2023
                                    @endif
                                </p>
                                <div class="car-spec">
                                    <i class="bi bi-gear-fill"></i>
                                    <span>{{ $i % 2 == 0 ? 'Automatic' : 'Manual' }}</span>
                                </div>
                                <div class="car-spec">
                                    <i class="bi bi-fuel-pump-fill"></i>
                                    <span>
                                        @if ($i % 4 == 0)
                                            Gasoline
                                        @elseif($i % 4 == 1)
                                            Hybrid
                                        @elseif($i % 4 == 2)
                                            Electric
                                        @else
                                            Diesel
                                        @endif
                                    </span>
                                </div>
                                <div class="car-spec">
                                    <i class="bi bi-people-fill"></i>
                                    <span>{{ 4 + ($i % 3) }} Seats</span>
                                </div>
                                <div class="mt-3">
                                    <h6 class="mb-0">
                                        @if ($i % 4 == 0)
                                            $35.00 / day
                                        @elseif($i % 4 == 1)
                                            $45.00 / day
                                        @elseif($i % 4 == 2)
                                            $75.00 / day
                                        @else
                                            $120.00 / day
                                        @endif
                                    </h6>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-top-0">
                                <div class="d-flex justify-content-between">
                                    <a href="#" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i>View
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil me-1"></i>Edit
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteCarModal" data-car-id="{{ $i }}"
                                        data-car-name="Car Sample {{ $i }}">
                                        <i class="bi bi-trash me-1"></i>Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            @endforelse
        </div>

        <!-- List View (Hidden by default) -->
        <div id="listView" class="d-none">
            <div class="card shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Year</th>
                                <th>Price/Day</th>
                                <th>Status</th>
                                <th>License Plate</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cars ?? [] as $car)
                                <tr>
                                    <td style="width: 100px;">
                                        <img src="{{ asset($car->image_url) }}" class="img-thumbnail"
                                            alt="{{ $car->name }}"
                                            style="width: 80px; height: 60px; object-fit: cover;">
                                    </td>
                                    <td>{{ $car->name }}</td>
                                    <td>{{ $car->category }}</td>
                                    <td>{{ $car->year }}</td>
                                    <td>${{ number_format($car->price_per_day, 2) }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $car->status == 'available' ? 'success' : ($car->status == 'rented' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($car->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $car->license_plate }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.cars.show', $car->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.cars.edit', $car->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal" data-bs-target="#deleteCarModal"
                                                data-car-id="{{ $car->id }}" data-car-name="{{ $car->name }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <!-- Sample data if no cars are provided -->
                                @for ($i = 1; $i <= 8; $i++)
                                    <tr>
                                        <td style="width: 100px;">
                                            <img src="{{ asset('images/cars/car' . (($i % 4) + 1) . '.jpg') }}"
                                                class="img-thumbnail"
                                                style="width: 80px; height: 60px; object-fit: cover;" alt="Car Sample">
                                        </td>
                                        <td>
                                            @if ($i % 4 == 0)
                                                Honda Civic
                                            @elseif($i % 4 == 1)
                                                Toyota Camry
                                            @elseif($i % 4 == 2)
                                                Tesla Model 3
                                            @else
                                                Mercedes-Benz C-Class
                                            @endif
                                        </td>
                                        <td>
                                            @if ($i % 4 == 0)
                                                Sedan
                                            @elseif($i % 4 == 1)
                                                Sedan
                                            @elseif($i % 4 == 2)
                                                Electric
                                            @else
                                                Luxury
                                            @endif
                                        </td>
                                        <td>
                                            @if ($i % 4 == 0)
                                                2023
                                            @elseif($i % 4 == 1)
                                                2022
                                            @elseif($i % 4 == 2)
                                                2024
                                            @else
                                                2023
                                            @endif
                                        </td>
                                        <td>
                                            @if ($i % 4 == 0)
                                                $35.00
                                            @elseif($i % 4 == 1)
                                                $45.00
                                            @elseif($i % 4 == 2)
                                                $75.00
                                            @else
                                                $120.00
                                            @endif
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $i % 3 == 0 ? 'success' : ($i % 3 == 1 ? 'danger' : 'warning') }}">
                                                {{ $i % 3 == 0 ? 'Available' : ($i % 3 == 1 ? 'Rented' : 'Maintenance') }}
                                            </span>
                                        </td>
                                        <td>{{ 'ABC-' . rand(100, 999) }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="#" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    data-bs-toggle="modal" data-bs-target="#deleteCarModal"
                                                    data-car-id="{{ $i }}"
                                                    data-car-name="Car Sample {{ $i }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endfor
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            <!-- Pagination Links -->
            {{ $cars->links() ?? '' }}

            <!-- Sample pagination if no cars data provided -->
            @if (empty($cars))
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            @endif
        </div>
    </div>

    <!-- Delete Car Modal -->
    <div class="modal fade" id="deleteCarModal" tabindex="-1" aria-labelledby="deleteCarModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCarModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong id="carNameToDelete"></strong>?</p>
                    <p class="text-danger mb-0">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteCarForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Grid/List View Toggle
            const gridView = document.getElementById('gridView');
            const listView = document.getElementById('listView');
            const gridViewBtn = document.getElementById('gridViewBtn');
            const listViewBtn = document.getElementById('listViewBtn');

            gridViewBtn.addEventListener('click', function() {
                gridView.classList.remove('d-none');
                listView.classList.add('d-none');
                gridViewBtn.classList.add('active');
                listViewBtn.classList.remove('active');
            });

            listViewBtn.addEventListener('click', function() {
                gridView.classList.add('d-none');
                listView.classList.remove('d-none');
                gridViewBtn.classList.remove('active');
                listViewBtn.classList.add('active');
            });

            // Delete Car Modal
            const deleteCarModal = document.getElementById('deleteCarModal');
            deleteCarModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const carId = button.getAttribute('data-car-id');
                const carName = button.getAttribute('data-car-name');

                const carNameToDelete = document.getElementById('carNameToDelete');
                const deleteCarForm = document.getElementById('deleteCarForm');

                carNameToDelete.textContent = carName;
                deleteCarForm.action = `/admin/cars/${carId}`;
            });

            // Search Input Functionality (just an example, actual implementation would depend on your backend)
            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('input', function() {
                // You'd typically send this to your backend or filter the frontend data
                console.log('Searching for:', searchInput.value);
            });

            // Filter Functionality (just an example)
            const statusFilter = document.getElementById('statusFilter');
            statusFilter.addEventListener('change', function() {
                console.log('Filtering by status:', statusFilter.value);
            });

            const categoryFilter = document.getElementById('categoryFilter');
            categoryFilter.addEventListener('change', function() {
                console.log('Filtering by category:', categoryFilter.value);
            });

            // Sort Functionality (just an example)
            const sortBy = document.getElementById('sortBy');
            sortBy.addEventListener('change', function() {
                console.log('Sorting by:', sortBy.value);
            });

            // Export Button (just an example)
            const downloadCarList = document.getElementById('downloadCarList');
            downloadCarList.addEventListener('click', function() {
                console.log('Exporting car list...');
                alert('Car list export started. The file will be downloaded shortly.');
            });
        });
    </script>
@endsection
