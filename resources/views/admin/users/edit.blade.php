@extends('layouts.app')

@section('title', 'Edit User')

@section('styles')
    <style>
        .form-section {
            margin-bottom: 2rem;
        }

        .form-section-title {
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #dee2e6;
        }
    </style>
@endsection

@section('content')
    <div class="container my-4">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="mb-0">Edit User</h1>
                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to User
                    </a>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('admin.users.update', $user) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-section">
                                <h4 class="form-section-title">Personal Information</h4>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Account Settings</h4>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_admin" name="is_admin"
                                            value="1" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_admin">Administrator access</label>
                                    </div>
                                    <div class="form-text">Administrators can manage cars, reservations, and users.</div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Change Password</h4>
                                <p class="text-muted mb-3">Leave these fields empty if you don't want to change the
                                    password.</p>

                                <div class="mb-3">
                                    <label for="password" class="form-label">New Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation">
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="button" onclick="location.href='{{ route('admin.users.show', $user) }}'"
                                    class="btn btn-outline-secondary me-md-2">Cancel</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">User Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3 p-3 bg-light rounded-circle">
                                <i class="fas fa-user text-primary fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $user->name }}</h6>
                                <p class="text-muted mb-0">{{ $user->email }}</p>
                            </div>
                        </div>

                        <hr>

                        <div class="mb-2">
                            <span class="text-muted">Role:</span>
                            <span class="badge {{ $user->is_admin ? 'bg-primary' : 'bg-success' }} ms-2">
                                {{ $user->is_admin ? 'Admin' : 'Client' }}
                            </span>
                        </div>

                        <div class="mb-2">
                            <span class="text-muted">Account Created:</span>
                            <span class="ms-2">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>

                        <div>
                            <span class="text-muted">Last Updated:</span>
                            <span class="ms-2">{{ $user->updated_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-primary">
                                <i class="fas fa-eye me-2"></i>View User
                            </a>
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteUserModal">
                                <i class="fas fa-trash-alt me-2"></i>Delete User
                            </button>
                        </div>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
