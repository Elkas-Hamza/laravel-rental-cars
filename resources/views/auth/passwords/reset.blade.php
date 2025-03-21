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

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm" class="form-label">Confirm New Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                required autocomplete="new-password">
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100 auth-btn">
                                Reset Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
