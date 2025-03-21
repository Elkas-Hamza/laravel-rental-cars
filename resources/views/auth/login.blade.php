@extends('layouts.app')

@section('title', 'Login')

@section('styles')
    <style>
        .auth-container {
            max-width: 450px;
            margin: 0 auto;
        }

        .login-card {
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
            <div class="card login-card">
                <div class="card-body p-4 p-md-5">
                    <h1 class="text-center auth-heading">Login</h1>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
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
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Remember Me
                            </label>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100 auth-btn">
                                Login
                            </button>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-center mb-3">
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        @endif
                    </form>

                    <div class="auth-separator">
                        <span>OR</span>
                    </div>

                    <div class="text-center">
                        <p class="mb-0">Don't have an account?</p>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary mt-2 w-100 auth-btn">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
