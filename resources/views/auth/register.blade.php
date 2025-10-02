@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 700px;">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg border-0" style="border-radius: 15px;">
                <div class="card-header text-center bg-dark text-white rounded-top-4 py-3" 
                     style="background-color: #000000; border-radius: 15px 15px 0 0;">
                    <h4 class="mb-0">{{ __('Register') }}</h4>
                </div>

                <div class="card-body p-4" style="background-color: #f9fbfd;">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- Name --}}
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                    style="border-radius: 10px;">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Email Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    name="email" value="{{ old('email') }}" required autocomplete="email"
                                    style="border-radius: 10px;">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    name="password" required autocomplete="new-password"
                                    style="border-radius: 10px;">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Confirm Password --}}
                        <div class="row mb-4">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Confirm Password') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" 
                                    class="form-control" 
                                    name="password_confirmation" required autocomplete="new-password"
                                    style="border-radius: 10px;">
                            </div>
                        </div>

                        {{-- Button --}}
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                             <button type="submit" 
        class="btn w-100 text-white" 
        style="background-color: #000000; border-radius: 10px; font-weight: bold; padding: 10px 0;">
    {{ __('Register') }}
</button>
                            </div>
                        </div>
                    </form>
                </div> {{-- card-body --}}
            </div>
        </div>
    </div>
</div>
@endsection
