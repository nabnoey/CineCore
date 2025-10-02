@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-5">
        <div class="card shadow-lg border-0 rounded-4">
            <!-- Header -->
            <div class="card-header text-center bg-dark text-white rounded-top-4 py-3">
                <h4 class="mb-0">{{ __('Login') }}</h4>
            </div>

            <!-- Body -->
            <div class="card-body p-4">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">{{ __('Email Address') }}</label>
                        <input id="email" type="email" 
                               class="form-control @error('email') is-invalid @enderror rounded-pill"
                               name="email" value="{{ old('email') }}" 
                               required autocomplete="email" autofocus
                               placeholder="example@mail.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">{{ __('Password') }}</label>
                        <input id="password" type="password" 
                               class="form-control @error('password') is-invalid @enderror rounded-pill"
                               name="password" required autocomplete="current-password"
                               placeholder="Enter your password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                               {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>

                    <!-- Submit + Forgot Password -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark rounded-pill py-2 fw-semibold">
                            {{ __('Login') }}
                        </button>
                    </div>

                    @if (Route::has('password.request'))
                        <div class="text-center mt-3">
                            <a class="text-decoration-none fw-semibold small" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        <!-- Register Link -->
        <div class="text-center mt-3">
            <small class="text-muted">Don't have an account? 
                <a href="{{ route('register') }}" class="fw-semibold text-dark text-decoration-none">Register</a>
            </small>
        </div>
    </div>
</div>
@endsection
