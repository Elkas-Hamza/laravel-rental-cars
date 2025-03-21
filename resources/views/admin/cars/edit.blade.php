@extends('layouts.app')

@section('title', 'Edit Car')

@section('content')
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Edit Car</h5>
                            <a href="{{ route('admin.cars.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-arrow-left me-1"></i>Back to Cars
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.cars.update', $car->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Car Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name', $car->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Category <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select @error('category') is-invalid @enderror" id="category"
                                            name="category" required>
                                            <option value="">Select Category</option>
                                            <option value="sedan"
                                                {{ old('category', $car->category) == 'sedan' ? 'selected' : '' }}>Sedan
                                            </option>
                                            <option value="suv"
                                                {{ old('category', $car->category) == 'suv' ? 'selected' : '' }}>SUV
                                            </option>
                                            <option value="luxury"
                                                {{ old('category', $car->category) == 'luxury' ? 'selected' : '' }}>Luxury
                                            </option>
                                            <option value="sports"
                                                {{ old('category', $car->category) == 'sports' ? 'selected' : '' }}>Sports
                                            </option>
                                            <option value="electric"
                                                {{ old('category', $car->category) == 'electric' ? 'selected' : '' }}>
                                                Electric</option>
                                        </select>
                                        @error('category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                            rows="4" required>{{ old('description', $car->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="price_per_day" class="form-label">Price Per Day ($) <span
                                                class="text-danger">*</span></label>
                                        <input type="number"
                                            class="form-control @error('price_per_day') is-invalid @enderror"
                                            id="price_per_day" name="price_per_day"
                                            value="{{ old('price_per_day', $car->price_per_day) }}" step="0.01"
                                            min="0" required>
                                        @error('price_per_day')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="year" class="form-label">Year <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('year') is-invalid @enderror"
                                            id="year" name="year" value="{{ old('year', $car->year) }}"
                                            min="1900" max="{{ date('Y') + 1 }}" required>
                                        @error('year')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="seats" class="form-label">Seats <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('seats') is-invalid @enderror"
                                            id="seats" name="seats" value="{{ old('seats', $car->seats) }}"
                                            min="1" max="12" required>
                                        @error('seats')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="transmission" class="form-label">Transmission <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select @error('transmission') is-invalid @enderror"
                                            id="transmission" name="transmission" required>
                                            <option value="">Select Transmission</option>
                                            <option value="automatic"
                                                {{ old('transmission', $car->transmission) == 'automatic' ? 'selected' : '' }}>
                                                Automatic</option>
                                            <option value="manual"
                                                {{ old('transmission', $car->transmission) == 'manual' ? 'selected' : '' }}>
                                                Manual</option>
                                        </select>
                                        @error('transmission')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="fuel_type" class="form-label">Fuel Type <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select @error('fuel_type') is-invalid @enderror"
                                            id="fuel_type" name="fuel_type" required>
                                            <option value="">Select Fuel Type</option>
                                            <option value="gasoline"
                                                {{ old('fuel_type', $car->fuel_type) == 'gasoline' ? 'selected' : '' }}>
                                                Gasoline</option>
                                            <option value="diesel"
                                                {{ old('fuel_type', $car->fuel_type) == 'diesel' ? 'selected' : '' }}>
                                                Diesel</option>
                                            <option value="electric"
                                                {{ old('fuel_type', $car->fuel_type) == 'electric' ? 'selected' : '' }}>
                                                Electric</option>
                                            <option value="hybrid"
                                                {{ old('fuel_type', $car->fuel_type) == 'hybrid' ? 'selected' : '' }}>
                                                Hybrid</option>
                                        </select>
                                        @error('fuel_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="license_plate" class="form-label">License Plate <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('license_plate') is-invalid @enderror"
                                            id="license_plate" name="license_plate"
                                            value="{{ old('license_plate', $car->license_plate) }}" required>
                                        @error('license_plate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select @error('status') is-invalid @enderror" id="status"
                                            name="status" required>
                                            <option value="">Select Status</option>
                                            <option value="available"
                                                {{ old('status', $car->status) == 'available' ? 'selected' : '' }}>
                                                Available</option>
                                            <option value="rented"
                                                {{ old('status', $car->status) == 'rented' ? 'selected' : '' }}>Rented
                                            </option>
                                            <option value="maintenance"
                                                {{ old('status', $car->status) == 'maintenance' ? 'selected' : '' }}>
                                                Maintenance</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Car Image</label>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                                            id="image" name="image" accept="image/*">
                                        <div class="form-text">Leave empty to keep the current image. Max file size: 2MB.
                                            Supported formats: JPEG, PNG, JPG, GIF.</div>
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mt-2" id="currentImageContainer">
                                        <p class="mb-1">Current Image:</p>
                                        <img src="{{ asset($car->image_url) }}" alt="{{ $car->name }}"
                                            class="img-thumbnail" style="max-height: 200px;">
                                    </div>

                                    <div class="mt-2" id="imagePreviewContainer" style="display: none;">
                                        <p class="mb-1">New Image Preview:</p>
                                        <img id="imagePreview" src="#" alt="Car Image Preview"
                                            class="img-thumbnail" style="max-height: 200px;">
                                    </div>
                                </div>

                                <div class="col-12 text-end">
                                    <hr>
                                    <a href="{{ route('admin.cars.index') }}" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Update Car</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Image preview functionality
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('imagePreview');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');

            imageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreviewContainer.style.display = 'block';
                    }

                    reader.readAsDataURL(this.files[0]);
                } else {
                    imagePreviewContainer.style.display = 'none';
                }
            });
        });
    </script>
@endsection
