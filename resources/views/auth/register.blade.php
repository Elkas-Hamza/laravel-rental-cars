@extends('layouts.app')

@section('title', 'Register')

@section('styles')
    <style>
        .auth-container {
            max-width: 450px;
            margin: 0 auto;
        }

        .register-card {
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

        .auth-separator {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
        }

        .auth-separator::before,
        .auth-separator::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #dee2e6;
        }

        .auth-separator span {
            padding: 0 1rem;
            color: #6c757d;
        }
    </style>
@endsection

@section('content')
    <div class="container my-5">
        <div class="auth-container">
            <div class="card register-card">
                <div class="card-body p-4 p-md-5">
                    <h1 class="text-center auth-heading">Register</h1>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                                name="phone" value="{{ old('phone') }}" required autocomplete="tel">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                required autocomplete="new-password">
                        </div>

                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                            <label class="form-check-label" for="terms">
                                I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy
                                    Policy</a>
                            </label>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100 auth-btn">
                                Register
                            </button>
                        </div>
                    </form>

                    <div class="auth-separator">
                        <span>OR</span>
                    </div>

                    <div class="text-center">
                        <p class="mb-0">Already have an account?</p>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary mt-2 w-100 auth-btn">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
