@extends('layouts.app')

@section('title', 'My Profile')

@section('styles')
    <style>
        .profile-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .profile-card {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border-radius: 0.5rem;
        }

        .profile-image {
            width: 128px;
            height: 128px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #fff;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .form-control {
            padding: 0.75rem 1rem;
        }

        .profile-btn {
            padding: 0.75rem 1rem;
            font-weight: 600;
        }
    </style>
@endsection

@section('content')
    <div class="container my-5">
        <div class="profile-container">
            <div class="card profile-card">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <h1 class="mb-3">My Profile</h1>
                        <div class="mb-3">
                            @if ($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}"
                                    class="profile-image">
                            @else
                                <div class="profile-image d-flex align-items-center justify-content-center bg-light">
                                    <i class="bi bi-person-fill display-4 text-secondary"></i>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name', $user->name) }}" required autocomplete="name">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="photo" class="form-label">Profile Photo</label>
                            <input id="photo" type="file" class="form-control @error('photo') is-invalid @enderror"
                                name="photo" accept="image/*">
                            @error('photo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="form-text">Leave empty to keep current photo</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary profile-btn">Update Profile</button>
                            <a href="{{ route('password.request') }}" class="btn btn-outline-secondary profile-btn">Change
                                Password</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
