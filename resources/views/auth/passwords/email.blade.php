@extends('layouts.app')

@section('title', 'Reset Password')

@section('styles')
    <style>
        .auth-container {
            max-width: 450px;
            margin: 0 auto;
        }

        .reset-card {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border-radius: 0.5rem;
        }

        .auth-heading {
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .form-control {
            padding: 0.75rem 1rem;
        }

        .auth-btn {
            padding: 0.75rem 1rem;
            font-weight: 600;
        }
    </style>
@endsection

@section('content')
    <div class="container my-5">
        <div class="auth-container">
            <div class="card reset-card">
                <div class="card-body p-4 p-md-5">
                    <h1 class="text-center auth-heading">Reset Password</h1>

                    @if (session('status'))
                        <div class="alert alert-success mb-4" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p class="text-muted mb-4">Enter your email address and we'll send you a link to reset your password.</p>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100 auth-btn">
                                Send Password Reset Link
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="btn btn-link">
                            <i class="bi bi-arrow-left me-1"></i> Back to Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
